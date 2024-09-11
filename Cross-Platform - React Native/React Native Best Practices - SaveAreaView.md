
https://docs.expo.dev/versions/latest/sdk/safe-area-context/

Common need - may as well do this to all App.js level code:
```
npm install react-native-safe-area-context
```

Your code could be:
```
import { SafeAreaProvider, SaveAreaView } from 'react-native-safe-area-context';  
  
// ...  
  
const App = () => {  
  return (  
    <SafeAreaProvider>  
     <SaveAreaView>  
      <MyComponent />  
     </SaveAreaView>  
    </SafeAreaProvider>  
  );  
};
```

Although there is a SaveAreaView in 'react-native', it is considered inferior to the one from 'react-native-safe-area-context', at least in August 2024. 

If curious to see a side-by-side comparison, refer to [[_PRIMER - React Native - Concepts]]'s section "Best Practices"