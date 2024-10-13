
Here we can declare and initialize array of numbers. And we also assign strings to an array right away

```
let el = document.querySelector('main')

let msg: string = 'Hi friend, I have enough money for: ';
el.innerHTML = msg;


let nums: Array<number>;
nums = [1,2,3];


const words:string[] = ["Apple", "Banana", "Mango"]
// or it can infer as:
// const words = ["Apple", "Banana", "Mango"]

el.innerHTML += nums[1]
el.innerHTML += " "
el.innerHTML += words[1]
```

Focusing on:
```
let nums: Array<Number>;
nums = [1,2,3];
```

This syntax also works:
```
let nums: number[];
nums = [1,2,3]
```

Had you assigned a string value, that position will be linted:
![](https://i.imgur.com/LltnFzF.png)
^ This is from the editor playcode.io. For VS Code, it'll be under Problems tab
