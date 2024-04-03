%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction calcule la capacité de stockage nécessaire en mégaoctets (Mo)
%               en fonction du nombre de bits, de la fréquence du son, du nombre de canaux audio
%               et de la durée du son.
%
% Entrées :
%   bits              Entier    Nombre de bits nécessaires pour représenter le signal
%   fe                Réel      Fréquence du son (en Hz)
%   nbrCanaux         Entier    Nombre de canaux audio
%   tempsSecondes     Réel      Durée du son en secondes
%
% Sorties :
%   capacite_Mo       Réel      Capacité de stockage nécessaire en mégaoctets (Mo)
%
% Modifiées :   Aucune
%
% Locales :
%   capacite_b        Réel      Capacité de stockage nécessaire en bits
%------------------------------------------

function capacite_Mo = calculate_Mo(bits, fe, nbrCanaux, tempsSecondes)
    capacite_b = bits * fe * tempsSecondes * nbrCanaux;
    capacite_Mo = capacite_b/(8 * 1e6);
end