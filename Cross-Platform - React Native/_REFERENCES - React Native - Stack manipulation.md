
Differences between React Navigation’s Stack Navigator and Expo Router:


## React Navigation's Stack Navigator

### Replace screen with ui
This makes it so the previous screen is not in the stack
```
import { useNavigation } from '@react-navigation/native';

function BackButton() {
  const navigation = useNavigation();

  return (
	  <Button title="Go Back" onPress={()=>{ navigation.replace('Home'); }} />;
  )
}
```

### Replace screen programmatically
This makes it so the previous screen is not in the stack. Eg. Login page to profile page. Clicking back you dont want to go back to the login page because user stays logged in
```
import { useNavigation } from '@react-navigation/native';

function Page() {
  const navigation = useNavigation();

  useEffect(()=>{
	  if(loggedInAuth) {
		  navigation.replace('Profile', { owner: 'Michaś' });
	  }
  }, [loggedInAuth])

  {/* ... */}
}
```

### Navigate to screen programmatically
This makes it so the previous screen is not in the stack
```
navigation.navigate('About');
```

Keypoint: Navigate vs Push
When you use navigate, it checks if the target screen is already in the navigation stack. If it is, it will pop all the screens forward of it and bring the existing screen to the top (this behavior depends on whether the stack is configured to allow this). If the screen is not in the stack, it will add the screen to the stack like push. By default, animations do happen, but they can be customized or disabled. push always adds a new instance of the target screen to the stack, even if the screen already exists in the stack. It creates a fresh version of the screen, resulting in multiple instances of the same screen if you push it multiple times.

## Expo Router
https://docs.expo.dev/router/navigating-pages/ (replace, etc)
https://docs.expo.dev/router/advanced/stack/ (dismiss, etc)

### Replace screen with ui
This makes it so the previous screen is not in the stack
```
import { Link } from 'expo-router';

export default function Page() {
  return (
    <View>
      <Link replace href="/feed">Login</Link>
    </View>
  );
}
```


### Replace screen programmatically
This makes it so the previous screen is not in the stack
```
import { router } from 'expo-router';

export function logout() {
  router.replace('/login');
}
```

### Push screen programmatically
This makes it so the previous screen is not in the stack
```
import { router } from 'expo-router';

export function logout() {
  router.push('/login');
}
```

Keypoint: Navigate vs Push
When you use navigate, it checks if the target screen is already in the navigation stack. If it is, it will pop all the screens forward of it and bring the existing screen to the top (this behavior depends on whether the stack is configured to allow this). If the screen is not in the stack, it will add the screen to the stack like push. By default, animations do happen, but they can be customized or disabled. push always adds a new instance of the target screen to the stack, even if the screen already exists in the stack. It creates a fresh version of the screen, resulting in multiple instances of the same screen if you push it multiple times.
### Remove multiple screens
Dismiss how many screens count
```
import { Button, View } from 'react-native';

import { useRouter } from 'expo-router';


export default function Settings() {
  const router = useRouter();

  const handleDismiss = (count: number) => {
    router.dismiss(count)
  };

  return (
    <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
      <Button title="Go to first screen" onPress={() => handleDismiss(3)} />
    </View>
  );
}

```

### Go to first screen of the stack
It's a dismiss all
```
import { Button, View, Text } from 'react-native';

import { useRouter } from 'expo-router';


export default function Settings() {
  const router = useRouter();

  const handleDismissAll = () => {
    router.dismissAll()
  };

  return (
    <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
      <Button title="Go to first screen" onPress={handleDismissAll} />
    </View>
  );
}
```
