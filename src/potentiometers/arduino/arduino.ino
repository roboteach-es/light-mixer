#include <Arduino.h>
#include <Wire.h>
#include <SoftwareSerial.h>

#include "NeoPixel.h"


double angle_rad = PI/180.0;
double angle_deg = 180.0/PI;
double R;
double G;
double B;
Adafruit_NeoPixel strip = Adafruit_NeoPixel(1, 3, NEO_GRB + NEO_KHZ800);



void setup(){
    strip.begin(); 
    pinMode(A0+1,INPUT);
    pinMode(A0+2,INPUT);
    pinMode(A0+3,INPUT);
    
}

void loop(){
    
    R = floor((analogRead(A0+1)) / (4));
    G = floor((analogRead(A0+2)) / (4));
    B = floor((analogRead(A0+3)) / (4));
    strip.setPixelColor(0, R, G, B);
    strip.show();
    _delay(0.1);
    
    _loop();
}

void _delay(float seconds){
    long endTime = millis() + seconds * 1000;
    while(millis() < endTime)_loop();
}

void _loop(){
    
}

