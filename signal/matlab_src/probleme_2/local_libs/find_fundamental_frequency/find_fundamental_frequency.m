%------------------------------------------
% Groupe :      Groupe 7C
% Description : Trouve la fréquence fondamentale et analyse le signal audio.
% Entrées :
%   audio       Vecteur      Signal audio d'entrée
%   fs          Réel         Fréquence d'échantillonnage du signal
%
% Sorties :
%   f0          Réel         Fréquence fondamentale
%   power_dbm   Réel         Puissance du signal en décibels (dBm)
%   high_freq   Réel         Fréquence maximale dans le signal
%
% Modifiées :   Aucune
%
% Locales :
%   spectrum       Vecteur   Transformée de Fourier du signal audio
%   f0_index       Entier    Indice de la fréquence fondamentale dans le spectre
%   power_spectrum Vecteur   Spectre de puissance du signal
%   dsp            Vecteur   Densité spectrale de puissance (DSP) du signal
%   cumulative_dsp Vecteur   DSP cumulative normalisée
%   threshold      Réel      Seuil pour déterminer la fréquence haute
%   high_freq_index Entier    Indice de la fréquence haute dans le spectre
%------------------------------------------

function [f0, power_dbm, high_freq] = find_fundamental_frequency(audio, fs)
    spectrum = fft(audio);
    [~, f0_index] = max(abs(spectrum));
    f0 = f0_index * fs / length(audio);

    power_dbm = 10 * log10(mean(abs(audio).^2));

    power_spectrum = abs(spectrum).^2;
    dsp = power_spectrum / length(audio);
    cumulative_dsp = cumsum(dsp) / sum(dsp);

    threshold = 0.9999;
    high_freq_index = find(cumulative_dsp >= threshold, 1, 'first');
    high_freq = high_freq_index * fs / length(audio);
end