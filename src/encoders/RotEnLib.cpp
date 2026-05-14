// RotEnLib
// --------
// author: mgesteiro
// v1.0 date: 20211205
// v1.1 date: 20260513

#include "RotEnLib.h"
#include "Arduino.h"

// constructor
RELEncoder::RELEncoder(int S1, int S2, int btn, int min, int max, int threshold = 15, int thdelta = 10)
{
	// Remember Hardware Setup
	this->_s1 = S1;
	this->_s2 = S2;
	this->_btn = btn;
	this->_min = min;
	this->_max = max;
	this->_th = threshold;
	this->_thd = thdelta;
	
	// initial state
	this->_position = 0;
	this->_s1State = 0;
	this->_s1LastState = 0;
	this->_btnState = HIGH;
	this->_btnLastState = HIGH;
	this->_btndebouncing = false;

	// Setup the input pins and turn on pullup resistor
	pinMode(this->_s1, INPUT_PULLUP);
	pinMode(this->_s2, INPUT_PULLUP);
	pinMode(this->_btn, INPUT_PULLUP);
} // RELEncoder()


int RELEncoder::getPosition()
{
	return this->_position;
} // getPosition()

void RELEncoder::setPosition(int newpos)
{
	this->_position = newpos;
} // setPosition()

int RELEncoder::getBtnState()
{
	return this->_btnState;
} // getBtnState()

void RELEncoder::setButtonOnPressCB(ButtonOnPressCallback callback)
{
	_callbackOnPress = callback;
} // setButtonOnReleaseCB()

void RELEncoder::setButtonOnReleaseCB(ButtonOnReleaseCallback callback)
{
	_callbackOnRelease = callback;
} // setButtonOnReleaseCB()

void RELEncoder::setButtonOnLongPressCB(ButtonOnReleaseCallback callback)
{
	_callbackOnLongPress = callback;
} // setButtonOnReleaseCB()

void RELEncoder::loop(unsigned long nowt = 0)
{
	if (! nowt) nowt = millis();
	// BUTTON
	int btnState = digitalRead(this->_btn);
	if (
			(btnState != this->_btnState) // button changed state
			&& (! this->_btndebouncing) // not counting time yet
		)
	{
		// start counting (debounce time)
		this->_btnsavedt = nowt;
		this->_btndebouncing = true;
	}
	if (
			(this->_btndebouncing) // counting time 
			&& ((nowt - this->_btnsavedt) > BTNDEBOUNCETIME) // bigger than debounce time
		)
	{
		// change of state
		if (this->_btnLastState != this->_btnState) this->_btnLastState = this->_btnState;
		this->_btnState = btnState;
		this->_btndebouncing = false;
		if ((_callbackOnRelease) && (this->_btnLastState == LOW) && (this->_btnState == HIGH)) _callbackOnRelease(*this, nowt);
		if ((this->_btnLastState == HIGH) && (this->_btnState == LOW))
		{
			_btnpressed = nowt;
			if (_callbackOnPress) _callbackOnPress(*this, nowt);
		}
	}
	if ((this->_btnLastState == HIGH) && (this->_btnState == LOW) && ((nowt - _btnpressed) > LONGPRESSTIME))
	{
		//_btnLastState == LOW; //stop
		if (_callbackOnLongPress) _callbackOnLongPress(*this, nowt-_btnpressed);
		_btnpressed = nowt;
	}
	
	// ENCODER
	this->_s1State = digitalRead(this->_s1);
	// check if S1 has changed -> that means a pulse has occured
	if (this->_s1State != this->_s1LastState)
	{
		// simple debouncing filter
		if ((nowt-this->_encsavedt) < ENCDEBOUNCETIME) return;
		// only count when S1 is LOW
		if (! this->_s1State)
		{
			int delta = ((nowt-this->_encsavedt) < _th) ? _thd : 1;
			// if S2 state is the same as S1 state -> the encoder is rotating clockwise
			if (digitalRead(this->_s2) == this->_s1State) this->_position += delta;
			else this->_position -= delta;

			if (this->_position > this->_max) this->_position = this->_max;
			if (this->_position < this->_min) this->_position = this->_min;

			this->_encsavedt = nowt; 
		}
	}
	this->_s1LastState = this->_s1State;
} // loop()

// end
