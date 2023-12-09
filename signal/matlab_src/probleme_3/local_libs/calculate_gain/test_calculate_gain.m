%------------------------------------------
% Groupe :      Groupe 7C
% Description : Script de test pour la fonction calculate_bits.
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
test_all_code([test_code("Calcul du gain", calculate_gain(-47, 130), 11)]);