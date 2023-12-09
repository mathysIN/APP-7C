%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction effectue une série de tests sur des fonctions
% en utilisant le tableau de tests fourni. Elle affiche le résultat de
% chaque test, indiquant s'il a réussi ou échoué, ainsi que le nombre total
% de tests réussis.
%
% Entrées :
%   tests       Vecteur               Contient tout les résultats de tests
%
% Sorties :     Aucune
%
% Modifiées :   Aucune
%
% Locales :   Aucune
%------------------------------------------

function test_all_code(tests)
    disp(" ");
    if isempty(tests)
        disp("Pas de tests à effectuer");
    else
        disp(sum(tests) + "/" + (length(tests)) + " tests réussis");
    end
end