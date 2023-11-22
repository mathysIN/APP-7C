function [y, seuilDetectionDBm, invalidList] = process_data(y, fs, step)

    sensitivity = -48;
    gain = 30;
    seuilDetectionSPL = 80;
    dB_RMS = seuilDetectionSPL+sensitivity-94;
    V_RMS = 10^(dB_RMS/20);

    seuilDetectionDBm = 10*log10(V_RMS^2/1e-3)+gain;
    y = 10*log10((y.^2)/1e-3);

    bufferInvalid = 0;
    invalidList = [];

    for i = 1:length(y)
        if y(i) > seuilDetectionDBm
            bufferInvalid = bufferInvalid + 1;
        end

        if mod(i, fs*step) == 0
            % Chaque pas, si il y a 50% du son taux trop haut, on considère le pas mauvais
            if bufferInvalid / (fs*step) > 0.5
                invalidList = [invalidList, i/fs];
            end
            bufferInvalid = 0;
        end
    end
end
