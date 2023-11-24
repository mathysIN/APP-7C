%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction traite les données audio en dBm, détecte les valeurs
%               invalides et renvoie le signal traité, le seuil de détection en dBm,
%               et la liste des secondes considérées invalides.
% Entrées :
%   y           Vecteur     Signal audio fourni par la fonction readaudio
%   fs          Double      Fréquence d'échantillonnage du signal audio
%   step        Double      Pas de temps en secondes pour l'analyse
%
% Sorties :
%   y               Vecteur     Signal audio traité en dBm
%   seuilDetectionDBm   Double      Seuil de détection en dBm
%   invalidList     Vecteur     Liste des secondes considérées invalides
%
% Modifiées :   Aucune
%
% Locales :
%   sensitivity             Double      Sensibilité de la détection en dB
%   gain                    Double      Gain du signal
%   seuilDetectionSPL       Double      Seuil de détection en SPL
%   dB_RMS                  Double      Niveau en dB RMS
%   V_RMS                   Double      Niveau en V RMS
%   bufferInvalid           Entier      Compteur pour les échantillons invalides
%   i                       Entier      Indice de boucle
%------------------------------------------

function [y, seuilDetectionDBm, invalidList] = process_data(y, fs, step)
    sensitivity = -48;
    gain = 30;
    seuilDetectionSPL = 80;
    dB_RMS = seuilDetectionSPL+sensitivity-94;
    V_RMS = 10^(dB_RMS/20);

    seuilDetectionDBm = 10*log10(V_RMS^2/1e-3)+gain;
    y = 10*log10((y.^2)/1e-3);

    invalidList = [];
    
    skipFor = 0;

    disp(length(y));
    for i = 1:length(y)
        if skipFor > 0
            skipFor = skipFor - 1;
            continue;
        end
        
        if y(i) > seuilDetectionDBm
            firstInvalid = i;
            lastInvalid = i;
            buffer = 0;
            for j = i: (fs + i)
                if length(y) <= j
                    break;
                end
                buffer = buffer + y(j);
                if y(j) >= seuilDetectionDBm
                    lastInvalid = y(j);
                end
            end
            if (buffer / (lastInvalid - firstInvalid + 1)) >= seuilDetectionDBm
                skipFor = fs;
                invalidList = [invalidList; [firstInvalid, lastInvalid]];
            end     
        end
    end
end