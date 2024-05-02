%------------------------------------------
% Groupe :      Groupe 7C
% Description : Script de test qui initialise les chemins d'accès aux bibliothèques,
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
%   fileName         String     Le chemin vers le fichier
%------------------------------------------

function run_test(fileName)
    addpath('../../../libs');
    addpath('../../local_libs/generate_input_data');
    addpath('../../local_libs/process_data');
    addpath('../../local_libs/show_data');
    init();
    
    [y, fs] = generate_input_data(get_resource_path(fileName));
    [new_y, seuilDetectionDBm, invalidList] = process_data(y, fs);
    show_data(y, new_y, fs, seuilDetectionDBm, invalidList, fileName)
end

