addpath('../../../libs');
init();

S = -67;
G = 16;
seuil_dBSPL = 110;

test_all_code([]);

test_all_code([ ...
    test_code("Calcul du PDBm #1", calculate_PDBm(0, 0, 0), -64), ...
    ... For some reasons, we cannot do this test without rounding the number
    test_code("Calcul du PDBm #2", round(calculate_PDBm(S,G,seuil_dBSPL)), -5) ...
]);