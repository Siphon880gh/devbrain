
When ts complains object is possibly null, you can use Non-Null Assertion Operator `!` to say, I'm asserting that this will not be null!


Example error
`document.getElementById('linkedListsContainer').innerHTML += listContent;`
Error:
`Object is possibly "null"`


Non-Null Assertion (Hey javascript engine, Im asserting this will never be null. I'm confident and you can trust me!!)
```
function printLength(text: string | null) {
  console.log(text!.length); // Using '!' asserts that 'text' is not null.
}

printLength("Hello, world!");
```


If you don't want to do Non-Null Assertion, you can do this instead, and that way you can have custom error:
```
const container = document.getElementById('linkedListsContainer');  
if (container) {  
  container.innerHTML += listContent;  
} else {  
  console.error("...")  
}
```