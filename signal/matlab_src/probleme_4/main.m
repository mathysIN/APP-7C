addpath('../libs');
addpath('./local_libs/calculate_PDBm');
addpath('./local_libs/filter_audio');
addpath('./local_libs/show_data');

init();
fileName = "Jardin.mp3";

[y, Fs] = audioread(get_resource_path(fileName));
t = 1:1/Fs:2;

fc = 2000;
S = -67;
G = 16;
seuil_dBSPL = 110;

PDBm = calculate_PDBm(S, G, seuil_dBSPL);
y_filtered = filter_audio(fc, y, Fs);
show_data(y, y_filtered, Fs, PDBm);

