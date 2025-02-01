
Say you want some space between two buttons:
![](llIszjS.png)

Use this component:
```
const VertSpace = () => {  
  return (<View style={{height:"20px", width:"1px"}}><Text></Text></View>)  
}
```

---

## DON'T:

You might think it's less wordy to use this which skips the blank Text component:
```
const VertSpace = () => {  
  return (<View style={{height:"20px", width:"1px"}}></View>)  
}
```

Although that works fine on iOS, on Android it will ignore your vertical space:
![](dM0NpEQ.png)
