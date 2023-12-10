#define POTENTIOMETRE_PIN PE_3
#define TENSION_MAX 3.3
#define VALEUR_NUMERIQUE_MAX 4096

void setup() {
  Serial.begin(9600);
  pinMode(POTENTIOMETRE_PIN, INPUT);
}

void loop() {
  int valeurNumerique = analogRead(POTENTIOMETRE_PIN);
  float tension = (float) valeurNumerique * (3.3/VALEUR_NUMERIQUE_MAX);
  Serial.print("Valeur numérique = ");
  Serial.print(valeurNumerique);
  Serial.print(" - ");
  Serial.print("Tension = ");
  Serial.print(tension);
  Serial.print("V");
  Serial.println("");
  delay(500);
}
