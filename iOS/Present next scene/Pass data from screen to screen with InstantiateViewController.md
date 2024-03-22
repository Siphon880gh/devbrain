
Passing data with InstantiateViewController / Pass data from screen to screen

  
Approach 1:  
Start reading at [there is a lot of method to do this but you can use UserDefaults] from  
[https://stackoverflow.com/questions/70373999/swift-how-can-i-pass-the-calculation-result-to-another-screen](https://stackoverflow.com/questions/70373999/swift-how-can-i-pass-the-calculation-result-to-another-screen)  
  
Approach 2:  
Remember all variables including classes from any file is accessible anywhere in the app, so you can have a global variable at some helper file to contain your values, and it gets reassigned value or read it's value as needed