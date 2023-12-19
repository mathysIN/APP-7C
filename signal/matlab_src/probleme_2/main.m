
addpath('../libs');
addpath('./local_libs/analyze_audio');
addpath('./local_libs/find_fundamental_frequency');
addpath('./local_libs/find_harmonics');
addpath('./local_libs/load_audio');
addpath('./local_libs/show_data');

filename = 'FluteNote01.mp3';
[audio, fs] = load_audio(get_resource_path(filename));
[t_start, t_end, f0, power_dbm, high_freq, locs, amplitudes] = analyze_audio(audio, fs);
show_data(audio, fs, t_start, t_end, f0, power_dbm, high_freq, locs, amplitudes);










