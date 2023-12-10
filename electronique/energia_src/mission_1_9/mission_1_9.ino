int counter = 0;
unsigned long time;

void setup() {
  Serial.begin(9600);
  Serial1.begin(9600);
  Serial.println("AT+NAMEG7C");
  Serial1.println("AT+NAMEG7C");
}

void loop() {
  while(1) {
    time = millis();
    Serial1.print("Test module HC-06 bluetooth");
    Serial1.print(" " );
    Serial1.println(time);
  };
}
