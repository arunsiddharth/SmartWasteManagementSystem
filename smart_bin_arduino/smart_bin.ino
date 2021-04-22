#include <SoftwareSerial.h>
#include<SPI.h>
#include<MFRC522.h>

#define ESP8266_rxPin 2
#define ESP8266_txPin 4

/*RFID SECTION*/
//creating mfrc522 instance
#define RSTPIN 9
#define SSPIN 10
MFRC522 rc(SSPIN, RSTPIN);

int readsuccess;

/* the following are the UIDs of the card which are authorised
    to know the UID of your card/tag use the example code 'DumpInfo'
    from the library mfrc522 it give the UID of the card as well as 
    other information in the card on the serial monitor of the arduino*/

//byte defcard[4]={0x32,0xD7,0x0F,0x2B}; // if you only want one card
byte defcard[][4]={{0x32,0xD9,0x4C,0x43},{0xFD,0xE6,0x47,0xD3}}; //for multiple cards 0xFD,0xE6,0x47,0xD3
String strcard[] = {"32D94C43","FDE647D3"};
int N=2; //change this to the number of cards/tags you will use
byte readcard[4]; //stores the UID of current tag which is read
/*RFID END*/



//SSID + KEY
const char SSID_ESP[] = "nfs";
const char SSID_KEY[] = "1234567890a";

/**************VARIABLES FOR PROJECT*****************/
int trigPin=7;
int lredpin=3;
int lgreenpin=5;
int lbluepin=6;
int echoPin=8;
float distance;
float prev_distance;
float pingTime;
float speedOfSound=347.22;
int led=13;
int binDepth=40;
int binNo=2;
float pfilled;
String rfidno;
/*****************************************************/

// URLs
const char URL_TS4[] = "GET https://api.thingspeak.com/update?api_key=YWUN1F2E6MIYXF0Q";
const char append[] = " HTTP/1.0\r\n\r\n";


const char append2[] = " HTTP/1.0\r\nHost: espha.000webhostapp.com\r\n\r\n";//GET https://espha.000webhostapp.com/sensor.php?
const char URL_TS2[] = "GET /collectionapi.php?";//collectionapi.php?bid=4&tag=12345678&fill=0.0



String Sense_Values;
//MODES
const char CWMODE = '1';//CWMODE 1=STATION, 2=APMODE, 3=BOTH
const char CIPMUX = '1';//CWMODE 0=Single Connection, 1=Multiple Connections

SoftwareSerial ESP8266(ESP8266_rxPin, ESP8266_txPin);// rx tx

//DEFINE ALL FUNCTIONS HERE
boolean setup_ESP();
boolean read_until_ESP(const char keyword1[], int key_size, int timeout_val, byte mode);
void timeout_start();
boolean timeout_check(int timeout_ms);
void serial_dump_ESP();
boolean connect_ESP();
boolean coonect_ESPHA();
int getrfid();
boolean rfid();
void get_TS4();
void get_TS2();
void set_led(int r,int g,int b);
void off_led();
void test_led();
void red_led();
void green_led();
void blue_led();
void data_transmit_led();
void idle_led();

//DEFINE ALL GLOBAL VARIABLES HERE
unsigned long timeout_start_val;
char scratch_data_from_ESP[20];//first byte is the length of bytes
char payload[150];
byte payload_size=0, counter=0;
char ip_address[16];
char data[10];

//DEFINE KEYWORDS HERE FOR SEARCH
const char keyword_OK[] = "OK";
const char keyword_Ready[] = "Ready";
const char keyword_no_change[] = "no change";
const char keyword_blank[] = "#&";
const char keyword_ip[] = "192.";
const char keyword_rn[] = "\r\n";
const char keyword_quote[] = "\"";
const char keyword_carrot[] = ">";
const char keyword_sendok[] = "SEND OK";
const char keyword_linkdisc[] = "Unlink";
const char keyword_html_start_b[] = "b>";
const char keyword_html_end_b[] = "</b";
const char keyword_html_start_temp[] = "\"{";
const char keyword_html_end_temp[] = "}\"";

void setup(){
  
  //Pin Modes for ESP TX/RX
  pinMode(ESP8266_rxPin, INPUT);
  pinMode(ESP8266_txPin, OUTPUT);
  pinMode(lredpin,OUTPUT);
  pinMode(lbluepin,OUTPUT);
  pinMode(lgreenpin,OUTPUT);
  test_led();
  ESP8266.begin(9600);//default baudrate for ESP
  ESP8266.listen();//not needed unless using other software serial instances
  Serial.begin(9600); //for status and debug
  delay(2500);//delay before kicking things off
  
  //SET PINS FOR US
  pinMode(trigPin,OUTPUT);
  pinMode(echoPin,INPUT);
  /*RFID SETUP*/
  SPI.begin();
  rc.PCD_Init(); //initialize the receiver  
  rc.PCD_DumpVersionToSerial(); //show details of card reader module
  /*RFID END*/
  
  setup_ESP();//go setup the ESP 
  prev_distance=binDepth;
}


void loop(){
  idle_led();
  rfidno="";
  //digitalWrite(LEDPIN,LOW);
  digitalWrite(trigPin,LOW);
  delayMicroseconds(2000);
  
  digitalWrite(trigPin,HIGH);
  delayMicroseconds(10);
  
  digitalWrite(trigPin,LOW);
  pingTime=pulseIn(echoPin,HIGH);
  distance=(speedOfSound*pingTime)/2;
  distance=distance/10000;
  Serial.print("Distance in centimetre is ");
  Serial.println(distance);
  pfilled = (binDepth-distance)/binDepth;
  if(pfilled<0)pfilled=1;
  pfilled*=100;
  if(prev_distance-distance>5){
    data_transmit_led();
    Sense_Values = "&field";
    Sense_Values += String(binNo);
    Sense_Values += "=";
    Sense_Values += String(pfilled);
    get_TS4();
    prev_distance=distance;
    Sense_Values.remove(0,Sense_Values.length());
    green_led();
    delay(10000);
  }
 
  /*RFID SETUP*/
  SPI.begin();
  rc.PCD_Init(); //initialize the receiver  
  rc.PCD_DumpVersionToSerial(); //show details of card reader module
  /*RFID END*/
  if(rfid()){
    data_transmit_led();
    Sense_Values = "bid=";
    Sense_Values += String(binNo);
    Sense_Values += "&rfid=";
    Sense_Values += rfidno;
    Sense_Values += "&fill=";
    Sense_Values += String(pfilled);
    get_TS2();
    Sense_Values.remove(0,Sense_Values.length());
    //digitalWrite(LEDPIN,HIGH);
    green_led();
    delay(1000);
  }
  off_led();
  delay(100);
}

