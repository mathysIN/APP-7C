%------------------------------------------
% Groupe :      Groupe 7C
% Description : Trouve les harmoniques dans le signal audio.
% Entrées :
%   audio         Vecteur      Signal audio d'entrée
%   fs            Réel         Fréquence d'échantillonnage du signal
%   f0            Réel         Fréquence fondamentale du signal
%   window_width  Entier       Largeur de la fenêtre autour de la fréquence fondamentale
%
% Sorties :
%   locs          Vecteur      Emplacements des harmoniques
%   amplitudes    Vecteur      Amplitudes des harmoniques
%
% Modifiées :     Aucune
%
% Locales :
%   spectrum           Vecteur   Transformée de Fourier du signal audio
%   power_spectrum     Vecteur   Spectre de puissance du signal
%   dsp                Vecteur   Densité spectrale de puissance (DSP) du signal
%   f0_index           Entier    Indice de la fréquence fondamentale dans le spectre
%   window_start       Entier    Début de la fenêtre de fréquence
%   window_end         Entier    Fin de la fenêtre de fréquence
%   frequency_window   Vecteur   Fenêtre de fréquence autour de la fréquence fondamentale
%   threshold          Réel      Seuil pour la détection des pics
%   above_threshold    Vecteur   Booléen indiquant si la valeur est au-dessus du seuil
%   diff_above_threshold Vecteur  Différence entre les valeurs successives de above_threshold
%   rising_edges       Vecteur   Indices des bords montants
%   falling_edges      Vecteur   Indices des bords descendants
%------------------------------------------

function [locs, amplitudes] = findHarmonics(audio, fs, f0, window_width)
    spectrum = fft(audio);
    power_spectrum = abs(spectrum).^2;
    dsp = power_spectrum / length(audio);

    f0_index = round(f0 * length(audio) / fs);
    window_start = max(f0_index - window_width/2, 1);
    window_end = min(f0_index + window_width/2, length(dsp));

    frequency_window = dsp(window_start:window_end);

    threshold = 0.1 * max(frequency_window);

    above_threshold = frequency_window > threshold;
    diff_above_threshold = diff([0; above_threshold; 0]);
    rising_edges = find(diff_above_threshold > 0);
    falling_edges = find(diff_above_threshold < 0) - 1;

    locs = (rising_edges + falling_edges) / 2;
    locs = round(locs);
    amplitudes = frequency_window(locs);
end
