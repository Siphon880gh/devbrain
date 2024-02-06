Less buggy because all your variable types are typed and not allowed to be ambiguous (type safety) unless you specifically mean for any type. Typescript also looks out for a lot of gotchas that make buggy apps such as more runtime depended methods that could return null, unless you assert it is definitely not going to be null. Your team will be on the same page about the logic. Your different architecture layers that will pass data between each other will error if you add variable to one layer and forget to adjust another layer.

---

Typescript also gives you errors before you have to run it in a web browser or node js instance. In VS Code, see the problems tab when I treated an object key as if it's case-insensitive

LinkedList

```
//...
nodeMap[NAME] = { NAME, type, prev: [], next: [] };  
//...
```

![](https://i.imgur.com/QQcxX4w.png)

---

And clicking on it jumps to that line in question.:

```
interface Node {  
  name: string;  
  type: string;  
  text?: string;  
  textLeft?: string; // Text explaining the left connection  
  textRight?: string; // Text explaining the right connection  
  prev: Node[];  
  next: Node[];  
}  

```
  

---


But resolves when:

```
interface Node {  
  NAME: string;  
  type: string;  
  text?: string;  
  textLeft?: string; // Text explaining the left connection  
  textRight?: string; // Text explaining the right connection  
  prev: Node[];  
  next: Node[];  
}
```