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
functiontests();
test_code(@calculate_bits, [gain, sensitivity, PdbSPL, bits]);

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