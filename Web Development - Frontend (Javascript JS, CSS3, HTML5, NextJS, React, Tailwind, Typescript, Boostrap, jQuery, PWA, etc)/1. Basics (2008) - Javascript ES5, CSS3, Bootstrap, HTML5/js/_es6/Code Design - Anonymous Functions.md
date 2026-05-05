# Anonymous function parameters
Parameters in the anonymous function could be one to two characters length if the parameter is obvious. This helps reduce redundancy and makes it easier to read.

```
const names = [
    {
        name: "joe",
        id: 0
    },
    {
        name: "jane",
        id: 1
    }
]


const joeObjects = names.filter(o=>o.name="Joe");
const joeObject = joeObjects[0];
```