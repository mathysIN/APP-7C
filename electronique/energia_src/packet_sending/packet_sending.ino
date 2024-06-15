#define SIZE_SENDING 20
#define SIZE_RECEIVING 20
#define SENSOR_TEMPERATURE 0x33
#define SENSOR_AUDIO 0x37

char packetSender[SIZE_SENDING + 1];
char packetReceiver[SIZE_RECEIVING + 1];

char convertHexToAsc(int digit);
void sendPacket(char sensorType, int valeurCapt);
void receivingPacket(void);
void analyzePacket(void);

void setup()
{
    Serial.begin(9600);
    Serial1.begin(9600);
    initPacket();
}

void loop()
{
    int valeur_Temp = 0x1234;
    sendPacket(SENSOR_TEMPERATURE, valeur_Temp);
    // receivingPacket();
    // analyzePacket();
    delay(5000);
}

void receivingPacket(void)
{
    int receivedCount, length;
    char digRecu;

    Serial.print("Received -> ");
    receivedCount = 0;
    Serial.println();
}

void analyzePacket(void)
{
    Serial.println();
}

void sendPacket(char sensorType, int valeurCapt)
{
    int digit, i;
    char checksum, digAsc;

    packetSender[6] = sensorType;

    digit = (valeurCapt >> 12) & 0x0F;
    packetSender[9] = convertHexToAsc(digit);
    digit = (valeurCapt >> 8) & 0x0F;
    packetSender[10] = convertHexToAsc(digit);
    digit = (valeurCapt >> 4) & 0x0F;
    packetSender[11] = convertHexToAsc(digit);
    digit = valeurCapt & 0x0F;
    packetSender[12] = convertHexToAsc(digit);

    Serial.print("Trame Envoyée = ");
    checksum = 0;
    for (i = 0; i < SIZE_SENDING - 2; i++)
    {
        Serial.print(packetSender[i]);
        Serial1.print(packetSender[i]);
        checksum = checksum + packetSender[i];
    }
    digit = (checksum >> 4) & 0x0F;
    digAsc = convertHexToAsc(digit);
    Serial.print(digAsc);
    Serial1.print(digAsc);
    digit = checksum & 0x0F;
    digAsc = convertHexToAsc(digit);
    Serial.print(digAsc);
    Serial1.print(digAsc);
    Serial.println();
}

char convertHexToAsc(int digit)
{
    char ascValue;
    // Garder que les 4 bits de poid faible = 1 chiffre hexa (0 à 15)
    digit &= 0x0F;
    ascValue = digit + 0x30;
    if (digit > 9)
        ascValue += 0x07;
    return ascValue;
}

void initPacket(void)
{
    // -> Type de trame
    packetSender[0] = '1';

    // -> Object (Nom de l'équipe)
    packetSender[1] = 'G';
    packetSender[2] = '0';
    packetSender[3] = '7';
    packetSender[4] = 'C';

    // -> Type de requête
    packetSender[5] = '1';

    // -> Type de capteur
    // packetSender[6] = x;

    // -> Numero du capteur
    packetSender[7] = '0';
    packetSender[8] = '1';

    // -> Valeur du capteur
    // packetSender[] = x;
    // packetSender[] = x;
    // packetSender[] = x;
    // packetSender[] = x;

    // -> Timestamp
    packetSender[13] = 'F';
    packetSender[14] = 'A';
    packetSender[15] = 'F';
    packetSender[16] = 'B';

    // -> Checksum
    // packetSender[17] = '0';

    // -> Dernier octet de la trame
    // packetSender[18] = '0';
}
