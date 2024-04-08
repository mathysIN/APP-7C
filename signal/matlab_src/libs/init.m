%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction initialise l'environnement MATLAB en fermant
% toutes les figures, en nettoyant la console, en configurant l'espace de
% travail, en définissant le format d'affichage des nombres en virgule
% flottante, et en affichant un message indiquant le début de l'exécution
% du script.
% Entrées :     Aucune
%
% Sorties :     Aucune
%
% Modifiées :   Aucune
%
% Locales :     Aucune
%------------------------------------------

function init()
    close all;
    clc;
    workspace;
    format long g;
    format compact;
    disp('Beginning to run script...\n');
end