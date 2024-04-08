%------------------------------------------
% Groupe :      Groupe 7C
% Description : Analyse le signal audio pour extraire diverses caractéristiques.
% Entrées :
%   audio       Vecteur      Signal audio d'entrée
%   fs          Réel         Fréquence d'échantillonnage du signal
%
% Sorties :
%   t_start     Réel         Instant de début de la note
%   t_end       Réel         Instant de fin de la note
%   f0          Réel         Fréquence fondamentale
%   power_dbm   Réel         Puissance du signal en décibels (dBm)
%   high_freq   Réel         Fréquence maximale dans le signal
%   locs        Vecteur      Emplacements des harmoniques
%   amplitudes  Vecteur      Amplitudes des harmoniques
%
% Modifiées :   Aucune
%
% Locales :
%   window_width Entier      Largeur de la fenêtre pour trouver les harmoniques
%------------------------------------------

function [t_start, t_end, f0, power_dbm, high_freq, locs, amplitudes] = analyze_audio(audio, fs)
    t_start = 0;
    t_end = length(audio) / fs;

    [f0, power_dbm, high_freq] = find_fundamental_frequency(audio, fs);

    window_width = 50;
    [locs, amplitudes] = find_harmonics(audio, fs, f0, window_width);
end