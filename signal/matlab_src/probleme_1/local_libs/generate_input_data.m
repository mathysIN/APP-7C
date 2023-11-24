%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction lit un fichier audio spécifié par le nom de fichier
%               fourni en entrée et retourne le signal audio et la fréquence
%               d'échantillonnage associée.
% Entrées :
%   filename    Chaîne de caractères    Nom du fichier audio à lire
%
% Sorties :
%   y           Vecteur     Signal audio lu depuis le fichier
%   fs          Double      Fréquence d'échantillonnage du signal audio
%
% Modifiées :   Aucune
%
% Locales :
%   Aucune
%------------------------------------------

function [y,fs] = generate_input_data(filename)
    [y, fs] = audioread(filename);
end

