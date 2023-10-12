#define BUTTON_PIN PC_6

void setup() {
  Serial.begin(9600);
  pinMode(BUTTON_PIN, INPUT_PULLUP);
}

void loop() {
  int etatBouton = digitalRead(BUTTON_PIN);
  Serial.println(etatBouton == HIGH ? "Non pressé" : "Press");
  delay(500);
}
