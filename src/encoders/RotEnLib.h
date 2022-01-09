// RotEnLib
// --------
// author: mgesteiro
// date: 20211205

#ifndef RotEnLib_h
#define RotEnLib_h

class RELEncoder;
typedef void (*ButtonOnReleaseCallback)(RELEncoder&, unsigned long);
typedef void (*ButtonOnLongPressCallback)(RELEncoder&, unsigned long);

class RELEncoder
{
public:
  // Constructor
  RELEncoder(int S1, int S2, int btn, int min, int max, int threshold=15, int thdelta=10);

  // retrieve the current position
  int getPosition();

  // set the current position
  void setPosition(int newpos);

  // retrieve button state
  int getBtnState();

  // set onRelease callback
  void setButtonOnReleaseCB(ButtonOnReleaseCallback);

  // set onLongPress callback
  void setButtonOnLongPressCB(ButtonOnLongPressCallback);

  // update function - call this function often to update the state
  void loop(void);

private:
  int _s1, _s2, _btn, _min, _max, _th, _thd;
  int _position;
  int _s1State, _s1LastState;
  int _btnState, _btnLastState;
  unsigned long _encsavedt, _btnsavedt, _btnpressed;
  bool _btndebouncing;
  ButtonOnReleaseCallback _callbackOnRelease;
  ButtonOnLongPressCallback _callbackOnLongPress;
};

#endif

// end
