%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction affiche les résultats calculés pour le nombre de bits, le gain,
%               et la capacité de stockage nécessaire en mégaoctets (Mo) pour un son donné.
%
% Entrées :
%   bits          Entier    Nombre de bits nécessaires pour représenter le signal
%   gain          Réel      Gain calculé précédemment (en dB)
%   Mo            Réel      Capacité de stockage nécessaire en mégaoctets (Mo)
%
% Sorties :
%   Aucune
%
% Modifiées :   Aucune
%
% Locales :
%   capacite_CD   Réel      Capacité d'un CD en mégaoctets (Mo)
%------------------------------------------

function show_data(bits, gain, Mo)
    capacite_CD = 650;
    disp("Bits calculés = " + bits);
    disp("Gain calculé = " + gain);
    disp(" ");
    disp("Le son nécessite " + Mo + " Mo");
    if(capacite_CD < Mo)
        disp("Un CD de " + capacite_CD + " Mo ne peux pas tout enregistrer");
    else
        disp("Un CD de " + capacite_CD + " Mo peux tout enregistrer");
    end
end