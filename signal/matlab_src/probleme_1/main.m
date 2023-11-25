%------------------------------------------
% Groupe :      Groupe 7C
% Description : Script principal qui initialise les chemins d'accès aux bibliothèques,
%               initialise le système, génère les données audio à partir d'un fichier
%               spécifié, traite ces données, puis affiche les tracés des valeurs
%               d'amplitude et de dBm en fonction du temps, mettant en surbrillance
%               les échantillons qui dépassent le seuil de détection en dBm. Fournit
%               également un rapport sur les secondes considérées invalides et évalue
%               le statut global du son en fonction de la proportion d'échantillons
%               invalides.
% Entrées :
%   Aucune
%
% Sorties :
%   Aucune
%
% Modifiées :   Aucune
%
% Locales :
%   step                Double      Pas de temps en secondes pour l'analyse
%   y                   Vecteur     Signal audio original en amplitude
%   fs                  Double      Fréquence d'échantillonnage du signal audio
%   new_y               Vecteur     Signal audio en dBm après traitement
%   seuilDetectionDBm  Double      Seuil de détection en dBm
%   invalidList         Vecteur     Liste des secondes considérées invalides
%------------------------------------------

addpath('../libs');
addpath('./local_libs');
init();

[y, fs] = generate_input_data("../../files/MarteauPiqueur01.mp3");
[new_y, seuilDetectionDBm, invalidList] = process_data(y, fs);
show_data(y, new_y, fs, seuilDetectionDBm, invalidList)