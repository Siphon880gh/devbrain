
It's resizing based on normals of a vertex.

Reworded: This operation adjusts the vertices of a mesh along their normals, either moving them closer together (shrinking) or further apart (fattening). It's particularly useful for adjusting the thickness of an object without altering its overall shape in the way uniform scaling would. For instance, you might use it to thicken a wall or to add volume to a character's limbs. This operation doesn't scale the object in a traditional sense but rather moves the vertices in or out along their normals.

---

How activate: ALT+S instead of S
Or: SHIFT+Space and select Shrink/Flatten

---

To best exemplify this, create a cylinder, go into Edit Mode, then set Selection Mode to Polygon Face

You can see that the polygon face is along the X axis (red):
![](https://i.imgur.com/JlxmyTI.png)


So lets resize along X by pressing: R -> X

![](https://i.imgur.com/8BKqix9.png)

----

Instead of S->X, lets do shrink/flat with ALT+S -> X

In one direction:
![](https://i.imgur.com/W3QcdC1.png)

In the other direction:
![](https://i.imgur.com/71nkxGt.png)
