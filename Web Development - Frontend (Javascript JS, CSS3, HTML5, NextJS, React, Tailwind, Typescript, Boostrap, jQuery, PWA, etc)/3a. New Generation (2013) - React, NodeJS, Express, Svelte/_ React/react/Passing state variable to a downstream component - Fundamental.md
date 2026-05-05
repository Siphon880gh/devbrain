ou can pass a state variable and its setter as props (so it can be both read as well as changed from a downstreamed component)

```
<Component stateVariable={stateVariable} stateVariableSetter={stateVariableSetter}></Component>
```

You can either modify or read the variable at the Component.js implementation with for example, `props.stateVariable`.

Your Component.js could've also destructured props at the receiving parameters like:
```
function Component({stateVariable, stateVariableSetter} {
}
```