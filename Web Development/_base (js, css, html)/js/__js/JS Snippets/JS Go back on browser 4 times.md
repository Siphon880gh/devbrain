You repeat the `window.history.back()` as many times as needed to go back X times

```javascript
function goBackMultipleTimes(steps) {
  for (let i = 0; i < steps; i++) {
    window.history.back();
  }
}

// Usage:
goBackMultipleTimes(4); // This will go back in the history 4 times
```

^This `goBackMultipleTimes` function accepts the number of steps as an argument and goes back in the browser history accordingly.

As of my last knowledge update in January 2022, the `window.history` object in JavaScript does not provide a built-in method to go back a specific number of steps in the browser history. 