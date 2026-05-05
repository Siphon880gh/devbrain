
Here are new ES syntax that makes code readable

# Play with variables

## Destructuring array vs object
```
let [name, age, gender] = ["John Doe", 33, "Male"];
let {name, age, gender} = {
    name: "John Doe", 
    age: 33, 
    gender: "Male"
};
```

Passing arguments in an object to a function, destructuring them into variables, renaming variable, and having default values (if not passed as a variable)
```
initCanvas(settings) {
            let { querySelected : element, width, height, lineWidth = 2, color = "#222222", reset = true } = settings;
}
initCanvas({
    querySelected: document.querySelector("#signature-pad"),
    width: $(document).width(),
    height: $(document).height()
});
```

## Const: Value cannot be reassigned (except for array / object)
```
const num = 1;
```

Let: Variable cannot be re-declared in the same scope and does not override outside scope
```
let loaded = true;
let staySix = 6;
if(true) {
    let staySix = 7;
}
console.log( staySix === 6 ); // is true
```

Var: Can be re-declared in the same scope and does override outside scope
```
var increaseNum = 6;
if(true) {
    var increaseNum = 7;
}
console.log( increaseNum > 6 ); // is true
```

## Object same key:value
If assigning an object key to a variable with the same name, you don't have to type redundantly anymore
```
let animal = "cat",
let vocal = "meow";

let actionableAnimal = {
    animal,
    vocal
}
```

# Shorten lines of code

Ternary operation aka short circuiting because if-else may be too long to read
```
let themeColor = wantDarkMode ? "black":"white"
let canDrive = age>16 ? true:false;
```

Array methods read better than for-loops
```
arr.forEach
arr.map
arr.filter
arr.reduce
```