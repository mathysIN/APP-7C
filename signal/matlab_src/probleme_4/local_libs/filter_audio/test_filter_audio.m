addpath('../../../libs');
init();

Fs = 44100;
t = 1:1/Fs:2;
y = sin (2*pi*1000*t);
fc = 2000;
potential_result = load(get_resource_path("tests/test_filter_audio_result.mat")).y_filtered;

test_all_code([ ...
    test_code("Filtrage audio", filter_audio(fc, y, Fs), potential_result)
]);