function [outputArg1,outputArg2] = process_data(filename)
    [y, fs] = audioread(filename);
    temp = 10*log10((y.^2)/1e-3)+30;

    outputArg1 = temp;
    outputArg2 = fs;
end

