%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction calcule le gain nécessaire sur un signal électrique.
%
% Entrées :
%   sensitivity         Réel      Sensibilité du microphone (en dB)
%   niveauSonoreMax     Réel      Niveau sonore maximum capté par le microphone (en dB)
%
% Sorties :
%   gain                Réel      Gain à appliquer sur le signal électrique (en dB)
%
% Modifiées :   Aucune
%
% Locales :
%   dB_RMS              Réel      Niveau sonore RMS (en dB)
%   V_RMS               Réel      Valeur RMS correspondante (échelle linéaire)
%------------------------------------------

function gain = calculate_gain(sensitivity, niveauSonoreMax)
    dB_RMS = niveauSonoreMax + sensitivity - 94;
    V_RMS = 10^(dB_RMS/20);
    gain = 20*log10(1/V_RMS);
end