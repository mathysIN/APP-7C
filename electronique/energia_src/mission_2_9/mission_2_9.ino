#define MICROPHONE_PIN PD_2
#define LOW_LEVEL 0
#define MAX_LEVEL 4095
#define AVR_LEVEL MAX_LEVEL / 2
#define SAMPLE_FREQ 9000
#define SIZE_BUFF 9000
#define SAMPLE_PERIOD (1000 / SAMPLE_FREQ)

short bufferSample[SIZE_BUFF];
float powerInst[SIZE_BUFF];
short sampleCount;

float getSoundPower(void);

void setup()
{
	Serial.begin(9600);
	pinMode(MICROPHONE_PIN, INPUT);
}

void loop()
{
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
	delay(2000);
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