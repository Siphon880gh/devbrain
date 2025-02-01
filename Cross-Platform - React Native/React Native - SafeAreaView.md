## Method 1 (Probably Obsoleted)

#### SafeAreaView from library (Can’t rely on the default!)  
Proof. Left is SaveAreaView imported from React-Native. Right is from the new library:
![](BMkHCgb.png)

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


---

## Method 2

At App.js wrap all further descendants with `<SafeAreaProvider>`
```
import { SafeAreaProvider } from "react-native-safe-area-context";

export default function App() {
	return (
		<SafeAreaProvider>
			{/* The rest of your app */}
		</SafeAreaProvider>
	)
}
```

At individual components that show on the screen, you calculate insets:
```
import { useSafeAreaInsets } from "react-native-safe-area-context";

export default function PolyNavigator() {
    const insets = useSafeAreaInsets()

    return (
        <Poly.Navigator 
            initialRouteName="Assessment"
            screenOptions={headerOptions} 
            style={{marginTop:insets.top * 2}}
        >
            <Poly.Screen name="Assessment" component={TabNavigator} />
            <Poly.Screen name="About" component={TabAboutScreen} />
        </Poly.Navigator>
    );
}
```

Quirks:
PolyNavigator could've been a StackNavigator or a DrawerNavigator <- Do not surround it with View because that will take the navigator ui out of view on android and shifts it up on iOS.