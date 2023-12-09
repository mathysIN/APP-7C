%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction effectue un test de code en comparant le
% résultat obtenu avec une valeur attendue. Elle prend en paramètre le
% titre du test, le résultat obtenu, et la valeur attendue.
%
% Entrées :
%   title       Chaîne de caractères    Titre du test
%   result      Variable                Résultat obtenu du test
%   expected    Variable                Valeur attendue du test
%
% Sorties :
%   test        Tableau                Tableau contenant trois éléments :
%                                      1. Booléen indiquant la réussite du test
%                                      2. Titre du test
%                                      3. Valeur attendue du test
%
% Modifiées :   Aucune
%
% Locales :
%   success     Booléen                Indique la réussite ou l'échec du test
%   i           Entier                 Variable de boucle
%------------------------------------------

function test = test_code(title, result, expected)
    success = false;
    try
        if(isempty(expected))
            success = true;
        end
        if(length(expected) == 1)
            success = result == expected;
        end
        if length(expected) > 2
            % can and will break for other data structures
            for i = 1:length(expected)
                success = true;
                if result(i) ~= expected(i)
                    success = false;
                    break;
                end
            end
        end
    catch
        success = false;
    end
    test = [success; title; expected];
end