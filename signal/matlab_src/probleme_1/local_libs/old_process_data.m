%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction traite les données audio, les convertit en dBm
%               et identifie les pas de temps où le niveau sonore dépasse le seuil.
%
% Entrées :
%   y               Vecteur     Signal audio en entrée
%   fs              Double      Fréquence d'échantillonnage du signal audio
%   step            Double      Intervalle de temps pour l'évaluation (en secondes)
%
% Sorties :
%   y               Vecteur     Signal audio converti en dBm
%   seuilDetectionDBm Double    Seuil de détection en dBm
%   invalidList     Vecteur     Liste des pas de temps considérés invalides
%
% Modifiées :       Aucune
%
% Locales :
%   sensitivity     Double      Sensibilité du détecteur
%   gain            Double      Gain du signal audio
%   seuilDetectionSPL Double    Seuil de détection en SPL
%   dB_RMS          Double      Niveau sonore en dB (RMS)
%   V_RMS           Double      Valeur efficace du signal audio
%   bufferInvalid   Double      Compteur pour le nombre de pas de temps dépassant le seuil
%   i               Entier      Variable d'itération
%------------------------------------------

function [y, seuilDetectionDBm, invalidList] = old_process_data(y, fs, step)
    sensitivity = -48;
    gain = 30;
    seuilDetectionSPL = 80;
    dB_RMS = seuilDetectionSPL+sensitivity-94;
    V_RMS = 10^(dB_RMS/20);

    seuilDetectionDBm = 10*log10(V_RMS^2/1e-3)+gain;
    y = 10*log10((y.^2)/1e-3);

    bufferInvalid = 0;
    invalidList = [];

    for i = 1:length(y)
        if y(i) > seuilDetectionDBm
            bufferInvalid = bufferInvalid + 1;
        end

        if mod(i, fs*step) == 0
            % Chaque pas, si il y a 100% du son taux trop haut, on considère le pas mauvais
            if bufferInvalid == (fs*step)
                invalidList = [invalidList, i/fs];
            end
            bufferInvalid = 0;
        end
    end
end
