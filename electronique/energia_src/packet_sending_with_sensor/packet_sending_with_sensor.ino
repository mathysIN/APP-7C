#define MICROPHONE_PIN PD_2
#define LOW_LEVEL 0
#define MAX_LEVEL 4095
#define AVR_LEVEL MAX_LEVEL / 2
#define SAMPLE_FREQ 9000
#define SIZE_BUFF 9000
#define SAMPLE_PERIOD (1000 / SAMPLE_FREQ)

#define SIZE_SENDING 20
#define SENSOR_TEMPERATURE 0x33
#define SENSOR_AUDIO 0x37

char packetSender[SIZE_SENDING + 1];

short bufferSample[SIZE_BUFF];
float powerInst[SIZE_BUFF];
short sampleCount;

float getSoundPower(void);

char convertHexToAsc(int digit);
void sendPacket(char sensorType, int valeurCapt);
void analyzePacket(void);

void setup()
{
    Serial.begin(9600);
    Serial1.begin(9600);
    Serial.println("AT+NAMEG7C");
    Serial1.println("AT+NAMEG7C");
    pinMode(MICROPHONE_PIN, INPUT);
    initPacket();
}

void loop()
{
    while(1) {
      float soundPower;

      Serial.println("");
      Serial.println("--- Sound Power Measurement ---");
  
      processSamples();
      soundPower = getSoundPower();
  
      Serial.print("Power = ");
      Serial.println(soundPower);
      if (soundPower > AVR_LEVEL)
      {
          Serial.println("Sound level is too high");
      }
      else
      {
          Serial.println("Sound level is good");
      }
      sendPacket(SENSOR_TEMPERATURE, soundPower);
      delay(2000);
    }
}

void processSamples(void)
{
    short sampleValue;
    unsigned long curtime, nextime;

    nextime = micros() + SAMPLE_PERIOD;
    sampleCount = 0;
    while (sampleCount < SIZE_BUFF)
    {
        do
        {
            curtime = micros();
        } while (curtime < nextime);
        sampleValue = analogRead(MICROPHONE_PIN);
        bufferSample[sampleCount] = sampleValue;
        sampleCount++;
        nextime += SAMPLE_PERIOD;
    }
    return;
}

float getSoundPower(void)
{
    float power = 0;
    for (int i = 0; i < sampleCount; i++)
    {
        power += (bufferSample[i] / MAX_LEVEL) * 3.3;
    };
    return power;
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
    packetSender[13] = '0';
    packetSender[14] = '1';
    packetSender[15] = '2';
    packetSender[16] = '5';

    // -> Checksum
    // packetSender[17] = '5';

    // -> Dernier octet de la trame
    // packetSender[18] = '3';
}
