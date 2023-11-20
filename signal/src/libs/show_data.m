function show_data(y, fs)
    fontSize = 18;
    threshold = 50;
    sensitivity         = -48;
    gain                = 30;
    seuilDetectionSPL   = 80;
    dB_RMS              = seuilDetectionSPL + sensitivity - 94;
    V_RMS               = 10^(dB_RMS/20);
    seuilDetectionDBm   = 10*log10(V_RMS^2/1e-3)+gain;

    % Calcul de la durée totale du signal
    duration = length(y) / fs;

    % Affichage du signal dans le domaine temporel
    t = linspace(0, duration, length(y));
    plot(t, y, 'b-', 'LineWidth', 2);
    grid on;
    xlabel('t (seconds)', 'FontSize', fontSize);
    ylabel('Amplitude', 'FontSize', fontSize);

    invalid = 0;
    buffer_invalid = 0;
    for i = 1:length(y)
        if y(i) > seuilDetectionDBm
            buffer_invalid = buffer_invalid + 1;
        else
            buffer_invalid = buffer_invalid - 1;
        end
        
        if (buffer_invalid == fs)
            buffer_invalid = 0;
            invalid = invalid + 1;
        end
    end

    pourcentageInvalid = (invalid/length(y))*100;
    disp(invalid + "/" + (length(y)/fs) + " invalid" );
    if threshold < pourcentageInvalid
        disp("Ce son est trop fort");
    else
        disp("Mon gars ca va👍");
    end
    fprintf("%s/%s", invalid, length(y));
end
