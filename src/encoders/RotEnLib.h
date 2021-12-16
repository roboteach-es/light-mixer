// RotEnLib
// -----
// author: mgesteiro
// date: 20211205

#ifndef RotEnLib_h
#define RotEnLib_h

class RELEncoder
{
public:
  // Constructor
  RELEncoder(int S1, int S2, int min, int max, int threshold=15000, int thdelta=10);

  // retrieve the current position
  int getPosition();

  // update function - call this function often to update the state
  void loop(void);

private:
  int _s1, _s2, _min, _max, _th, _thd;
  int _position;
  int _s1State, _s1LastState;
  unsigned long _savedt;
};

#endif

// End
