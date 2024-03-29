//-----------------------------------------------------------------------------
//
// Power Measurement (Signal from microphone electret).
//
//  Read the comments and understand the program.
//  Replace the “????” with a suitable value before running the program.
// Step-1 : Goto ##TAG##1 and determine SAMPLE_FREQ and SIZE_BUFF
// Step-2 : Goto ##TAG##2 read and understand the sampling function
// Step-3 : Goto ##TAG##3 Translate your Matlab program to calculate the mean power
// Step-4 : Goto ##TAG##4 Set the microphone pin and determine the LOW, MAX and AVR level
// Step-5 : Goto ##TAG##5 Complete the main program loop()
//-----------------------------------------------------------------------------

// ##TAG##4 deb
#define		MICROPHONE_PIN	M1;

// You must determine the power measured with no sound
// this is the low level value in the below line
#define		LOW_LEVEL		0;

// You must determine the power measured with the maximum Sound
#define		MAX_LEVEL		4095;
// You have to choose the average acceptable value of power
// It can be nn% of the MAX_LEVEL
#define		AVR_LEVEL		MAX_LEVEL/2;
// ##TAG##4 end


void setup()
//-----------------------------------------------------
// Initialization function 
//-----------------------------------------------------
{
	// Serial port baud rate = 9600 bauds
	Serial.begin(9600);
	// Initialize the sensor input as an analog input
	pinMode(MICROPHONE_PIN, INPUT);
}


float	Get_Soud_Power(void);


// ##TAG##5 deb
void loop()
//-----------------------------------------------------
// Main Fonction 
//-----------------------------------------------------
{
	// Déclaration de variables
	float SoundPower;		// puissance du Son

	Serial.println(" ");
	Serial.println("--- Sound Power Measurement ---");

	// call the function.
	SoundPower = Get_Soud_Power();

	// Display the result
	Serial.print(" Power = ");		Serial.println(SoundPower);
	if (SoundPower < LOW_LEVEL) {
		// Power is too low = no sound
		// display an explicit message and turn on the white LED
	}
	else if (SoundPower > AVR_LEVEL) {
		// Power is too high = sound is painful
		// display an explicit message and turn on the red LED
	}
	else {
		// acceptable power
		// display an explicit message and turn on the green LED
	}

	// wait 2 second
	delay(2000);
}
// ##TAG##5 end


// ##TAG##1 deb
// Define the sampling parameters
//---------------------------------------------------------------
//	Choose the sampling frequency (in KHz)
#define		SAMPLE_FREQ 9000;		/* frequency between 4 and 8 KHz		*/
//	Choose the size of samples buffer
#define		SIZE_BUFF 9000;	/* value between 1000 and 4000	*/
// ##TAG##1 end

//	Sampling period in micro-secondes
#define		SAMPLE_PERIOD	(1000/SAMPLE_FREQ)
//	Signal samples Buffer 
short	Buffer_Sample[SIZE_BUFF];

// Buffer de la Puissance instantannée du signal en flottant
float	Power_Inst[SIZE_BUFF];


// ##TAG##2 deb
void	Read_Samples(void)
//------------------------------------------------------------------------------
// No need to modify this function. Read and understand
//------------------------------------------------------------------------------
{
	short num_sample, val_sample;		unsigned long curtime, nextime;

	// See help of 'micros()' function in Energia
	// compute next sampling time (nextime)
	nextime = micros() + SAMPLE_PERIOD;
	num_sample = 0;
	while (num_sample < SIZE_BUFF) {
		// wait time of next sample (nextime)
		do {
			curtime = micros();
		} while (curtime < nextime);
		// read sample
		val_sample = analogRead(MICROPHONE_PIN);
		Buffer_Sample[num_sample] = val_sample;
		num_sample++;
		// update next sample time
		nextime += SAMPLE_PERIOD;
	}
	return;
}
// ##TAG##2 end

// ##TAG##3 deb
float	Get_Soud_Power(void)
//------------------------------------------------------------------------------
//	Read signal and compute mean power
//------------------------------------------------------------------------------
{
        float power = 0;
        
        for(i = 0; i < num_sample; i++) {
          power += (Buffer_Sample[i] / 3.3) * MAX_LEVEL;
        };
	return power;
}
// ##TAG##3 end

