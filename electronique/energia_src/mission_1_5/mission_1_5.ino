#define LED_PIN_ROUGE PF_1
#define LED_PIN_VERTE PF_3
#define LED_PIN_BLEU PF_2

void setup() {
  Serial.begin(9600);
  pinMode(LED_PIN_ROUGE, OUTPUT);
  pinMode(LED_PIN_VERTE, OUTPUT);
  pinMode(LED_PIN_BLEU, OUTPUT);
}

void loop() {
  digitalWrite(LED_PIN_ROUGE, HIGH);
  digitalWrite(LED_PIN_VERTE, HIGH);
  digitalWrite(LED_PIN_BLEU, HIGH);
}
