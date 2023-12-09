%------------------------------------------
% Groupe :      Groupe 7C
% Description : Script de test pour la fonction calculate_gain.
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
test_all_code([test_code("Calcul du bits", calculate_bits(11, -47, 60), 18)]);