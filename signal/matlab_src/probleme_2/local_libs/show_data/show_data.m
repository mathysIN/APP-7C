%------------------------------------------
% Groupe :      Groupe 7C
% Description : Affiche les résultats de l'analyse du signal audio.
% Entrées :
%   audio         Vecteur      Signal audio d'entrée
%   fs            Réel         Fréquence d'échantillonnage du signal
%   t_start       Réel         Instant de début de la note
%   t_end         Réel         Instant de fin de la note
%   f0            Réel         Fréquence fondamentale du signal
%   power_dbm     Réel         Puissance du signal en décibels (dBm)
%   high_freq     Réel         Fréquence maximale dans le signal
%   locs          Vecteur      Emplacements des harmoniques
%   amplitudes    Vecteur      Amplitudes des harmoniques
%
% Sorties :       Aucune
%
% Modifiées :     Aucune
%
% Locales :
%   time         Vecteur      Vecteur temps pour le graphique
%------------------------------------------

function show_data(audio, fs, t_start, t_end, f0, power_dbm, high_freq, locs, amplitudes)
    time = (0:length(audio)-1) / fs;
    figure;

    subplot(3, 1, 1);
    plot(time, abs(audio), 'b', 'LineWidth', 2);
    xlabel('Temps (s)');
    ylabel('Amplitude');
    title('Amplitude du signal en fonction du temps');
    grid on;

    subplot(3, 1, 2);
    plot(time, f0 * ones(size(audio)), 'r', 'LineWidth', 2);
    hold on;
    xlabel('Temps (s)');
    ylabel('Fréquence (Hz)');
    title('Fréquence de la note de musique en fonction du temps');
    grid on;
    hold off;

    subplot(3, 1, 3);
    bar(locs, amplitudes, 'b');
    xlabel('Harmonique');
    ylabel('Amplitude');
    title('Amplitudes des harmoniques dans la bande de fréquence');
    grid on;

    fprintf('Instant de début de note : %f\n', t_start);
    fprintf('Instant de fin de note : %f\n', t_end);
    fprintf('Puissance moyenne du signal : %f dBm\n', power_dbm);
    fprintf('La fréquence haute telle que [0, f] contient 99.99%% de la DSP est : %f Hz\n', high_freq);
end