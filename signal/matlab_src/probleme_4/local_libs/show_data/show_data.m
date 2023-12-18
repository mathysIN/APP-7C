%------------------------------------------
% Nom du fichier : show_data.m
% Groupe :          Groupe 7C
% Description :     Cette fonction analyse un signal audio et affiche des informations sur sa puissance,
%                   en indiquant si le signal est considéré comme pénible. Elle affiche également le signal
%                   audio original et le signal filtré pour les fréquences supérieures à 2 kHz.
%
% Entrées :
%   y           Vecteur     Signal audio original
%   y_filtered  Vecteur     Signal audio filtré (fréquences > 2 kHz)
%   Fs          Réel        Fréquence d'échantillonnage du signal en Hertz
%   PDBm        Réel        Puissance en dBm à partir de la fonction calculate_PDBm
%
% Sorties :
%   Aucune (les résultats sont affichés dans la console et les signaux sont tracés)
%
% Modifiées :       Aucune
%
% Locales :
%   puissance_totale       Réel        Puissance totale du signal audio original
%   puissance_sup_2kHz     Réel        Puissance du signal audio filtré pour les fréquences > 2 kHz
%   pourcentage_sup_2kHz   Réel        Pourcentage de la puissance supérieure à 2 kHz par rapport à la puissance totale
%   t                      Vecteur     Vecteur de temps pour les signaux audio
%------------------------------------------

function show_data(y,y_filtered, Fs, PDBm)
    puissance_totale = sum(y.^2);
    puissance_sup_2kHz = sum(y_filtered.^2);
    pourcentage_sup_2kHz = (puissance_sup_2kHz / puissance_totale) * 100;
        
    if puissance_totale > PDBm && pourcentage_sup_2kHz > 20
        disp("Le signal est pénible");
    else
        disp("Le signal n'est pas pénible");
    end
    
    t = (0:length(y)-1)/Fs;
    
    figure;
    
    subplot(2,1,1);
    plot(t, y);
    xlabel("Temps (s)");
    ylabel("Amplitude");
    title("Signal audio original");
    
    subplot(2,1,2);
    plot(t, y_filtered);
    xlabel("Temps (s)");
    ylabel("Amplitude");
    title("Signal audio filtré (fréquences > 2 kHz)")
end