
When ts complains object is possibly null, you can use Non-Null Assertion Operator `!` to say, I'm asserting that this will not be null!


Example
`document.getElementById('linkedListsContainer').innerHTML += listContent;`
Error:
`Object is possibly "null"`


If you don't want to do Non-Null Assertion, you can do this instead, and that way you can have custom error:
```
const container = document.getElementById('linkedListsContainer');  
if (container) {  
  container.innerHTML += listContent;  
} else {  
  console.error("...")  
}
```