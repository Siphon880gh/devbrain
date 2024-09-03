
Make sure you're at the right tutorial: This is for the `<Stack>` that belongs to Expo-Router. It's an enhanced version of Stack than React-Navigation's `<Stack>`


Correct:
```
import { Stack } from 'expo-router';
```

---


Automatically when you navigate to different route-screen pairs defined in the stack navigator, your app keeps a history of them. When the user gestures with a swipe, the phone shows an animation getting rid of the current screen to unwind (aka pop off) to the previous screen. The user may keep repeating this swipe gesture until they return to the first route-screen they ever navigated to that's in the current stack navigator.

When you navigate with Link, if that screen exists in the current history stack, the phone returns to that screen, and the history stack forgets all the screens after that existing screen, relieving its memory. This may not be the history swiping experience you want for your users. In that case, use `push` to be explicit so that the memory saving default is not used: push will push the screen onto the stack even if the screen existed somewhere in the stack

In some cases you may want the current screen to not exist in the history swiping experience, instead replaced by the screen the user just navigated to. That forgotten screen could be a warning screen about the next page. You can use replace to replace the top of the stack with the next screen. 

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

