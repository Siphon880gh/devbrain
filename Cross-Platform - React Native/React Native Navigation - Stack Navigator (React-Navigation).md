
Am I am the right place: This is installing React-Navigation AFTER an expo react native app has already bee initiated

If starting a blank project, just go ahead and run: `npx create-expo APP --example with-navigation`  which also included react-navigation’s bottom tabs which you may want to remove in the code, but it HAS the Stack Navigator. The instructions for that case is in: [[1. Stack Navigator Challenge (React-Navigation)]]

---


Here's a basic example of how to set up a Stack Navigator using `react-navigation` in a React Native project. I'll also show how to navigate between screens using the `useNavigation` hook.

Rewritten from:
[https://reactnavigation.org/docs/stack-navigator](https://reactnavigation.org/docs/stack-navigator)

## Example using one file

### 1. Install Required Packages

First, make sure you have the necessary packages installed:

```bash
npm install @react-navigation/native @react-navigation/stack
```

Then you install the dependencies of react-navigation. 
- `react-navigation` uses `react-native-screens` to handle screen rendering more efficiently.
- `react-navigation` uses `react-native-safe-area-context` to manage the safe areas around your content, especially when navigating between different screens.
```
npm install react-native-screens react-native-safe-area-context
```


And you would have to enable gestures for swiping the stack:
```
npx expo install react-native-gesture-handler
```

### 2. Set Up the Stack Navigator

Here’s a simple example with two screens, `HomeScreen` and `DetailsScreen`.

```javascript
// App.js
import * as React from 'react';
import { Button, View, Text } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

const Stack = createStackNavigator();

function HomeScreen({ navigation }) {
  return (
    <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
      <Text>Home Screen</Text>
      <Button
        title="Go to Details"
        onPress={() => navigation.navigate('Details')}
      />
    </View>
  );
}

function DetailsScreen() {
  const navigation = useNavigation();

  return (
    <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
      <Text>Details Screen</Text>
      <Button
        title="Go back to Home"
        onPress={() => navigation.navigate('Home')}
      />
    </View>
  );
}

export default function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Home">
        <Stack.Screen name="Home" component={HomeScreen} />
        <Stack.Screen name="Details" component={DetailsScreen} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}
```

^ Make sure Stack Navigator is wrapped in a NavigationContainer.
^ Keypoint: The `<NavigationContainer>` component should wrap **all** of your navigators, not just one. It acts as the root component for your navigation structure, providing the navigation context that all navigators within your app share.
### 3. Explanation

- **HomeScreen**: This screen has a button that navigates to the `DetailsScreen` when pressed using `navigation.navigate('Details')`.

- **DetailsScreen**: This screen uses the `useNavigation` hook to access the navigation object and navigate back to the `HomeScreen`.

---

## Example across multiple files

If you want to use the `useNavigation` hook in other components that are not directly part of the screen components (and `useNavigation` hook will automatically determine which navigation stack or hierarchy it belongs to based on the component's position within the component tree), you can do so like this:

```javascript
import { useNavigation } from '@react-navigation/native';
import { Button } from 'react-native';

function CustomButton() {
  const navigation = useNavigation();

  return (
    <Button
      title="Go to Details"
      onPress={() => navigation.navigate('Details')}
    />
  );
}

export default CustomButton;
```

You can use this `CustomButton` component anywhere within the navigation context, and it will navigate to the `DetailsScreen` when pressed.

### Full Example Including Custom Button

Here’s how you could include this custom button in your HomeScreen:

```javascript
function HomeScreen() {
  return (
    <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
      <Text>Home Screen</Text>
      <CustomButton />
    </View>
  );
}
```

This setup demonstrates a basic stack navigation setup in a React Native app with `react-navigation`, along with the use of the `useNavigation` hook to handle navigation actions programmatically.