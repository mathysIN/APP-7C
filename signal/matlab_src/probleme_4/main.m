%------------------------------------------
% Groupe :          Groupe 7C
% Description :     Ce script principal utilise les fonctions du projet pour analyser un fichier audio.
%
% Entrées :
%   Aucune
%
% Sorties :
%   Aucune
%
% Modifiées :       Aucune
%
% Locales :
%   fileName        Chaîne      Nom du fichier audio à analyser
%   y               Vecteur     Signal audio
%   Fs              Réel        Fréquence d'échantillonnage du signal en Hertz
%   t               Vecteur     Vecteur de temps pour les signaux audio
%   fc              Réel        Fréquence de coupure du filtre en Hertz
%   sensibility     Réel        Sensibilité pour le calcul de PDBm
%   gain            Réel        Gain pour le calcul de PDBm
%   seuil_dBSPL     Réel        Seuil en dB SPL pour le calcul de PDBm
%   PDBm            Réel        Puissance en dBm calculée à partir des paramètres fournis
%   y_filtered      Vecteur     Signal audio filtré
%------------------------------------------

addpath('../libs');
addpath('./local_libs/calculate_PDBm');
addpath('./local_libs/filter_audio');
addpath('./local_libs/show_data');

init();
fileName = "Ville01.mp3";

[y, Fs] = audioread(get_resource_path(fileName));
t = 1:1/Fs:2;

fc = 2000;
sensibility = -67;
gain = 16;
seuil_dBSPL = 110;

PDBm = calculate_PDBm(sensibility, gain, seuil_dBSPL);
y_filtered = filter_audio(fc, y, Fs);
show_data(y, y_filtered, Fs, PDBm);