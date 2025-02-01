
**Segue in Xcode:**

- A segue in Xcode is a concept used in iOS development, specifically in the Interface Builder and storyboards.
- It represents a transition between two view controllers in an app's user interface.
- Developers use segues to define the flow of their application and handle the preparation and passing of data between view controllers.
- When a segue is triggered, typically through user interaction or programmatically, it initiates the transition from one view controller to another, optionally carrying data or settings to the destination view controller.

Have control (ie button) open next screen. 
- Basically you stay in the WYSIWYG Storyboard UI and create "segues" between button to screen
- To create a segue between view controllers in the same storyboard file, Control-click an appropriate element in the first view controller and drag to the target view controller. The starting point of a segue must be a view or object with a defined action, such as a control, bar button item, or gesture recognizer. You can also create segues from cell-based views such as tables and collection views.
https://developer.apple.com/library/archive/featuredarticles/ViewControllerPGforiPhoneOS/UsingSegues.html


Another way to have onclick button to another screen that's easier is doing it in the Storyboards themselves, called segues:

Creating a segues between a button to the next view controller:

![](WEbW2DI.png)


![](sCPYH6T.png)
