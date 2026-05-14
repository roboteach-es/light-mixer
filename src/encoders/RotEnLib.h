// RotEnLib
// --------
// author: mgesteiro
// v1.0 date: 20211205
// v1.1 date: 20260513

#ifndef RotEnLib_h
#define RotEnLib_h

#define BTNDEBOUNCETIME 10
#define ENCDEBOUNCETIME 4
#define LONGPRESSTIME 800

class RELEncoder;
typedef void (*ButtonOnPressCallback)(RELEncoder&, unsigned long);
typedef void (*ButtonOnReleaseCallback)(RELEncoder&, unsigned long);
typedef void (*ButtonOnLongPressCallback)(RELEncoder&, unsigned long);

class RELEncoder
{
public:
	// Constructor
	RELEncoder(int S1, int S2, int btn, int min, int max, int threshold = 15, int thdelta = 10);

	// retrieve the current position
	int getPosition();

	// set the current position
	void setPosition(int newpos);

	// retrieve button state
	int getBtnState();

	// set onPress callback
	void setButtonOnPressCB(ButtonOnPressCallback);

	// set onRelease callback
	void setButtonOnReleaseCB(ButtonOnReleaseCallback);

	// set onLongPress callback
	void setButtonOnLongPressCB(ButtonOnLongPressCallback);

	// update function - call this function often to update the state
	void loop(unsigned long nowt = 0);

private:
	int _s1, _s2, _btn, _min, _max, _th, _thd;
	int _position;
	int _s1State, _s1LastState;
	int _btnState, _btnLastState;
	unsigned long _encsavedt, _btnsavedt, _btnpressed;
	bool _btndebouncing;
	ButtonOnPressCallback _callbackOnPress = __null;
	ButtonOnReleaseCallback _callbackOnRelease = __null;
	ButtonOnLongPressCallback _callbackOnLongPress = __null;
};

#endif

// end
