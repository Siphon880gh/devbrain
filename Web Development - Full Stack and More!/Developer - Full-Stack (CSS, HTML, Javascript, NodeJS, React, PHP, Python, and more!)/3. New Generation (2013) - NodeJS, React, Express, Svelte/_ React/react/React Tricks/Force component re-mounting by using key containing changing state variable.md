Titled: Force component re-mounting by using key containing changing state variable

When key is changed, React unmounts and re-mounts the component instead of updating it. This is useful when you need to reset a component’s state or trigger a re-fetch whenever a variable changes
```
<Component key={someValueThatLterChanges} />
```

Rendering map/forEach also uses the attribute key. React **uses `key` to track items** in a list and optimize rendering. If `key` is missing or changes incorrectly, React may re-render elements inefficiently.