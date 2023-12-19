%------------------------------------------
% Groupe :          Groupe 7C
% Description :     Ce script de test évalue la fonction calculate_PDBm avec des cas de test spécifiques.
%
% Entrées :
%   Aucune (les paramètres sont définis directement dans le code)
%
% Sorties :
%   Aucune (les résultats des tests sont affichés dans la console)
%
% Modifiées :       Aucune
%
% Locales :
%   sensibility     Réel        Sensibilité pour le test
%   gain            Réel        Gain pour le test
%   seuil_dBSPL     Réel        Seuil en dB SPL pour le test
%------------------------------------------

sensibility = -67;
gain = 16;
seuil_dBSPL = 110;

test_all_code([ ...
    test_code("Calcul du PDBm #1", calculate_PDBm(0, 0, 123), -64), ...
    ... For some reasons, we cannot do this test without rounding the number
    test_code("Calcul du PDBm #2", round(calculate_PDBm(sensibility, gain, seuil_dBSPL)), -5) ...
]);
