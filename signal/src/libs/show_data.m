function show_data(y)
    threshold = 50;
    sensitivity         = -48;      % Micro sensitivity in dBV
    gain                = 30;       % in dB
    seuilDetectionSPL   = 80;       % dB SPL : P_SPL = 20log10(V_VRMS)-Sensibility+94  --> in dB
    dB_RMS              = seuilDetectionSPL+sensitivity-94; %in dB
    V_RMS               = 10^(dB_RMS/20);
    seuilDetectionDBm   = 10*log10(V_RMS^2/1e-3)+gain;      % Detection threshold in dBm, taking into accout the amplifier

    % Calcul de la durée totale du signal
    duration = length(y) / fs;

    % Affichage du signal dans le domaine temporel
    t = linspace(0, duration, length(y));
    plot(t, temp, 'b-', 'LineWidth', 2);
    grid on;
    xlabel('t (seconds)', 'FontSize', fontSize);
    ylabel('Amplitude', 'FontSize', fontSize);

    invalid = 0;

    for i = 1:length(temp)
        if temp(i) > seuilDetectionDBm
            invalid = invalid + 1;
        end
    end

    pourcentageInvalid = invalid/length(y)*100;
    fprintf("%.2f/100\n", pourcentageInvalid);
    if threshold < pourcentageInvalid
        disp("Ce son est trop fort");
    end
end
