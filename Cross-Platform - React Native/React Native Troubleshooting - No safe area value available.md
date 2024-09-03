

Web browser console about no safe area value available:
```
SafeAreaContext.js:79 Uncaught Error: No safe area value available. Make sure you are rendering `<SafeAreaProvider>` at the top of your app.
```

Do this:
```
npm install react-native-safe-area-context
```

Then this:
```
import { SafeAreaProvider, SaveAreaView } from 'react-native-safe-area-context';
```

Then finally this:
```
  return (
    <SafeAreaProvider>
     <SaveAreaView>
      // ...
     </SaveAreaView>
    </SafeAreaProvider>
  );
```