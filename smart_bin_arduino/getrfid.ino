//function to get the UID of the card
int getrfid(){  
  if(!rc.PICC_IsNewCardPresent()){
    Serial.print("1");
    return 0;
  }
  if(!rc.PICC_ReadCardSerial()){
    Serial.print("2");
    return 0;
  }
 
  
  Serial.println("THE UID OF THE SCANNED CARD IS:");
  
  for(int i=0;i<4;i++){
    readcard[i]=rc.uid.uidByte[i]; //storing the UID of the tag in readcard
    Serial.print(readcard[i],HEX);
  }
  Serial.println("");
  Serial.println("Now Comparing with Authorised cards");
  rc.PICC_HaltA();
  return 1;
}
