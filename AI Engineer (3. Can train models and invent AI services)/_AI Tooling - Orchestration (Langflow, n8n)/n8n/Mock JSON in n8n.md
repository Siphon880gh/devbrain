  
Lets say you're developing a workflow beginning stages. You dont want to actually load JSON from https. You can directly load in the JSON in this manner using the "Code" node

![[Pasted image 20250607023148.png]]

Heck, you can do 98 objects in an array:
![[Pasted image 20250607023204.png]]

Code snippet in example is:
```
const arr = [  
  {  
    a:1  
  },  
  {  
    a:2  
  },  
  {  
    a:3  
  }  
];  
  
return arr;
```


---

We can mock at a deeper level, but note that's considered only outputting 1 item for the next node:
![[Pasted image 20250607024244.png]]

That code snippet is:
```
const wrapper = {
  arr: 
  [
  {
    a:1
  },
  {
    a:2
  },
  {
    a:3
  }
  ]
}

return wrapper;
```