addpath('../libs');
addpath('./local_libs');
init();

step = 0.25;

[y, fs] = generate_input_data("../../files/Ville01.mp3");
[y, seuilDetectionDBm, invalidList] = process_data(y, fs, step);
show_data(y, fs, seuilDetectionDBm, invalidList, step)