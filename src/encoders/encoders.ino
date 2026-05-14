// light-mixer firmware
// It requires three libraries:
//
// v1.1 20211205
// v1.2 20260513
//
//  * QRCode by Richard Moore (https://github.com/ricmoo/qrcode/)
//  * ssd1306 by Alexey Dynda (https://github.com/lexus2k/ssd1306)
//  * Adafruit_NeoPixel by Adafruit

#include "RotEnLib.h"
#include "ssd1306.h"
#include "nano_gfx.h"
#include <Adafruit_NeoPixel.h>
#include "qrcode.h"

#define MULTIBTNTHRESHOLD 150

Adafruit_NeoPixel strip = Adafruit_NeoPixel(1, 8, NEO_GRB + NEO_KHZ800);
bool showingQR = false;

RELEncoder encoderR = RELEncoder(3, 2, 11, 0, 255); // pinA, pinB, btn, min, max
uint8_t savedpositionR = 0;
uint32_t releasedR = 0;
RELEncoder encoderG = RELEncoder(5, 4, 10, 0, 255); // pinA, pinB, btn, min, max
uint8_t savedpositionG = 0;
uint32_t releasedG = 0;
RELEncoder encoderB = RELEncoder(7, 6,  9, 0, 255); // pinA, pinB, btn, min, max
uint8_t savedpositionB = 0;
uint32_t releasedB = 0;


void onButtonReleased(RELEncoder& encoder, unsigned long when)
{
	// first check QR display status
	if (showingQR)
	{
		// hide QR
		ssd1306_normalMode();
		drawFullScreen();
		showingQR = false;
		return;
	}
	// take note of release time and save it golbally
	if (&encoder == &encoderR) releasedR = when;
	if (&encoder == &encoderG) releasedG = when;
	if (&encoder == &encoderB) releasedB = when;

	// handle buttons relative states
	bool btnRclicked = (when - releasedR < MULTIBTNTHRESHOLD);
	bool btnGclicked = (when - releasedG < MULTIBTNTHRESHOLD);
	bool btnBclicked = (when - releasedB < MULTIBTNTHRESHOLD);

	if (btnRclicked && btnGclicked && btnBclicked)
	{
		// White = Red + Green + Blue
		encoderR.setPosition(255);
		encoderG.setPosition(255);
		encoderB.setPosition(255);
	}
	else if (btnRclicked && btnGclicked)
	{
		// Yellow = Red + Green
		encoderR.setPosition(255);
		encoderG.setPosition(255);
		encoderB.setPosition(0);
	}
	else if (btnRclicked && btnBclicked)
	{
		// Magenta = Red + Blue
		encoderR.setPosition(255);
		encoderG.setPosition(0);
		encoderB.setPosition(255);
	}
	else if (btnGclicked && btnBclicked)
	{
		// Cyan = Green + Blue
		encoderR.setPosition(0);
		encoderG.setPosition(255);
		encoderB.setPosition(255);
	}
	else if (btnRclicked)
	{
		// Red
		encoderR.setPosition(255);
		encoderG.setPosition(0);
		encoderB.setPosition(0);
	}
	else if (btnGclicked)
	{
		// Green
		encoderR.setPosition(0);
		encoderG.setPosition(255);
		encoderB.setPosition(0);
	}
	else if (btnBclicked)
	{
		// Blue
		encoderR.setPosition(0);
		encoderG.setPosition(0);
		encoderB.setPosition(255);
	}
} // onButtonReleased()

void onButtonLongPressed(RELEncoder& encoder, unsigned long duration)
{
	if (!showingQR)
	{
		// show QR
		ssd1306_clearScreen();
		drawQRcode(savedpositionR, savedpositionG, savedpositionB);
		ssd1306_invertMode();
		showingQR = true;
		return;
	}
} // onButtonLongPressed()

static void drawIndicator(uint8_t value, uint8_t color)
{
	char text[6] = " :   \0";
	uint8_t bank1, bank2;
	uint8_t buffer_text[32 * 8 / 8];
	uint8_t buffer_slider[128 * 8 / 8];
	NanoCanvas canvas_t( 32, 8, buffer_text);
	NanoCanvas canvas_s(128, 8, buffer_slider);
	switch (color)
	{
		case 1: 
			text[0] = 'R';
			bank1 = 0;
			bank2 = 1;
		break;
		case 2: 
			text[0] = 'G';
			bank1 = 2;
			bank2 = 3;
		break;
		case 3: 
			text[0] = 'B';
			bank1 = 4;
			bank2 = 5;
		break;
	}
	sprintf(&text[2], "%d", value); // numeric representation
	//itoa(value, &text[2], 10); // TODO: compare performance vs above
	uint8_t p = trunc(value / 2);
	canvas_t.printFixed(1, 1, text, STYLE_NORMAL);
	canvas_t.blt(48, bank1);
	canvas_s.drawRect(p, 2, 127, 6); // 2nd half: empty
	canvas_s.fillRect(0, 2,   p, 6, 0xff); // first half: filled
	canvas_s.blt(0, bank2);
} // drawIndicator()

