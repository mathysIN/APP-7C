%------------------------------------------
% Nom du fichier : calculate_PDBm.m
% Groupe :          Groupe 7C
% Description :     Cette fonction calcule la Puissance en dBm à partir de la sensibilité,
%                   du gain et du seuil en dB SPL (Sound Pressure Level).
%
% Entrées :
%   sensibility     Réel        Sensibilité de l'appareil en dB SPL
%   gain            Réel        Gain de l'appareil en dB
%   seuil_dBSPL     Réel        Seuil en dB SPL
%
% Sorties :
%   PDBm            Réel        Puissance en dBm calculée
%
% Modifiées :       Aucune
%
% Locales :
%   dB_RMS          Réel        Niveau de pression acoustique en dB RMS
%   V_RMS           Réel        Valeur efficace de la tension acoustique
%------------------------------------------

function PDBm = calculate_PDBm(sensibility, gain, seuil_dBSPL)
    dB_RMS = seuil_dBSPL + sensibility - 94;
    V_RMS = 10^(dB_RMS/20);
    PDBm = 10*log10(V_RMS^2/1e-3) + gain;
end