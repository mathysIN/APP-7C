int i = 0;

void setup()
{
    Serial.begin(9600);
    Serial.println("Bonjour");
}
void loop()
{
    Serial.println("i = ");
    Serial.println(i++);
}