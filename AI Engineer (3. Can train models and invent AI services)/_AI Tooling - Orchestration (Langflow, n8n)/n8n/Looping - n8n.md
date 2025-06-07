## Looping Basics

Looping looks like:
![[Pasted image 20250607023407.png]]

When setting up Look Over Items, make sure to connect your `loop` outlet to the node that will run per round, and connect your `done` outlet to the node that will continue the workflow after all rounds are done.

The round running node should outlet back to the `Loop Over Items` node.

---

## Inspecting Loops

The looped content was from Code which loaded in mock data:
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
]  
  
return arr;
```


By entering into the node that runs per round, you can inspect at a round to round level:
![[Pasted image 20250607023619.png]]

Notice that you can select the round:
![[Pasted image 20250607023716.png]]

Zoomed in:
![[Pasted image 20250607023727.png]]

When loop finishes, the node that follows Done outlet will send the entire array into the node that continues the workflow (Notice 3 items get sent to `Do nothing node (All)`):
![[Pasted image 20250607024108.png]]

