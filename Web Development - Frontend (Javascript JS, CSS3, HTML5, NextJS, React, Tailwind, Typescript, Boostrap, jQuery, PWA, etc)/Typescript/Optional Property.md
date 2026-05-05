
Say you have an object whose property (key and value pair) you do not know will be defined or not defined, likely in a situation where you're intaking data:

```
// Define the DNode type with prev and next arrays of DNode or null  
type DNode = {  
    prev: (DNode | null)[];  
    next: (DNode | null)[];  
    data?: {  
      text: string;  
      textLeft: string;  
      textRight: string;  
    };  
  };  
    
  // DNode 1: Head of List 1  
  let dNode1: DNode = {  
    prev: [null],  
    next: [],  
    data: {  
      text: "Node 1 Text",  
      textLeft: "Left Text for Node 1",  
      textRight: "Right Text for Node 1"  
    }  
  };  
    
   
  // DNode 2: Part of List 1 and head of List 2  
  let dNode2: DNode = {  
    prev: [dNode1], // Primary connection to dNode1, part of List 1  
    next: []        // Will be filled with the next nodes (dNode3 and anotherList's node)  
  };  
  
  // Connect nodes for List 1  
  dNode1.next.push(dNode2); // dNode1 -> dNode2
```


Then the optional property of object obj uses the syntax `?:` in place of the double colon:
```
	data?: {
		// ...
	}
```

---

If you do not make the property optional and when running code there are instances of that object that does not have data defined, you'd get the error `Property "data" is missing in type...`