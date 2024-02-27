Destructively means that you resized/thickened an item with S->X, for example; but only way to undo it is the undo command; when exited Blender, there's no going back without manualing it.

With nondestructive approach, you create a modifier that has data on your changes. You can toggle off or delete the modifier data. You are not manipulating the actual vertexes directly, but rather, you have the modifier data manipulate the vertex:

---


I have a flat surface aka mesh plane:
![](https://i.imgur.com/X3yRe7W.png)

With the object selected, I go into Modifiers properties:
![](https://i.imgur.com/vFY0UNj.png)

I add a Solidify modifier:
![](https://i.imgur.com/upmmpPQ.png)

Then I adjusted thickness:
![](https://i.imgur.com/U9oTPaT.png)

Now in the Outliner I have a new modifier item that applies this size transformation, that I can toggle off, remove, move to another object, etc:
![](https://i.imgur.com/2J7Xwif.png)
