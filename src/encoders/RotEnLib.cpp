// RotEnLib
// -----
// author: mgesteiro
// date: 20211205

#include "RotEnLib.h"
#include "Arduino.h"


// constructor
RELEncoder::RELEncoder(int S1, int S2, int min, int max, int threshold=15000, int thdelta=10)
{
  // Remember Hardware Setup
  _s1 = S1;
  _s2 = S2;
  _min = min;
  _max = max;
  _th = threshold;
  _thd = thdelta;
  _position = 0;

  // Setup the input pins and turn on pullup resistor
  pinMode(_s1, INPUT_PULLUP);
  pinMode(_s2, INPUT_PULLUP);
} // RELEncoder()


int RELEncoder::getPosition()
{
  return _position;
} // getPosition()


void RELEncoder::loop(void)
{
  _s1State = digitalRead(_s1);
  // check if S1 has changed -> that means a Pulse has occured
  if (_s1State != _s1LastState) {
    unsigned long nowt = micros();
    // simple debouncing filter: 4 ms minimun window
    if ((nowt-_savedt) < 4000) return;
    // only count when S1 is LOW
    if (! _s1State) {
      unsigned long nowt = micros();
      int delta = ((nowt-_savedt) < _th) ? _thd : 1;
      // if S2 state is the same as S1 state -> the encoder is rotating clockwise
      if (digitalRead(_s2) == _s1State) _position+=delta;
      else _position-=delta;

      if (_position > _max) _position=_max;
      if (_position < _min) _position=_min;

      _savedt=nowt; 
    }
  } 
  _s1LastState = _s1State;
} // loop()

// End
