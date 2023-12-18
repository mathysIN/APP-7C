function show_data(y,y_filtered, Fs, PDBm)
    puissance_totale = sum(y.^2);
    puissance_sup_2kHz = sum(y_filtered.^2);
    pourcentage_sup_2kHz = (puissance_sup_2kHz / puissance_totale) * 100;
    
    if puissance_totale > PDBm && pourcentage_sup_2kHz > 20
        disp("Le signal est pénible");
    else
        disp("Le signal n'est pas pénible");
    end
    
    t = (0:length(y)-1)/Fs;
    
    figure;
    
    subplot(2,1,1);
    plot(t, y);
    xlabel("Temps (s)");
    ylabel("Amplitude");
    title("Signal audio original");
    
    subplot(2,1,2);
    plot(t, y_filtered);
    xlabel("Temps (s)");
    ylabel("Amplitude");
    title("Signal audio filtré (fréquences > 2 kHz)")
end

