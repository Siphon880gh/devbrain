
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