boolean rfid(){
  //if driver tries to scan in input
  readsuccess = getrfid();
  if(readsuccess){
    int match=-1;
    //this is the part where compare the current tag with pre defined tags
    for(int i=0;i<N;i++){
      Serial.print("Testing Against Authorised card no: ");
      Serial.println(i+1);
      if(!memcmp(readcard,defcard[i],4)){
        match=i;
      }
    }
    if(match!=-1){
        Serial.println("CARD AUTHORISED");
        rfidno = strcard[match];
        return true;
    }
    else {
        Serial.println("CARD NOT Authorised");
        return false;
    }
  }
  return false;
}
