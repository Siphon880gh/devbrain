Make sure event is in your click handler function or you wont have access to event.target:
```
function clickHandler(event) {
	// your code with event.target or event.currentTarget or event.type
}
```

This goes without saying the same for event.type, event.key, etc