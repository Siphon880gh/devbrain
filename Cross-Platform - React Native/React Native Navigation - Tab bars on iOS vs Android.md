
Android tabs are at the top and you can swipe left and right to switch tabs. The tabs follow the Material UI Design style in how it looks including making it seem like a panel is visually connected to the active tab.  

Removed the icon at each tab component for Android because each tab would be two lines (icon one line, text another line) which doesn’t look too Material UI.

![](0mDgWLX.png)

iOS tabs are at the bottom. User cannot switch tabs by swiping left and right. These tabs look like Apple iOS style tabs. There's a momentary tinting when you press a tab

![](f3S2aQw.png)


Although for the most part React Native takes care of Android style and iOS style automatically. It's not the case for some components and that includes the tab bar.

For Android you require:
```
import { createMaterialTopTabNavigator } from "@react-navigation/material-top-tabs";
const TabBarConfig = createMaterialTopTabNavigator();
```
^ And you could install the package after the Expo React Native app is already created with: `npm install @react-navigation/material-top-tabs`

For iOS you require:
```
import { createBottomTabNavigator } from "@react-navigation/bottom-tabs";
const TabBarConfig = createBottomTabNavigator();
```
^ And you could install the package after the Expo React Native app is already created with: `npm install @react-navigation/bottom-tabs`

```

function TabNavigator() {

  return (
    <TabBarConfig.Navigator
      initialRouteName="TabOne"
      screenOptions={{ tabBarActiveTintColor: "#2f95dc" }}
    >
      <TabBarConfig.Screen
        name="TabOne"
        component={TabOneComponent}
        options={{
          headerShown: false,
          tabBarIcon: ({ color }) => (
            <Ionicons name="code" color={color} size={30} style={{ marginBottom: -3 }} />
          ),
        }}
      />
      <TabBarConfig.Screen
        name="TabTwo"
        component={TabTwoComponent}
        options={{
          headerShown: false,
          tabBarIcon: ({ color }) => (
            <Ionicons name="code" color={color} size={30} style={{ marginBottom: -3 }} />
          ),
        }}
      />
    </TabBarConfig.Navigator>
  );
}
```

You could have separate layout files for android, ios, and web. But if this becomes too messy, you can instead generate the correct tab bar dynamically with:
```
const TabBarConfig = getProperDesignForTabBar();
function getProperDesignForTabBar() {
  switch(Platform.OS) {
    case "android": 
      return createMaterialTopTabNavigator();
      break;
    case "ios": 
      return createBottomTabNavigator();
      break;
    default: // For web, I preferred iOS bottom bar style
      return createBottomTabNavigator();
  }
}

function TabNavigator() {

  return (
    <TabBarConfig.Navigator
      initialRouteName="TabOne"
      screenOptions={{ tabBarActiveTintColor: "#2f95dc" }}
    >
      <TabBarConfig.Screen
        name="TabOne"
        component={TabOneComponent}
        options={{
          headerShown: false,
          tabBarIcon: ({ color }) => (
            <Ionicons name="code" color={color} size={30} style={{ marginBottom: -3 }} />
          ),
        }}
      />
      <TabBarConfig.Screen
        name="TabTwo"
        component={TabTwoComponent}
        options={{
          headerShown: false,
          tabBarIcon: ({ color }) => (
            <Ionicons name="code" color={color} size={30} style={{ marginBottom: -3 }} />
          ),
        }}
      />
    </TabBarConfig.Navigator>
  );
}
```

^ Where the component `<TabNavigator>` is rendered on some parent component. The active tab will automatically be the first screen configured in Tab Navigator.

Don't forget that to check the platform, you need to make the capability possible for your JS:
```
import { Platform } from 'react-native';
```
