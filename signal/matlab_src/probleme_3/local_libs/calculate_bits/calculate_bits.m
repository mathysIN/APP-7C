%------------------------------------------
% Groupe :      Groupe 7C
% Description : Cette fonction calcule le nombre de bits nécessaires pour représenter un signal sonore.
%
% Entrées :
%   gain               Réel      Gain calculé précédemment (en dB)
%   sensitivity        Réel      Sensibilité du microphone (en dB)
%   PdbSPL             Réel      Puissance du signal en dB SPL (Sound Pressure Level)
%
% Sorties :
%   bits               Entier    Nombre de bits nécessaires pour représenter le signal
%
% Modifiées :   Aucune
%
% Locales :
%   dB_RMS_b           Réel      Niveau sonore RMS (en dB)
%   V_RMS_b            Réel      Valeur RMS correspondante (échelle linéaire)
%   PDBm               Réel      Puissance du signal en dBm
%   A                  Réel      Paramètre A
%   PSw                Réel      Puissance du signal en watts
%   q                  Réel      Facteur q
%------------------------------------------

function bits = calculate_bits(gain, sensitivity, PdbSPL)
    dB_RMS_b = PdbSPL+sensitivity-94;
    V_RMS_b = 10^(dB_RMS_b/20);
    PDBm = 10*log10(V_RMS_b^2/1e-3)+gain;
    A = 2;
    PSw = 10^((PDBm - 30)/10);
    q = sqrt(12*PSw / 10^4);
    bits = ceil(log2(A/q));
end