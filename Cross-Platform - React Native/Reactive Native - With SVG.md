
For 2024, you have to `npm install react-native-svg`. SVG is not natively supported by React Native yet so required that outside installation. To test SVG working, you can follow the below guide to create a svg circle:

Here's a step-by-step tutorial on how to create an SVG circle in a React Native project using `react-native-svg`.

### Step 1: Install `react-native-svg`

First, you'll need to install the `react-native-svg` package, which provides SVG support in React Native.

```bash
npm install react-native-svg
```

### Step 2: Import the Necessary Components

In your React Native component file, import the necessary components from `react-native-svg`.

```javascript
import React from 'react';
import { View } from 'react-native';
import Svg, { Circle } from 'react-native-svg';
```

### Step 3: Create the SVG Circle Component

Now, you can create a simple SVG circle by using the `Svg` and `Circle` components.

```javascript
const SvgCircleExample = () => {
  return (
    <View style={{ alignItems: 'center', justifyContent: 'center', flex: 1 }}>
      <Svg height="100" width="100">
        <Circle
          cx="50"   // x-coordinate of the circle's center
          cy="50"   // y-coordinate of the circle's center
          r="40"    // radius of the circle
          stroke="blue" // stroke color
          strokeWidth="2" // stroke width
          fill="green" // fill color
        />
      </Svg>
    </View>
  );
};

export default SvgCircleExample;
```

### Step 4: Use the Component in Your App

Now, you can use the `SvgCircleExample` component in your app to render the circle.

```javascript
import React from 'react';
import { SafeAreaView } from 'react-native';
import SvgCircleExample from './SvgCircleExample'; // Adjust the import path as needed

const App = () => {
  return (
    <SafeAreaView style={{ flex: 1 }}>
      <SvgCircleExample />
    </SafeAreaView>
  );
};

export default App;
```

### Step 5: Run Your App

Run your app on your emulator or device:

```bash
npx react-native run-android  # For Android
npx react-native run-ios      # For iOS
```

### Explanation of the Code

- **Svg Component**: This acts as the container for your SVG elements.
- **Circle Component**: This creates the circle. It takes several props like `cx`, `cy`, and `r` for positioning and sizing, and `stroke`, `strokeWidth`, and `fill` for styling.

This will render a green circle with a blue outline in the center of the screen. You can adjust the properties like `cx`, `cy`, `r`, `stroke`, `strokeWidth`, and `fill` to customize the appearance of the circle.

Let me know if you need further customization or have any other questions!
