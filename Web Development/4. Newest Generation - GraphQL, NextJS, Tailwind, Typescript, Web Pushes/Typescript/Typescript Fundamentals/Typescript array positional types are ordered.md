
Array positional types are ordered:

```
type OptionalTuple = [number, string?]
let tuple:OptionalTuple = [1,"1"]
```


This will LINT ERROR:
```
type OptionalTuple = [number, string?]
let tuple:OptionalTuple = ["1",1]
```