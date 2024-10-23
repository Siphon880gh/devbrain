useContext to share state across app

## Engine
context/KeyValue.Provider.useContext.jsx:
```
import React, { createContext, useContext, useState } from 'react';  
  
// Create a context for the key-value object  
// Needed for KeyValueProvider and useKeyValueStore  
const KeyValueContext = createContext();  
  
// Provider component to manage key-value pairs  
export const KeyValueProvider = ({ children }) => {  
  const [keyValueStore, setKeyValueStore] = useState({}); // Initial state is an empty object  
  
  // Function to add or update key-value pairs  
  const addKeyValue = (key, value) => {  
    setKeyValueStore((prev) => ({  
      ...prev, // Spread the previous state  
      [key]: value, // Update or add the new key-value pair  
    }));  
  };  
  
  return (  
    // Provide the key-value store and the function to add key-value pairs to children components  
    <KeyValueContext.Provider value={{ keyValueStore, addKeyValue }}>  
      {children}  
    </KeyValueContext.Provider>  
  );  
};  
  
// Custom hook to easily access the key-value store and the addKeyValue function  
// The custom hook useKeyValueStore is designed to be used inside any descendant component   
// of the KeyValueProvider. This ensures that the component can easily access both the key-value   
// store (keyValueStore) and the function to add/update values (addKeyValue).  
export const useKeyValueStore = () => {  
  return useContext(KeyValueContext); // Can contain addKeyValue and keyValueStore  
};  
  
// Further down the component tree:  
// Any descendant component of the KeyValueProvider can use the useKeyValueStore hook to get either:  
// - key-value store object  
// - adder method.  
//  
// ADD LOGICAL  
// const { addKeyValue } = useKeyValueStore();   
// addKeyValue(keyInput, valueInput);   
//   
// GET ALL LOGICAL  
// const { keyValueStore } = useKeyValueStore();  
// {Object.entries(keyValueStore).map(([key, value]) => (  
//    <Text key={key}>  
//    {key}: {value}  
//  </Text>  
// ))}  
//  
// - or -  
//  
// Log key-value pairs to the console whenever the component renders  
//  useEffect(() => {  
//    console.log("Current key-value pairs:", keyValueStore);  
//  }, [keyValueStore]); // This effect runs every time keyValueStore changes  
//   
// ADD FROM USER INTERACTION  
// <Button title="Increment" onPress={()=> {   
//  setCount(count+1)  
//  addKeyValue("app", {count:count})  
// }}/>  
//   
// SHOW IN JSX  
// <Text>From context: {keyValueStore?.app && keyValueStore?.app?.count && keyValueStor.app.count}</Text>
```

That file exports a provider component and a hook. Wrap all your descendent components in the provider component. Btw, the provider component works because of React's createContext which lets the code create a context that components can provide or read.

## Provider Component

Then any descendant component can import that file’s hook. The hook can give you either the store (object) or adder (function). Use the store to read entries. Use the adder to update the context. This lets you share state across your app without having to drill down props!

App.js:
```
import { KeyValueProvider, useKeyValueStore } from './context/KeyValue.Provider.useContext'; // Your Context Provider and Use Hook  
import { Text, View, Button } from "react-native";  
  
/* Context */  
import React, {useEffect, useState} from 'react'  
  
  
function ImWrappedIn() {  
  let { addKeyValue} = useKeyValueStore();  
  let [a, setA] = useState(0)  
  let [b, setB] = useState(1)  
  let [c, setC] = useState(2)  
  
  // Im wrapped so I have access to the key value store  
  // useEffect(()=>{  
  //   addKeyValue("visitedComponents", {a:0, b:1})  
  // }, [])  
  
  return (  
    <View style={{border:"1px solid black", padding: "10px"}}>  
      <Text>ImWrappedIn and I'll increment with:</Text>  
      <Button title="Increment ABC" onPress={()=> {   
        setA(a+1)  
        setB(b+1)  
        setC(c+1)  
        addKeyValue("visitedComponents", {a,b,c})  
      }}/>  
      <ImWrappedInFurther/>  
    </View>  
  )  
}  
  
function ImWrappedInFurther() {  
  let { keyValueStore } = useKeyValueStore();  
  
  // Im wrapped too so I have access to the key value store  
  useEffect(()=>{  
    console.log({keyValueStore})  
  }, [keyValueStore?.visitedComponents])  
  
  return (  
    <View style={{border:"2px solid gray", padding:"5px"}}>  
      <Text>ImWrappedInFurther and I see:   
        {keyValueStore?.visitedComponents && keyValueStore?.visitedComponents?.a && keyValueStore["visitedComponents"]["a"]}  
        {keyValueStore?.visitedComponents && keyValueStore?.visitedComponents?.a && keyValueStore["visitedComponents"]["b"]}  
        {keyValueStore?.visitedComponents && keyValueStore?.visitedComponents?.a && keyValueStore["visitedComponents"]["c"]}  
      </Text>  
    </View>  
  )  
}  
  
  
export default function App() {  
  
  return (  
    <KeyValueProvider>  
      <ImWrappedIn/>  
    </KeyValueProvider>  
  )  
}
```

You can check the store at anytime in Chrome React Dev Tools. Select the Provider component, then on the right details side panel, expand “hooks”:
![](https://i.imgur.com/0tjOgjn.png)

## Get

```
import { useEffect } from 'react'
import { useKeyValueStore } from '../context/KeyValue.Provider.useContext'

// Warning: alert() works only on React Native Web. Otherwise, use Modal.

export default function Module() {
	const { keyValueStore } = useKeyValueStore();

	useEffect(() => {
		if (keyValueStore?.completedProfile) {
			alert("Congrats! Your profile is completed");
		} else {
			alert("Please complete your profile first");
		}
	}, []);
	
	return (
		<>
			{/* ... */}
		</>
	)
} // Module
```

## Set
```
import { Button } from 'react-native'
import { useKeyValueStore } from '../context/KeyValue.Provider.useContext'

// Warning: alert() works only on React Native Web. Otherwise, use Modal.

export default function Module() {
	const { addKeyValue } = useKeyValueStore();

	function submitProfile() {
		addKeyValue("completedProfile", 1)
	}
	
	return (
		<>
			{/* ... */}
			<Button
              title="Submit Profile"
              onPress={submitProfile}
            />
		</>
	)
} // Module
```
