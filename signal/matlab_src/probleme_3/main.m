%------------------------------------------
% Groupe :      Groupe 7C
% Description : Script principal pour calculer et afficher les résultats liés à un signal sonore.
%
% Entrées :
%   Aucune
%
% Sorties :
%   Aucune
%
% Modifiées :   Aucune
%
% Locales :
%   MODE_MONO         Chaîne    Constante représentant le mode mono
%   MODE_STEREO       Chaîne    Constante représentant le mode stéréo
%   sensitivity       Réel      Sensibilité du microphone (en dB)
%   niveauSonoreMax   Réel      Niveau sonore maximum capté par le microphone (en dB)
%   PdbSPL            Réel      Puissance du signal en dB SPL (Sound Pressure Level)
%   fe                Réel      Fréquence du son (en Hz)
%   tempsSecondes     Réel      Durée du son en secondes
%   gain              Réel      Gain calculé
%   bits              Entier    Nombre de bits nécessaires pour représenter le signal
%   Mo                Réel      Capacité de stockage nécessaire en mégaoctets (Mo)
%   mode              Chaîne    Mode audio (MODE_MONO ou MODE_STEREO)
%   nbrCanaux         Entier    Nombre de canaux audio
%------------------------------------------

addpath('../libs');
addpath('./local_libs/calculate_bits');
addpath('./local_libs/calculate_gain');
addpath('./local_libs/calculate_Mo');
addpath('./local_libs/show_data');
init();
MODE_MONO = "mono";
MODE_STEREO = "stereo";

sensitivity = -47;
niveauSonoreMax = 130;
PdbSPL = 60;
fe = 44100;
tempsSecondes = 60*60;

gain = calculate_gain(sensitivity, niveauSonoreMax);
bits = calculate_bits(gain, sensitivity, PdbSPL);

% mode = MODE_MONO;
mode = MODE_STEREO;
nbrCanaux = 1;
if (mode == MODE_MONO)
    nbrCanaux = 1;
end
if (mode == MODE_STEREO)
    nbrCanaux = 2;
end

Mo = calculate_Mo(bits, fe, nbrCanaux, tempsSecondes);
show_data(bits, gain, Mo);