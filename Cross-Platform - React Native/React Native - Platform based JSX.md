**You can use Platform API to detect OS:**
```
import React from 'react'
import { Platform, View } from 'react-native'

const App = () => {
  return (
    <View style={{ flex: 1 }}>
      {Platform.OS === 'ios' && (
        <View style={{
          flex: 1,
          backgroundColor: 'lightblue'
        }} />
      )}

      {Platform.OS === 'android' && (
        <View style={{
          flex: 1,
          backgroundColor: 'lightgreen'
        }} />
      )}
    </View>
  )
}

export default App

```

**And it can be filename based:**

***Case 1***
```
something.android.jsx
something.ios.jsx
something.web.jsx

```

***Case 2***
```
something.android.jsx
something.jsx
```

^ "something.jsx" refers to everything else besides android -- ios and web. As long as those specific files do exist, they get matched first, then the non-specific file gets applied to universally all other platforms.