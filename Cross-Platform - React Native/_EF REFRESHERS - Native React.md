
EF REFRESHERS: EASILY FORGOTTEN REFRESHERS

EF are things you easily forget if you haven't done the language/framework in a while. These Easily Forgotten aspects need to be reviewed, especially to avoid wasting time relearning or rediscovering, especially if the errors are not obvious or may mislead you to wasting time.

---

## Reorientation

### Starting new app
Use Expo. For example: `npx create-expo-app@latest --example with-router`

#### Navigation Concepts
- Know the different routing systems at [[_PRIMER - React Native - Concepts on Navigation]]
- We should know that stacking (queueing screens that can be remembered and recalled for popping off, and gesture-swipable with swiping animation) is not required for routes. But while not all routes are stacked screens, all stacked screens are routes (eg. React Navigation's `<StackNavigator>`)
- Know navigate vs push. Look for keypoint at [[_REFERENCE - React Native - Stack manipulation]]
- Stack replace, etc easy to forget because syntax is different between libraries: [[_REFERENCE - React Native - Stack manipulation]]

#### Navigation with Expo
- Run boilerplate code from `npx create-expo APP --example __`. Those examples found at:
  https://github.com/expo/examples
  Those boilerplate code might conflict with your computer. If you get these errors you have to fix the error for each boilerplate you generate: [[React Native zTroubleshooting - Watchman or metro-runtime error]]
- Know the boilerplates for the navigation you want
	- React Router Native is to be avoided. See [[_WARNING - Skip using React Router Native]]
	- Don't confuse Expo Router with React Router Native. See differences in --example boilerplate names:
		- with-react-router ← Installs the react router native, which is NOT a recommended routing system. Use expo router or react navigation instead
		- with-router ← Is expo router that uses url routes which are configured based off the file structure at app/. you can wrap with expo router’s Stack if you want the routes to navigate then stack. Eg.
		  `npx create-expo-app@latest --example with-router`

### Layout Flow
- How you think about the layout and how elements flow on the screen is different between plain html and React versus React Native.
- In plain HTML or React, you have block elements, inline elements, and inline-block elements.
	- Block element starts on a new line and takes up the entire width of the page, but can be assigned different dimensions
	- Inline elements stay on the same line as other inline elements that are immediately before it. It takes up just enough width and height to match the inner content (usually text). Cannot be reassigned different dimensions
	- Inline-block is a hybrid of the two. It can stay inline with other inline elements that are immediately before it. Although it takes up just enough width and height to match the inner content by default, it can be reassigned different dimensions by specifying a width and/or height.
	- They are usually `<div>` versus `<span>`, `<b>`, etc. However there are semantic tags that are interchangeable.
	- Inner content of the elements start from the left.
- However, in React Native, you have block elements and inline elements.
	- They are usually `<View>` versus `<Text>`, `<TouchableOpacity>`, etc
	- However unlike `<div>`, the `<View>` is actually a flexbox where you can flexibly declare where elements start, how they're distributed on the horizontal or vertical axes, whether they wrap, etc using the flexbox property rules. This could cause "inlines" that are flex children to take up the entire width of the flexbox or apparently the screen, depending on your flex declarations.

### Tailwind in React Native
- For tailwind you have a few choices. Many tailwind libraries will have you call functions inside the style attribute, but Nativewind will allow you to use classNames as if this were a regular React app or plain HTML webpage. Nativewind has been conflicting in Aug 2028 and needed some workarounds
	- Fixing it not allowing more than one class. You need to add the setOutput block (`/* Fixes web */`), otherwise on the web export or preview, you will not see tailwind styles applied unless you use one class to apply it.
		```
		import { View, Text } from 'react-native';  
		import { NativeWindStyleSheet } from "nativewind";  {/* Fixes web */}
		  
		{/* Fixes web */}
		NativeWindStyleSheet.setOutput({  
		  default: "native",  
		});  
		  
		export default function App() {  
		  return (  
		    <View className="flex-1 items-center justify-center">  
		      <Text>Universal React with Expo1</Text>  
		    </View>  
		  );  
		}
		```
	- In addition, you may need to lock tailwind to 3.3.2. Your package.json: `"tailwindcss": "3.3.2"`

## Inline styling in React Native
- You can write styles inline at the style attribute, and just like React, it receives only javascript objects/arrays, with property names in camelCase format. 

## Stylesheet section in React Native
- In React, you can import css files directly if your web bundler is setup correctly, then your styling classes can be used in the components. 
- In React-Native, you cannot use css files - you must code the styling in Javascript. You can have objects initialized by the Stylesheet module from "React-Native" and when initializing you declare your styles in javascript and it looks like a css stylesheet.
```
import React from 'react';
import { StyleSheet, Text, View } from 'react-native';

const App = () => {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Hello, React Native!</Text>
      <Text style={styles.subtitle}>This is a simple example of using StyleSheet.</Text>
      <Text style={[styles.title, styles.subtitle]}>This line combines multiple styles.</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
  },
  subtitle: {
    fontSize: 16,
    color: '#666',
  },
});

export default App;
```

- And you can modularize the stylesheet into a Page.js and Page.style.js:
  Page.style.js:

Page.js:
```
import React from 'react';
import { Text, View } from 'react-native';
import styles from './Page.style.js'

const App = () => {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Hello, React Native!</Text>
      <Text style={styles.subtitle}>This is a simple example of using StyleSheet.</Text>
      <Text style={[styles.title, styles.subtitle]}>This line combines multiple styles.</Text>
    </View>
  );
};

export default App;
```

Page.style.js:
```
import { StyleSheet } from 'react-native';

export default styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
  },
  subtitle: {
    fontSize: 16,
    color: '#666',
  },
});
```


---

## Reorientate to Inconsistencies

React Native has some inconsistencies to be remembered. Otherwise you keep trying to rewrite your code thinking it's you:
- There are some components that don't support onPress like you expect it to
- Some components don't support styling
- Some components support styling but it's under a different attribute than "style".
- Inconsistency between React Native and React
- Inconsistency between a React Native package and a similar package in React or plain html website

### React Native styling pixels
- Use a string of percent like "100%"
- Or use whole numbers (not px, rem, etc):
```
import React from 'react';
import { StyleSheet, Text, View } from 'react-native';

const App = () => {
  return (
    <View style={[styles.container,{marginTop:12}]}>
      <Text style={styles.title}>Hello, React Native!</Text>
      <Text style={styles.subtitle}>This is more text.</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#f5f5f5',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
  },
  subtitle: {
    fontSize: 16,
    color: '#666',
  },
});

export default App;

```

### React Native click handler
- Unlike React, in React Native it's `onPress` and `onLongPress`

### Tailwind (by the way of Native Wind)
- Does not support gap (for flex)

## Images
- In plain HTML websites and React, setting both `height` and `width` on an `<Image>` component could cause distortion or looks fine, but never does that clip an image.
- However, in React Native, setting both `height` and `width` on an `<Image>` component can clip the image. You have to maintain the aspect ratio with the `resizeMode` attribute which can have values like `contain`, `cover`, or `center`.

### Image Background
- In plain HTML, you can have a div have a background image by using css property `background-image` or the shortcut `background`
- However, in React Native you must use the `<ImageBackground>` component:
```
import React from 'react';
import { ImageBackground, StyleSheet, Text, View } from 'react-native';

const App = () => {
  return (
    <ImageBackground 
      source={{ uri: 'https://example.com/your-image.jpg' }} 
      style={styles.background}
    >
      <View style={styles.content}>
        <Text style={styles.text}>This is your content!</Text>
      </View>
    </ImageBackground>
  );
};

const styles = StyleSheet.create({
  background: {
    flex: 1,
    resizeMode: 'cover', // or 'stretch' or 'contain' depending on the image size
    justifyContent: 'center',
  },
  content: {
    // Your content styles
  },
  text: {
    color: 'white',
    fontSize: 20,
  },
});

export default App;
```

### Image Background

### Components that do NOT support onPress
- `<View>` does not support onPress
### Components that do NOT support styling (style attribute)
- Sole `<TouchableWithoutFeedback>` does NOT have styling
	- Its siblings like `<TouchableOpacity>` DO support styling. 
	- This may have been an oversight by the React Native developers. 
	- Btw, the related `<Pressable>` also supports styling.
- `<Button>` does NOT have styling.