void setLight(uint8_t R, uint8_t G, uint8_t B)
{
	strip.setPixelColor(0, R, G, B);
	strip.show();
} // setLight()

void drawFullScreen()
{
	ssd1306_clearScreen();
	ssd1306_printFixed(0, 56, "ROBOteach Light-Mixer", STYLE_NORMAL);
	drawIndicator(savedpositionR, 1);
	drawIndicator(savedpositionG, 2);
	drawIndicator(savedpositionB, 3);
} // drawFullScreen()

void drawQRcode(uint8_t R, uint8_t G, uint8_t B)
{
	char url[] = "https://www.roboteach.es/lm-badge?c=rrggbb\0";
	sprintf(&url[36], "%02x", R);
	sprintf(&url[38], "%02x", G);
	sprintf(&url[40], "%02x", B);
	// Create the QR code
	QRCode qrcode;
	uint8_t qrcodeData[qrcode_getBufferSize(3)];
	qrcode_initText(&qrcode, qrcodeData, 3, 0, url);
	uint8_t offset = ((64 - qrcode.size * 2) / 2) - 1;
	// draw it
	uint8_t buffer[64 * 64 / 8]; // 64x64 pixels
	NanoCanvas canvas(64, 64, buffer);
	//canvas.clearScreen();
	for (uint8_t y = 0; y < qrcode.size; y ++)
	{
		// Each horizontal module
		for (uint8_t x = 0; x < qrcode.size; x ++)
		{
			if (qrcode_getModule(&qrcode, x, y))
			{
				canvas.putPixel(x * 2 + offset,     y * 2 + offset);
				canvas.putPixel(x * 2 + 1 + offset, y * 2 + offset);
				canvas.putPixel(x * 2 + offset,     y * 2 + 1 + offset);
				canvas.putPixel(x * 2 + 1 + offset, y * 2 + 1 + offset);
			}
		}
	}
	canvas.blt(32, 0);
} // drawQRcode()

void setup()
{
	Serial.begin(115200);
	Serial.println("Light-Mixer v1.2 by ROBOteach");
	strip.begin();
	// encoders button callbacks
	encoderR.setButtonOnReleaseCB(onButtonReleased);
	encoderG.setButtonOnReleaseCB(onButtonReleased);
	encoderB.setButtonOnReleaseCB(onButtonReleased);
	encoderR.setButtonOnLongPressCB(onButtonLongPressed);
	encoderG.setButtonOnLongPressCB(onButtonLongPressed);
	encoderB.setButtonOnLongPressCB(onButtonLongPressed);
	// initial flash
	setLight(0, 0, 0); // extra paranoid
	uint8_t flashes[4][3] = { {128,0,0}, {0,128,0}, {0,0,128}, {128,128,128} };
	for (uint8_t i = 0; i < 4; i ++)
	{
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

void loop()
{
	// update controls status
	unsigned long nowt = millis();
	encoderR.loop(nowt);
	encoderG.loop(nowt);
	encoderB.loop(nowt);

	if (showingQR) return;

	// read values and draw color
	// get encoder positions
	uint8_t positionR = encoderR.getPosition();
	uint8_t positionG = encoderG.getPosition();
	uint8_t positionB = encoderB.getPosition();
	// redraw sliders if neccessary
	if (positionR != savedpositionR)
	{
		drawIndicator(positionR, 1);
		savedpositionR = positionR;
		setLight(savedpositionR, savedpositionG, savedpositionB);
	}
	if (positionG != savedpositionG)
	{
		drawIndicator(positionG, 2);
		savedpositionG = positionG;
		setLight(savedpositionR, savedpositionG, savedpositionB);
	}
	if (positionB != savedpositionB)
	{
		drawIndicator(positionB, 3);
		savedpositionB = positionB;
		setLight(savedpositionR, savedpositionG, savedpositionB);
	}
}
