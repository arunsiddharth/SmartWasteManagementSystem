void set_led(int r,int g,int b){
  analogWrite(lredpin,r);
  analogWrite(lgreenpin,g);
  analogWrite(lbluepin,b);
}

void off_led(){
  set_led(0,0,0);  
}

void test_led(){
  set_led(254,254,254);  
}

void red_led(){
  set_led(255,0,0);
}

void green_led(){
  set_led(0,255,0);
}

void blue_led(){
  set_led(0,0,255);
}

void data_transmit_led(){
  set_led(255,255,0);
}

void idle_led(){
  set_led(255,0,255);  
}
