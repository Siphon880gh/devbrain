
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
