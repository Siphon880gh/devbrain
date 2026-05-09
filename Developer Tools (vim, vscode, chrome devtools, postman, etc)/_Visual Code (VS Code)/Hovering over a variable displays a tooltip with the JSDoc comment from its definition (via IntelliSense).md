Titled: Hovering over a variable displays a tooltip with the JSDoc comment from its definition (via IntelliSense)

![[Pasted image 20250526074744.png]]

app.js:
```
import defs from './defs';  
  
console.log(defs); // <-- Hover your mouse over this line to see the Intellisense Hover Tooltip  
console.log("This is to test Intellisense Hover Tooltips. Open VS Code and hover your mouse over the line above.");
```

defs.js:
```
/** Array of word definitions with detailed information */  
const defs = [  
    {  
        word: "cat",  
        definition: "A small domesticated carnivorous mammal with soft fur, a short snout, and retractile claws. It is widely kept as a pet or for catching mice, and many breeds have been developed.",  
        example: "The cat sat on the mat.",  
        synonyms: ["feline", "kitty", "pussycat"],  
        antonyms: ["dog", "doggy", "doggy-dog"],  
        relatedWords: ["catnip", "cat food", "cat toy"],  
        usage: "The cat is a domesticated mammal that is often kept as a pet.",  
        etymology: "The word 'cat' comes from the Latin word 'felis', which means 'cat'.",  
    }  
]  
  
export default defs;
```

What also works:
```
/**   
 * Array of word definitions with detailed information   
 */
```

What doesn't work:
- So you MUST start with `/**` 
```
/* Array of word definitions with detailed information */
```
