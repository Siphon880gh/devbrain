
Video demonstration:
https://youtu.be/V4PG30MjVwM

If you're extruding and haven't commited yet with a click, and then you click Escape to cancel the extrusion - it'll look like you restored to the original state before extrusion.

However, you actually ended up with an extrusion that did not move 1 pixel. You have double the vertexes overlaying each other. You can see this proven if you move one of the vertexes where you had extruded, and it'll act like a duplicated vertex. Make sure to UNDO

So canceling an extrusion:
E. Drag. Escape. CMD+Z.

---

If you already had opened a new session so undo is not possible, you'll have to select all vertexes, then go to secondary menu Mesh -> Clean up -> Merge by Distance. If secondary menu item Mesh is not found, go into Layout module (primary menu).

This will merge duplicated vertexes that overlay in the same coordinate.


