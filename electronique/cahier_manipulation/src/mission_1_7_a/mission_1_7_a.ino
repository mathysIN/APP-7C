#define POTENTIOMETRE_PIN PE_3
#define TENSION_MAX 3.3
#define VALEUR_NUMERIQUE_MAX 4096

void setup() {
  Serial.begin(9600);
  pinMode(POTENTIOMETRE, INPUT);
}

void loop() {
  int valeurNumerique = analogRead(POTENTIOMETRE);
  float tension = (float) valeurNumerique * (3.3/VALEUR_NUMERIQUE_MAX) - 1;
  Serial.print("Tension = ");
  Serial.print(tension);
  Serial.print("V");
  Serial.println("");
  delay(500);
}
