%------------------------------------------
% Groupe :      7C
% Description : Cette fonction traite le signal audio fourni avec readaudio 
%               en le convertissant en dBm et identifie les segments invalides.
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
%   buffer          Vecteur     Tampon pour l'analyse des segments invalides
%   skipFor         Entier      Variable de saut pour l'analyse des segments invalides
%
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

    for i = 1:length(y)
        if skipFor > 0
            skipFor = skipFor - 1;
            continue;
        end
        if y(i) == Inf || y(i) == -Inf
            continue
        end
        if y(i) >= seuilDetectionDBm
            buffer = [];
            for j = 1+i:fs+i
                if length(y) < j
                    continue
                end
                value = y(j);
                if value == Inf || value == -Inf
                    continue
                end
                buffer = [buffer; value];
            end
            if mean(buffer) >= seuilDetectionDBm
                skipFor = j - i;
                invalidList = [invalidList; [i, j]];
            end
        end
    end
end