addpath('./libs');
init();

step = 1;

[y, fs] = generate_input_data("../files/Jardin.mp3");
[y, seuilDetectionDBm, invalidList] = process_data(y, fs, step);
show_data(y, fs, seuilDetectionDBm, invalidList, step)