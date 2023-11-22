#include <stdio.h>
#include <math.h>

void process_data(double *y, int length, int fs, double step, double *seuilDetectionDBm, double *invalidList, int *invalidListLength)
{
    double sensitivity = -48.0;
    double gain = 30.0;
    double seuilDetectionSPL = 80.0;
    double dB_RMS = seuilDetectionSPL + sensitivity - 94.0;
    double V_RMS = pow(10, dB_RMS / 20.0);

    *seuilDetectionDBm = 10 * log10(pow(V_RMS, 2) / 1e-3) + gain;

    double bufferInvalid = 0.0;
    *invalidListLength = 0;

    for (int i = 0; i < length; i++)
    {
        y[i] = 10 * log10(pow(y[i], 2) / 1e-3);

        if (y[i] > *seuilDetectionDBm)
        {
            bufferInvalid += 1.0;
        }

        if ((i + 1) % (fs * step) == 0)
        {
            // Chaque pas, si il y a 50% du son taux trop haut, on considère le pas mauvais
            if (bufferInvalid / (fs * step) > 0.5)
            {
                invalidList[*invalidListLength] = (double)(i + 1) / fs;
                (*invalidListLength)++;
            }
            bufferInvalid = 0.0;
        }
    }
}