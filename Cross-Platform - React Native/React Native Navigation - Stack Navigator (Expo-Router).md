
Obligatorily refer to: https://docs.expo.dev/router/advanced/stack/

---

Briefly:


You can create a stack navigator using file-based routing. Below is an example of a file structure:

```
app
  ├── _layout.tsx
  ├── index.tsx
  └── details.tsx
```

This structure sets up a layout where the `index` route is the initial route in the stack, and the `details` route is added on top when navigated to.

To define the stack navigator with these routes, use the `app/_layout.tsx` file:

```javascript
import { Stack } from 'expo-router/stack';

export default function Layout() {
  return <Stack />;
}
```

To navigate from the index.tsx screen to the details.tsx screen, here's the index.tsx:
```
import React from 'react';
import { Button, View, Text } from 'react-native';
import { useRouter } from 'expo-router';

export default function Index() {
  const router = useRouter();

  return (
    <View>
      <Text>Welcome to the Index Page</Text>
      <Button
        title="Go to Details"
        onPress={() => router.push('/details')}
      />
    </View>
  );
}

```