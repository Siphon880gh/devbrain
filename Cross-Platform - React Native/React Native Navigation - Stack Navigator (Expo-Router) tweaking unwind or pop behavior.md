
Make sure you're at the right tutorial: This is for the `<Stack>` that belongs to Expo-Router. It's an enhanced version of Stack than React-Navigation's `<Stack>`


Correct:
```
import { Stack } from 'expo-router';
```

---


Automatically stack navigator when you navigate to different routes. It pops off screens to unwind (aka popping) to a screen if exists in the current history stack. Otherwise pushed it to the stack. You can use replace or push to prevent this, and push will push the screen onto the stack even if the screen existed somewhere in the stack

```
<Link push href="/feed">Login</Link>
```

```
<Link replace href="/feed">Login</Link>
```


If navigation is programmatically driven instead of user interaction driven
```
import { router } from 'expo-router';  
  
export function logout() {  
  router.replace('/login');  
}
```
^You can also use `router.push`, etc

