
addpath('../libs');
addpath('./local_libs/analyzeAudio');
addpath('./local_libs/findFundamentalFrequencyAndAnalyze');
addpath('./local_libs/findHarmonics');
addpath('./local_libs/loadAudio');
addpath('./local_libs/plotResults');

filename = 'FluteNote01.mp3';
[audio, fs] = loadAudio(get_resource_path(filename));
[t_start, t_end, f0, power_dbm, high_freq, locs, amplitudes] = analyzeAudio(audio, fs);
plotResults(audio, fs, t_start, t_end, f0, power_dbm, high_freq, locs, amplitudes);










