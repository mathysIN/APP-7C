
#include "Elitech128.h"
void setup() {
  InitI2C();
  InitScreen();
  Display(motif);
  DisplayString(0,5,"ELITECH");
  DisplayString(0,7,"PREMIUM EVENT SOLUTIONS");
}

void loop() {
}
