By defining screens to be in a stack, you can navigate to a previous screen because it kept track of a history of screens. This setups a way for users to conceptualize related screens because they can swipe back on a string of related screens. This conceptualization makes sense when you have multiple screens of related content: for example, having multiple pages to edit the app's settings, the user may want to go back to a previous settings page. And there are multiple visual indicators to enforce this related stack of screens, as well as multiple ways for the user to swipe to a previous screen:

- They can wipe gesture the screen
- They see an animation when going to a previous screen (ie. iPhone has a swipe left to right)
- They can use back button if on a web browser
- Back button at the top header that lets user go back

![](https://i.imgur.com/mBTgJsw.png)

A Stack Navigator allows the developer to define what screens when visited through links, as long as the user visits a screen from an older screen where both screens belong to the same Stack Navigator, can have this swiping animation and user experience.

To see the code in action, you can refer to either:
[[1. Stack Navigator Challenge (React-Navigation)]]

[[React Native Navigation - Stack Navigator (React-Navigation)]]