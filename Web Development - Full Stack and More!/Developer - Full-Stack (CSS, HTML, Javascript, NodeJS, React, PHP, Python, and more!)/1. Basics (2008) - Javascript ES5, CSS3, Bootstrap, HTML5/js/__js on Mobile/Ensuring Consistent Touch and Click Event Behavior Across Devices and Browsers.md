Touchend automatically triggers click event unless there was a touch event like a swipe gesture. Otherwise, click is suppressed after touchend. So your click handler is fine on touch screens (phones, tablets, etc). 

However, older devices or browsers did not have that figured out. So if you have click event handler and swipe etc handler on the same screen, for max compatibility, you ought to suppress the click at touchend:

- Legacy Browser Behavior:
	- Older browsers or frameworks may still exhibit quirks where the `click` event isn't reliably suppressed after certain touch interactions.
- Consistency Across Devices:
	- Some devices or browsers (especially older Android versions) don't suppress `click` properly after touch interactions. By explicitly suppressing the `click` in your code, you can ensure consistent behavior.

```
element.addEventListener('touchend', (event) => {
    event.preventDefault(); // Prevent the click from firing
    console.log('Touchend handled');
});

element.addEventListener('click', () => {
    console.log('Click handled');
});
```