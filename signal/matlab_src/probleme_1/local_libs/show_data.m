%------------------------------------------
% Groupe :      7C
% Description : Cette fonction affiche les données d'une manière lisible 
%               des résultats des fonctions précédentes.
%
% Entrées :
%   y                   Vecteur      Signal audio d'origine
%   new_y               Vecteur      Signal audio traité en dBm
%   fs                  Double       Fréquence d'échantillonnage du signal
%   seuilDetectionDBm  Double       Seuil de détection en dBm
%   invalidList         Matrice      Liste des segments invalides [début, fin]
%
% Sorties :            Aucune
%
% Modifiées :          Aucune
%
% Locales :
%   fontSize            Entier       Taille de police pour le graphique
%   threshold           Double       Seuil pour l'évaluation de la désagréabilité du son
%   duration            Double       Durée totale du signal audio
%   t                   Vecteur      Vecteur temporel
%   temp                Vecteur      Indices des valeurs dépassant le seuil
%   invalid             Double       Durée totale des segments invalides
%   skipFor             Entier       Variable de saut pour l'analyse des segments invalides
%   i                   Entier       Indice principal pour l'analyse des segments invalides
%   invalidStart        Entier       Début du segment invalide courant
%   invalidEnd          Entier       Fin du segment invalide courant
%   y                   Entier       Variable de boucle pour l'analyse des segments invalides
%   invalidDuration     Double       Durée totale des segments invalides en secondes
%
%------------------------------------------

function show_data(y, new_y, fs, seuilDetectionDBm, invalidList)
    fontSize = 18;
    threshold = 0.50;
    duration = length(y) / fs;
    
    t = linspace(0, duration, length(y));
    
    plot(t, new_y, 'b-', 'LineWidth', 2);
    hold on;
    temp = find(new_y > seuilDetectionDBm);
    % Dépassement du seuil en rouge (représentation non-précise)
    plot(t(temp), new_y(temp), 'red', 'LineWidth', 2);
    grid on;
    xlabel('t (seconds)', 'FontSize', fontSize);
    ylabel('dBm', 'FontSize', fontSize);
    figure;
    
    plot(t, y, 'b-', 'LineWidth', 2);
    xlabel('t (seconds)', 'FontSize', fontSize);
    ylabel('Amplitude', 'FontSize', fontSize);

    invalid = 0;
    skipFor = 0;
    for i = 1:length(invalidList)
        if skipFor > 0
            skipFor = skipFor - 1;
            continue;
        end
        invalidStart = invalidList(i, 1);
        invalidEnd = invalidList(i, 2);
        y = i;
        while y < length(invalidList) && (invalidList(y + 1, 1) - invalidEnd) == 1
            invalidEnd = invalidList(y + 1, 2);
            y = y + 1;
            skipFor = skipFor + 1;
        end
        invalid = invalid + (invalidEnd - invalidStart);
        disp("Son invalide de la seconde " + (invalidStart/fs) + " à " + (invalidEnd/fs));
    end

    invalidDuration = invalid/fs;
    disp(invalidDuration + "/" + duration + " secondes invalides " );

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