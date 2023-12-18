function y_filtered = filter_audio(fc, y, fs)
    [b, a] = butter(10, fc/(fs/2), 'high');
    
    y_filtered = filter(b, a, y);
end