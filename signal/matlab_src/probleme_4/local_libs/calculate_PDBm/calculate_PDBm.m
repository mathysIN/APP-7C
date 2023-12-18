function PDBm = calculate_PDBm(S,G,seuil_dBSPL)
    dB_RMS              = seuil_dBSPL+S-94;
    V_RMS               = 10^(dB_RMS/20);
    PDBm   = 10*log10(V_RMS^2/1e-3)+G;
end

