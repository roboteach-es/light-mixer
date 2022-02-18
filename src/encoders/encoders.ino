// light-mixer firmware v1.1
// It requires two libraries:
//
//  * QRCode by Richard Moore (https://github.com/ricmoo/qrcode/)
//  * ssd1306 by Alexey Dynda (https://github.com/lexus2k/ssd1306)

#include "RotEnLib.h"
#include "ssd1306.h"
#include "nano_gfx.h"
#include <Adafruit_NeoPixel.h>
#include "qrcode.h"

Adafruit_NeoPixel strip = Adafruit_NeoPixel(1, 8, NEO_GRB + NEO_KHZ800);
bool showingQR = false;

RELEncoder encoder23 = RELEncoder(3, 2, 11, 0, 255); // pinA, pinB, btn, min, max
uint8_t savedposition23 = 0;
RELEncoder encoder45 = RELEncoder(5, 4, 10, 0, 255); // pinA, pinB, btn, min, max
uint8_t savedposition45 = 0;
RELEncoder encoder67 = RELEncoder(7, 6, 9, 0, 255); // pinA, pinB, btn, min, max
uint8_t savedposition67 = 0;

void onButtonReleased(RELEncoder& encoder, unsigned long duration){
  // first check QR display status
  if (showingQR) {
    // hide QR
    ssd1306_normalMode();
    drawFullScreen();
    showingQR = false;
    return;
  }
  // full color
  if (&encoder == &encoder23)
  {
    encoder23.setPosition(255);
    encoder45.setPosition(0);
    encoder67.setPosition(0);
  }
  if (&encoder == &encoder45)
  {
    encoder23.setPosition(0);
    encoder45.setPosition(255);
    encoder67.setPosition(0);
  }
  if (&encoder == &encoder67)
  {
    encoder23.setPosition(0);
    encoder45.setPosition(0);
    encoder67.setPosition(255);
  }  
} // onButtonReleased()

void onButtonLongPressed(RELEncoder& encoder, unsigned long duration){
  if (!showingQR) {
    // show QR
    ssd1306_clearScreen();
    drawQRcode(savedposition23, savedposition45, savedposition67);
    ssd1306_invertMode();
    showingQR = true;
    return;
  }
} // onButtonLongPressed()

static void drawIndicator(uint8_t value, uint8_t color)
{
  char text[6] = " :   \0";
  uint8_t bank1,bank2;
  uint8_t buffer_text[32*8/8];
  uint8_t buffer_slider[128*8/8];
  NanoCanvas canvas_t( 32, 8, buffer_text);
  NanoCanvas canvas_s(128, 8, buffer_slider);
  switch (color) { 
    case 1: 
      text[0]='R';
      bank1=0;
      bank2=1;
    break;
    case 2: 
      text[0]='G';
      bank1=2;
      bank2=3;
    break;
    case 3: 
      text[0]='B';
      bank1=4;
      bank2=5;
    break;
  }
  sprintf(&text[2], "%d", value); // numeric representation
  //itoa(value, &text[2], 10); // TODO: compare performance vs above
  uint8_t p = trunc(value/2);
  canvas_t.printFixed(1, 1, text, STYLE_NORMAL);
  canvas_t.blt(48, bank1);
  canvas_s.drawRect(p, 2, 127, 6); // 2nd half: empty
  canvas_s.fillRect(0, 2,   p, 6, 0xff); // first half: filled
  canvas_s.blt(0, bank2);
} // drawIndicator()

void setLight(uint8_t R, uint8_t G, uint8_t B) {
  strip.setPixelColor(0, R, G, B);
  strip.show();
} // setLight()

void drawFullScreen() {
  ssd1306_clearScreen();
  ssd1306_printFixed(3,56,"ROBOteach LightMixer",  STYLE_NORMAL);
  drawIndicator(savedposition23, 1);
  drawIndicator(savedposition45, 2);
  drawIndicator(savedposition67, 3);
} // drawFullScreen()

void drawQRcode(uint8_t R, uint8_t G, uint8_t B) {
  char url[] = "https://www.roboteach.es/lm-badge?c=rrggbb\0";
  sprintf(&url[36], "%02x", R);
  sprintf(&url[38], "%02x", G);
  sprintf(&url[40], "%02x", B);
  // Create the QR code
  QRCode qrcode;
  uint8_t qrcodeData[qrcode_getBufferSize(3)];
  qrcode_initText(&qrcode, qrcodeData, 3, 0, url);
  uint8_t offset = ((64-qrcode.size*2)/2)-1;
  // draw it
  uint8_t buffer[64*64/8]; // 64x64 pixels
  NanoCanvas canvas(64, 64, buffer);
  //canvas.clearScreen();
  for (uint8_t y = 0; y < qrcode.size; y++) {
    // Each horizontal module
    for (uint8_t x = 0; x < qrcode.size; x++) {
      if (qrcode_getModule(&qrcode, x, y)) {
        canvas.putPixel(x*2+offset,   y*2+offset);
        canvas.putPixel(x*2+1+offset, y*2+offset);
        canvas.putPixel(x*2+offset,   y*2+1+offset);
        canvas.putPixel(x*2+1+offset, y*2+1+offset);
      }
    }
  }
  canvas.blt(32,0);
} // drawQRcode()

void setup() {
  Serial.begin(115200);
  Serial.println("light-mixer v1.1 by ROBOteach");
  strip.begin();
  // encoders button callbacks
  encoder23.setButtonOnReleaseCB(onButtonReleased);
  encoder45.setButtonOnReleaseCB(onButtonReleased);
  encoder67.setButtonOnReleaseCB(onButtonReleased);
  encoder23.setButtonOnLongPressCB(onButtonLongPressed);
  encoder45.setButtonOnLongPressCB(onButtonLongPressed);
  encoder67.setButtonOnLongPressCB(onButtonLongPressed);
  // initial flash
  setLight(0, 0, 0); // extra paranoid
  uint8_t flashes[4][3] = { {128,0,0}, {0,128,0}, {0,0,128}, {128,128,128} };
  for (uint8_t i=0; i<4; i++) {
    setLight(flashes[i][0], flashes[i][1], flashes[i][2]);
    delay(100);
    setLight(0, 0, 0);
    delay(300);
  }
  // initial screen
  ssd1306_128x64_i2c_init();
  ssd1306_setFixedFont(ssd1306xled_font6x8);
  drawFullScreen();
}

void loop() {
  // update controls status
  encoder23.loop();
  encoder45.loop();
  encoder67.loop();

  if (showingQR) return;

  // read values and draw color
  // get encoder positions
  uint8_t position23 = encoder23.getPosition();
  uint8_t position45 = encoder45.getPosition();
  uint8_t position67 = encoder67.getPosition();
  // redraw sliders if neccessary
  if (position23 != savedposition23) {
    drawIndicator(position23, 1);
    savedposition23 = position23;
    setLight(savedposition23, savedposition45, savedposition67);
  }
  if (position45 != savedposition45) {
    drawIndicator(position45, 2);
    savedposition45 = position45;
    setLight(savedposition23, savedposition45, savedposition67);
  }
  if (position67 != savedposition67) {
    drawIndicator(position67, 3);
    savedposition67 = position67;
    setLight(savedposition23, savedposition45, savedposition67);
  }
}
