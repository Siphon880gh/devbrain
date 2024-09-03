
`Pressable` was introduced in React Native 0.63 as an enhancement over the commonly used `TouchableOpacity`. While both components serve the same basic purpose—making text, images, or other elements clickable and interactive—`Pressable` offers additional, powerful features.

One standout feature of `Pressable` is the `hitSlop` prop, now available as `HitRect`, which provides a more precise way to register touches. According to the documentation:

> "Fingers are not the most precise instruments, and users often miss the target element or activate the wrong one. `Pressable` addresses this with an optional `HitRect` prop, allowing you to define how far a touch can register from the wrapped element. Presses can start anywhere within the defined `HitRect`."

This makes `Pressable` a more accurate alternative to the traditional `hitSlop`, as it allows you to precisely define the touchable area without interfering with the z-index of child or adjacent components.

In essence, `Pressable` combines the functionality of a button or `TouchableOpacity` with enhanced props like `HitRect`. However, note that, as mentioned by others in this thread, `Pressable` does not yet include animations with the `onPress` event. For more details, be sure to check out the official documentation:

[https://reactnative.dev/docs/pressable](https://reactnative.dev/docs/pressable)  

---

The traditionals are:

- TouchableHighlight
- TouchableOpacity
- TouchableWithoutFeedback

TouchableOpacity (fades when clicked) vs TouchableHighlight (highlights darker) vs TouchableWithoutFeedback