
Passing data with InstantiateViewController / Pass data from screen to screen

  
Approach 1:  
Start reading at [there is a lot of method to do this but you can use UserDefaults] from  
[https://stackoverflow.com/questions/70373999/swift-how-can-i-pass-the-calculation-result-to-another-screen](https://stackoverflow.com/questions/70373999/swift-how-can-i-pass-the-calculation-result-to-another-screen)  
  
Approach 2:  
Remember all variables including classes from any file is accessible anywhere in the app, so you can have a global variable at some helper file to contain your values, and it gets reassigned value or read it's value as needed

---

A common practice in iOS development is passing data between view controllers. Storyboards can help you move data from one view controller to the next, by using segues. Because this moving of data is supported by a framework, like storyboards, you don’t have to design the flow of data from scratch. And that’s more productive.


Mandatory more: (Scene, Segue, Root controller)

[https://www.appypie.com/view-controller-uiviewcontroller-ios-swift](https://www.appypie.com/view-controller-uiviewcontroller-ios-swift)

---

Passing data between view controllers:
[https://fluffy.es/3-ways-to-pass-data-between-view-controllers/](https://fluffy.es/3-ways-to-pass-data-between-view-controllers/)