Why its own note instead of being in Concepts note:
Navigation concepts such like how to go from screen to screen can be done in various ways from Stack Navigator who uses name-based routers, to file-url based routing of Expo-Router (based off of Next.JS of the React Web ecosystem), to traditional url-based routing of React-Router-Native (based off of React-Router-DOM of the React Web ecosystem). It deserves its own note.

---

Being able to navigate for the user is very important unless you’re just making one page apps. And how navigation works can be very complex for the beginner developer.   

After reading this, you should know concept wise: React Navigation (can be enhanced with NativeBase Navigation) vs Wix’s React Native Navigation, React Router Native vs Expo Router.

Also after reading this, you should know the default React-Native navigation components: Stack Navigator, Tab Navigator, Drawer Navigator, Bottom Tab Navigator

You should also know from reading this, the different ways of architecturing multiple screens with react router native (hidden url based) or expo router (file-url)  

In React Native, there are several popular options for navigation, including the ones you've mentioned. Here are the main options:  

1. **React Navigation:**
	- **Stack Navigator:** Allows you to navigate between different screens in a stack, where each screen can be pushed onto the stack and popped off. It’s similar to the way web pages work.
	- **Tab Navigator:** Used for navigation between different tabs, each containing a different stack or set of screens.
	- **Drawer Navigator:** Provides a drawer that slides in from the side of the screen, allowing you to navigate between different screens.
	- **Bottom Tab Navigator:** Similar to Tab Navigator but places the tabs at the bottom of the screen.  

![](https://i.imgur.com/ie28FiP.png)
^ [https://reactnavigation.org/](https://reactnavigation.org/)

2. **React Router Native:**
	- React Router is popular for web navigation, and React Router Native is its counterpart for React Native. It allows you to use a similar API as React Router for native apps, with support for stack navigation and deep linking.
	- Mnemonic: Think React Router's Native library. So it's called React Router Native.

4. **Expo Router:**
	- Built specifically for Expo apps, Expo Router allows for **_file-url routing_** similar to Next.js, making it easy to define routes based on the folder structure of your project.

Vendors from outside the ecosystem
- **React Native Navigation (by Wix):**
	- **Alternative** to React Navigation. This is a more native solution for navigation, providing a highly customizable and performance-oriented option. It includes stack navigation, tabs, drawers, and modals, among other features.

Enhance current libraries:
- **NativeBase Navigation:**
	- This is a UI library that replaces the plain React Native default components as well as the **React Navigation** components to offer a more consistent design system across your app, with support for tabs, stacks, and other common navigation patterns.
	- NativeBase is now: gluestack-ui
	https://nativebase.io/
	https://gluestack.io/
	But `npx create-expo APP --example with-native-base` stills works as of Aug 2028

**How to choose:**

Each of these options has its strengths and can be chosen based on the specific needs of your project. **React Navigation** is the most widely used and provides a comprehensive solution for most apps. 

**React Native Navigation** is often preferred for more performance-intensive apps that need native-like navigation.

**React Router Native** is a good choice if you're familiar with React Router from web development. But if you’re using Expo, **Expo Router** is the most seamless choice and a better developer experience.

**Wix's** **React Router Native** is a good choice if you're familiar with React Router from web development. However it's a vendor that's outside the React Native ecosystem, so there's risk in the future stability when there could be version conflicts.

---

The Mastery Levels folder contains mini-apps that you can build towards mastering the basics of navigation. Also refer to React Native Navigation tutorials, eg. [[React Native Navigation - Stack Navigator (Expo-Router)]], [[React Native Navigation - Expo Router how file-url routing works]], etc.