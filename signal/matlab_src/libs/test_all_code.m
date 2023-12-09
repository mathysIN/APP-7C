%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction effectue une série de tests sur des fonctions
% en utilisant le tableau de tests fourni. Elle affiche le résultat de
% chaque test, indiquant s'il a réussi ou échoué, ainsi que le nombre total
% de tests réussis.
%
% Entrées :
%   tests       Tableau                Tableau contenant les tests à effectuer.
%                                     Chaque colonne doit contenir les éléments suivants :
%                                     1. Booléen indiquant la réussite du test (true/false ou 1/0)
%                                     2. Titre du test (chaîne de caractères)
%                                     3. Valeur attendue du test (variable)
%
% Sorties :     Aucune
%
% Modifiées :   Aucune
%
% Locales :
%   success     Entier                 Nombre de tests réussis
%   arraySize   Tableau                Dimensions du tableau de tests
%   i           Entier                 Variable de boucle
%   test        Tableau                Tableau contenant trois éléments pour chaque test :
%                                      1. Booléen indiquant la réussite du test
%                                      2. Titre du test
%                                      3. Valeur attendue du test
%------------------------------------------

function test_all_code(tests)
    if isempty(tests)
        disp("Pas de tests à effectuer")
    else
        % Can't iterate over one element because idk how to use matlab
        tests = [tests, ["fakedata"; "fakedata"; "fakedata"]];
        success = 0;
        arraySize = size(tests);
        for i = 1:arraySize(2)
            if i == arraySize(2)
                continue;
            end
            test = tests(:, 1);
            if test(1) == "true" || test(1) == "1"
                success = success + 1;
                disp("Test '" + test(2) +"' réussi ! (Reçu : " + test(3) + ")");
            else
                disp("Test '" + test(2) +"' raté ! (Attendu : " + test(3) + ")");
            end
        end
        disp(" ");
        disp(success + "/" + (arraySize(2) - 1) + " tests réussis");
    end
end