
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
