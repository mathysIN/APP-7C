#include <stdio.h>

void show_data(double *y, double fs, double seuilDetectionDBm, double *invalidList, double step)
{
    double fontSize = 18;
    double threshold = 0.50;
    double duration = (double)(sizeof(y) / sizeof(y[0])) / fs;

    for (int i = 0; i < sizeof(invalidList) / sizeof(invalidList[0]); i++)
    {
        printf("Son invalide à la seconde %f\n", invalidList[i]);
    }

    double invalid = (double)(sizeof(invalidList) / sizeof(invalidList[0])) * step;

    printf("%f/%f secondes invalides\n", invalid, duration);

    if (invalid > duration * threshold)
    {
        printf("Le son est très désagréable\n");
    }
    else
    {
        if (invalid > duration * threshold * 0.5)
        {
            printf("Le son est désagréable parfois\n");
        }
        else
        {
            if (invalid != 0)
            {
                printf("Le son est très peu désagréable\n");
            }
            else
            {
                printf("Le son est acceptable\n");
            }
        }
    }
}