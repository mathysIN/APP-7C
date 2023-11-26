%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction traite le signal audio fourni avec readaudio 
%               en le convertissant en dBm et identifie les segments invalides.
%               Elle a été optimisée pour réduire la consommation mémoire.
%
% Entrées :
%   y               Vecteur      Signal audio d'entrée
%   fs              Double       Fréquence d'échantillonnage du signal
%
% Sorties :
%   y               Vecteur      Signal audio en dBm
%   seuilDetectionDBm  Double    Seuil de détection en dBm
%   invalidList     Matrice     Liste des segments invalides [début, fin]
%
% Modifiées :       Aucune
%
% Locales :
%   sensitivity     Double      Sensibilité pour le calcul du seuil
%   gain            Double      Gain pour le calcul du seuil
%   seuilDetectionSPL  Double   Seuil de détection en SPL
%   dB_RMS          Double      Niveau en dB RMS
%   V_RMS           Double      Niveau RMS en Volts
%   invalidList     Matrice     Liste des segments invalides [début, fin]
%   skipFor         Entier      Variable de saut pour l'analyse des segments invalides
%   buffer          Vecteur     Tampon pour l'analyse des segments invalides
%   bufferIndex     Vecteur     Indices de tampon pour la gestion mémoire optimisée
%   j               Entier      Indice pour la gestion mémoire optimisée
%   i               Entier      Indice principal
%   value           Double      Valeur courante du signal audio
%   average         Double      Moyenne du tampon pour la détection des segments invalides
%   second          Double      Seconde correspondante à l'indice i
%------------------------------------------

function [y, seuilDetectionDBm, invalidList] = process_data(y, fs)
    sensitivity = -48;
    gain = 30;
    seuilDetectionSPL = 80;
    dB_RMS = seuilDetectionSPL+sensitivity-94;
    V_RMS = 10^(dB_RMS/20);

    seuilDetectionDBm = 10*log10(V_RMS^2/1e-3)+gain;
    y = 10*log10((y.^2)/1e-3);

    invalidList = [];
    skipFor = 0;
    buffer = [];
    bufferIndex = zeros(1, length(y));
    j = 1;

    for i = 1:length(y)
        if not(isempty(buffer))
            if(bufferIndex(i) == 2)
                buffer = buffer(2:end);
            end
        end
        if skipFor > 0
            skipFor = skipFor - 1;
            continue;
        end
        if y(i) == Inf || y(i) == -Inf
            continue
        end
        if y(i) >= seuilDetectionDBm
            if(j < i) 
                j = i;
            end
            while (j - i) < fs && length(y) > j
                value = y(j);
                if value == Inf || value == -Inf
                    bufferIndex(j) = 1;
                else
                    bufferIndex(j) = 2;
                    buffer = [buffer value];
                end
                j = j + 1;
            end
            average = mean(buffer);
            if average >= seuilDetectionDBm
                second = i / fs;
                buffer = [];
                skipFor = j - i;
                invalidList = [invalidList; [i, j]];
            end
        end
    end
end