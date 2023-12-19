%------------------------------------------
% Groupe :      Groupe 7C
% Description : Charge un fichier audio.
% Entrées :
%   filename    Chaîne de caractères   Nom du fichier audio à charger
%
% Sorties :
%   audio       Vecteur               Signal audio chargé
%   fs          Réel                  Fréquence d'échantillonnage du signal
%
% Modifiées :   Aucune
%
% Locales :      Aucune
%------------------------------------------

function [audio, fs] = loadAudio(filename)
    [audio, fs] = audioread(filename);
end