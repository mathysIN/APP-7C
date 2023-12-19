%------------------------------------------
% Groupe :          Groupe 7C
% Description :     Cette fonction filtre un signal audio en utilisant un filtre passe-haut Butterworth.
%
% Entrées :
%   fc          Réel        Fréquence de coupure du filtre en Hertz
%   y           Vecteur     Signal audio à filtrer
%   fs          Réel        Fréquence d'échantillonnage du signal en Hertz
%
% Sorties :
%   y_filtered  Vecteur     Signal audio filtré
%
% Modifiées :       Aucune
%
% Locales :
%   b           Vecteur     Coefficients du numérateur du filtre
%   a           Vecteur     Coefficients du dénominateur du filtre
%------------------------------------------

function y_filtered = filter_audio(fc, y, fs)
    [b, a] = butter(10, fc/(fs/2), 'high');
    y_filtered = filter(b, a, y);
end
