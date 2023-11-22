function show_data(y, fs, seuilDetectionDBm, invalidList, step)
    
    fontSize = 18;
    threshold = 0.50;
    duration = length(y) / fs;
    
    t = linspace(0, duration, length(y));
    plot(t, y, 'b-', 'LineWidth', 2);
    hold on;
    temp = find(y > seuilDetectionDBm);
    plot(t(temp), y(temp), 'red', 'LineWidth', 2);
    grid on;
    xlabel('t (seconds)', 'FontSize', fontSize);
    ylabel('Amplitude', 'FontSize', fontSize);

    for i = 1:length(invalidList)
        disp("Son invalide à la seconde " + invalidList(i));
    end

    invalid = length(invalidList)*step;

    disp(invalid + "/" + duration + " secondes invalides " );

    if invalid > duration*threshold
        disp("Le son est très désagréable");
    else 
        if invalid > duration*threshold*0.5
            disp("Le son est désagréable parfois");
        else 
            if invalid ~= 0
                disp("Le son est très peu désagréable");
            else 
                disp("Le son est acceptable");
            end
        end
    end
end
