%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction affiche les tracés des valeurs d'amplitude et de dBm
%               en fonction du temps, mettant en surbrillance les échantillons qui
%               dépassent le seuil de détection en dBm. Elle fournit également un
%               rapport sur les secondes considérées invalides et évalue le statut
%               global du son en fonction de la proportion d'échantillons invalides.
% Entrées :
%   y                   Vecteur     Signal audio original en amplitude
%   new_y               Vecteur     Signal audio en dBm après traitement
%   fs                  Double      Fréquence d'échantillonnage du signal audio
%   seuilDetectionDBm  Double      Seuil de détection en dBm
%   invalidList         Vecteur     Liste des secondes considérées invalides
%   step                Double      Pas de temps en secondes pour l'analyse
%
% Sorties :
%   Aucune
%
% Modifiées :   Aucune
%
% Locales :
%   fontSize            Double      Taille de police pour les étiquettes d'axes
%   threshold           Double      Seuil pour évaluer le statut global du son
%   duration            Double      Durée totale du signal audio en secondes
%   t                   Vecteur     Vecteur temporel pour les tracés
%   temp                Vecteur     Indices des échantillons dépassant le seuil
%   i                   Entier      Indice de boucle
%   invalid             Double      Durée totale des échantillons invalides
%------------------------------------------

function show_data(y, new_y, fs, seuilDetectionDBm, invalidList, step)
    fontSize = 18;
    threshold = 0.50;
    duration = length(y) / fs;
    
    t = linspace(0, duration, length(y));
    
    plot(t, new_y, 'b-', 'LineWidth', 2);
    hold on;
    temp = find(new_y > seuilDetectionDBm);
    % Dépassement du seuil en rouge (représentation graphique non-précise)
    plot(t(temp), new_y(temp), 'red', 'LineWidth', 2);
    grid on;
    xlabel('t (seconds)', 'FontSize', fontSize);
    ylabel('dBm', 'FontSize', fontSize);
    figure;
    
    plot(t, y, 'b-', 'LineWidth', 2);
    xlabel('t (seconds)', 'FontSize', fontSize);
    ylabel('Amplitude', 'FontSize', fontSize);

    for i = 1:length(invalidList)
        disp("Son invalide de la seconde " + (invalidList(i, 1)/fs) + " à " + (invalidList(i, 2)/fs) + ".");
    end

    invalid = length(invalidList)*step;

    disp(invalid + "/" + duration + " secondes invalides " );

    if invalid > duration*threshold
        disp("Le son est très désagréable");
    else 
        if invalid > duration*threshold*0.5
            disp("Le son est désagréable parfois");
        else 
            if invalid ~= 0
                disp("Le son est très peu désagréable");
            else 
                disp("Le son est acceptable");
            end
        end
    end
end
