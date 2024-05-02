%------------------------------------------
% Groupe :      Groupe 7C
% Description : Script de test pour la fonction calculate_Mo.
%
% Entrées :
%   Aucune
%
% Sorties :
%   Aucune
%
% Modifiées :   Aucune
%
% Locales :
%   Aucune
%------------------------------------------

addpath('../../../libs');
init();
test_all_code([ ...
    test_code("Calcul des Mo #1", calculate_Mo(16, 44100, 2, 3600), 635.04), ...
    test_code("Calcul des Mo #2", calculate_Mo(18, 44100, 2, 3600), 714.42) ...
]);