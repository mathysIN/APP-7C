addpath('./libs');
init();
[y, fs] = process_data("../files/MarteauPiqueur01.mp3");
show_data(y, fs);
