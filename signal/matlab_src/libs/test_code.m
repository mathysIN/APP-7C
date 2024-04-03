%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction effectue un test de code en comparant le
% résultat obtenu avec une valeur attendue. Elle prend en paramètre le
% titre du test, le résultat obtenu, et la valeur attendue.
%
% Entrées :
%   title       Chaîne de caractères    Titre du test
%   result      Variable                Résultat obtenu de la fonction à tester test
%   expected    Variable                Valeur attendue du test
%
% Sorties :
%   test        Booléan                Résultat du test
%
% Modifiées :   Aucune
%
% Locales :   Aucune
%------------------------------------------

function test = test_code(title, result, expected)
    test = isequalwithequalnans(result, expected);
    if test
        disp("Test '" + title +"' réussi !");
    else
        disp("Test '" + title +"' raté !")
        disp("Attendu :" + mat2str(expected));
        disp("Reçu :" + mat2str(result));
    end
end