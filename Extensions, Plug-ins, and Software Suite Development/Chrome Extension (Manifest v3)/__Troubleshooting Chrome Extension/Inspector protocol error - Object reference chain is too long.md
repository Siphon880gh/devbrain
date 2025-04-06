If not an object you’re console logging is too long or one that you’re stringifying is too long

And you’re evaluating against inspectedWindow. This error can happen with:
```
chrome.devtools.inspectedWindow.eval("", (result, isException) => {
```
or
```
chrome.devtools.inspectedWindow.eval("$0", (result, isException) => {
```

This is a not so obvious error.