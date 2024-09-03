By Weng

## Concepts

### WHY REACT NATIVE

Learn Once, Code Anywhere
![](https://i.imgur.com/TQXKTRv.png)

![](https://i.imgur.com/z4Lu8sH.png)

Companies using it: Facebook, Insta, AirBnB, Burger King, Coinbase, Xbox

Open source community packages for a lot of things, especially common situational: `npm install react-native-webview`


### Why Expo

Expo to start, manage, and deploy

There's React-Native (the cli is `react-native` or `npx react-native`). That's largely been superseded by installing expo to manage react-native. You install expo and it'll install react-native.

---

## Compared to React


Differences to Create React App / Vite

- In React Native with Expo, you don't have to rebuild the entire app. No need to run build for certain changes. However, you may need to close the process and re-run `npx expo start`

Similarities to React

- Same language of React
- Many of the same state management techniques, eg. useState, and other hooks like useEffect. And can have components in the same file.
- Expo is the “vite/cra” that makes it easy to package and deploy. It also packages the native dependencies
- Hotreload

Difference to React  

- React Native requires you to use their device-fluid components (Button, View, etc)
- React Native’s router is file-url like Next
- CSS is done through creating styles.createStylesheet, then the keys are the objects you pass into in-line style attributes. This is so your IDE can hint and autocomplete. See next section on styling in react native.

---

## Styling in React Native

How to style:
```
import React from 'react'  
import {Stylesheet, View} from 'react-native'  
  
const App = () => {  
 return <View style={styles.customStypeProp} />  
}  
  
const styles = Stylesheet.create({  
 customStyleProp: {  
  flex: 1,  
  justifyContent: "center",  
  alignItems: "center",  
  backgroundColor: "red"  
 }  
});  
  
export default App
```


And style attribute can take multiple style objects:
```
style={[styles.button, styles.buttonClose]}
```

- Hotreload done through syncing your app by opening a **QR code**

  
---

### **Quirkinesses


#### Quirkiness - Inspired by HTML but not based entirely off HTML

View is based off div and with flex. Except unlike default flex, React Native flex by default has direction set to column. React Native View does not have gap property for flex

In terms of user interaction, View cannot support onPress etc. Touchable type components and Pressible components can.

#### Quirkiness - Dependencies


Some require expo installation so it can be linked to expo which takes care of the packages
```
npx expo install react-native-gesture-handler react-native-reanimated
```

Some do not require expo linking:
```
npm install react-native-elements
```


#### Quirkiness - Platforms

iOS and Android does not support `alert`. They use `Alert.aert`


----

### **Fundamentals - Layout**

Keypoint: Layouts in React Native is simplified so it can be universal with multiple devices. For example, Text is a replacement for all possible span and p. Layouts are mainly based off flex mechanics. For example, View is like div but it’s flex column and cannot support user interaction event listeners like div’s in HTML can. TouchableOpacity works like an inline div that has fade animation on its children when clicked.

Keypoint: There is the safe view area concept in React Native as well similar to iOS development.

#### Device-fluid components

List is:

- Flatlist: Large list with smooth scrolling
- Scrollview: Container that you can scroll inside
- Map: Go for small list


### Fundamental - Building block components

#### View (Kinda like HTML div but with nuances)
- View: Similar to a div container
- But there is a lot of nuances that you need to understand if you plan to translate web-based layout concepts to React Native or come from the web development world.
	- It is a flex column. Direction by default is column because of mobile first thinking  
	- It DOES NOT support onPress and the like, unlike div’s in HTML
	- Annoyingly it doesn’t support some div flex properties like gap. For that, you’d have to apply margins to the children to imitate it.
	- View does not fill up the width of the screen like div does. To do that you have to...
		- In web development, a `div` element naturally expands to fit its content and can grow as needed. It also defaults to a block-level element, taking up the full width of its container.
		- In React Native, a `View` does not automatically take up available space. It only takes up as much space as its content unless explicitly told to do otherwise using properties like `flex`.
		- React Native uses Flexbox as its default layout system. If you want a `View` to fill its parent container, you must explicitly set `flex: 1`. This tells the `View` to grow and take up all available space within its parent.
	- View does not scroll when the content overflows! To do that, you use `<ScrollView>` instead of View.

```
import React from 'react'  
import {View, Text} from 'react-native'  
  
const App = () => {  
 return (  
  <View>  
   <Text>Hello World!</Text>  
  </View>  
 )  
}
```

#### Text
- Text replaces all span and p equivalent. We have to simplify layout elements to be more universal with multiple devices
  
```
<Text style={{ fontSize: 24, color: 'blue' }}> Hello World!</Text>
```

### Fundamental - UI components and Interactions

#### TouchableOpacity

- TouchableOpacity: Add interactivity to buttons, links, and other components

- The naming: When the user taps on the `TouchableOpacity`, the opacity of the wrapped content decreases, giving a visual indication that the touch was recognized. Name sake, think it’s an area of opacity that can be touched to see an effect on mobile/iPad touch screen.
- If you have an icon and label that are in the same visual grouping and they should have a fade effect when either is clicked, you wrap them around a TouchableOpacity

#### Touchable vs Pressible

Pressible is the newer touchable type components. It supports a radius around for which allows mobile users' thumbs to be less accurate. Touchables including highlight, opacity, and without interaction are still available.

#### onPress, onLongPress

Here’s to defining a custom button as part of some library of components or on the same file. You can set the onPress on the custom button  

```
import React from 'react';  
import { TouchableOpacity, Text } from 'react-native';  
  
const MyButton = () => {  
  return (  
    <TouchableOpacity onPress={() => alert('Button pressed!')}>  
      <Text>Press Me</Text>  
    </TouchableOpacity>  
  );  
};  
  
export default MyButton;  
```
  

You can set the onPress on the custom button:  

```
<MyButton onPress={ ()=>{alert('hi!'); }></MyButton>
```

  
Note: Test the above on web. iOS and Android does not support `alert`. They use `Alert.aert`

Challenges for you:

- Customize the MyButton so you pass in the text of the button!
- Customize the MyButton so you can pass in which color style object to use
- Change into long press instead of single press


#### Button, Switches, etc

- Button
- Switch
- Checkbox

```
<Switch
  trackColor={{ false: '#767577', true: '#81b0ff' }}
  thumbColor={isEnabled ? '#f5dd4b' : '#f4f3f4'}
  onValueChange={toggleSwitch}
  value={isEnabled}
/>
```

### Fundamental - Safety guidelines

- SafeAreaView: Safe zone without hardware notch etc covering

---

### Fundamental - Navigation

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
	- This is a UI library that **_integrates with React Navigation_** to offer a more consistent design system across your app, with support for tabs, stacks, and other common navigation patterns.

**How to choose:**

Each of these options has its strengths and can be chosen based on the specific needs of your project. **React Navigation** is the most widely used and provides a comprehensive solution for most apps. 

**React Native Navigation** is often preferred for more performance-intensive apps that need native-like navigation.

**React Router Native** is a good choice if you're familiar with React Router from web development. But if you’re using Expo, **Expo Router** is the most seamless choice and a better developer experience.

**Wix's** **React Router Native** is a good choice if you're familiar with React Router from web development. However it's a vendor that's outside the React Native ecosystem, so there's risk in the future stability when there could be version conflicts.

---

### **Fundamentals - Peri**

#### **Console logging**

Console logging:
```
useEffect(()=>{  
 console.log('Navigation 123')  
}, []);
```


Show logs for phones
```
react-native log-ios  
react-native log-android
```

For Desktop web, you just open the console because “console.log”

#### Device integration

- Camera
- Notifications
- GPS location
- Gestures



##### Common Situations

- Different layouts: No support for media queries, BUT: Can check platform and apply different JSX using the platform import
```
import React from 'react'
import { Platform, View } from 'react-native'

const App = () => {
  return (
    <View style={{ flex: 1 }}>
      {Platform.OS === 'ios' && (
        <View style={{
          flex: 1,
          backgroundColor: 'lightblue'
        }} />
      )}

      {Platform.OS === 'android' && (
        <View style={{
          flex: 1,
          backgroundColor: 'lightgreen'
        }} />
      )}
    </View>
  )
}

export default App

```


---

### Best Practices:

  
- Search and Pagination
- Custom hooks to fetch API data
- SafeAreaView from library (Can’t rely on the default!)  
	- Use `npm install react-native-safe-area-context`
- ActivityIndicator: Show a spinner or loading indicator
- LazyLoading: Don't load all the assets on the screen at the same time. Load as the user is scrolling (Good UX because it's an equal exchange of user effort and then payoff)


#### SafeAreaView from library (Can’t rely on the default!)  
Proof. Left is SaveAreaView imported from React-Native. Right is from the new library:
![](https://i.imgur.com/BMkHCgb.png)

How to implement:
```
import React from 'react';
import { SafeAreaProvider, SafeAreaView } from 'react-native-safe-area-context';
import { View, Text, StyleSheet } from 'react-native';

const App = () => {
  return (
    <SafeAreaProvider>
      <SafeAreaView style={styles.safeArea}>
        <View style={styles.container}>
          <Text style={styles.text}>Hello, Safe Area!</Text>
        </View>
      </SafeAreaView>
    </SafeAreaProvider>
  );
};

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#f8f8f8', // You can customize the background color of the SafeAreaView
  },
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
  },
  text: {
    fontSize: 18,
    color: '#333',
  },
});

export default App;
```

NOT:
```
import { SafeAreaView } from 'react-native';
```



#### ActivityIndicator: 
Show a spinner or loading indicator

![](https://i.imgur.com/WrcWUyO.png)

```
<ActivityIndicator size="large" color="#0000ff"/>
```

#### LazyLoading
Don't load all the assets on the screen at the same time. Load as the user is scrolling (Good UX because it's an equal exchange of user effort and then payoff)

**How It Works:**

- **`React.lazy(() => import('./LazyComponent'))`:** This tells React to lazy load the `LazyComponent`. The component will only be loaded when it is rendered for the first time.
- **`Suspense`:** This component is used to wrap the lazy-loaded component and provides a fallback UI (like a loading spinner or text) that is shown while the lazy-loaded component is being fetched.

```
import React, { Suspense } from 'react';  
import { View, Text } from 'react-native';  
  
// Lazy load a component  
const LazyComponent = React.lazy(() => import('./LazyComponent'));  
  
const MyComponent = () => {  
  return (  
    <View>  
      <Text>This is my main component.</Text>  
        
      {/* Wrap the lazy-loaded component in Suspense */}  
      <Suspense fallback={<Text>Loading...</Text>}>  
        <LazyComponent />  
      </Suspense>  
    </View>  
  );  
};  
  
export default MyComponent;
```