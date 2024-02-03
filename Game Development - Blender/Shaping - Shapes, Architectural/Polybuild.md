
Easily add another face from one edge. Usually coupled with adding more vertexes that are filled with continuous mesh (CTRL+LMB) which is normal vertex editing (no polybuild necessary but polybuild makes it easier to do) and selecting a vertex and grabbing/moving it with the continuous mesh (which is normal vertex editing except polybuild makes it easier to do).

Use cases:
Usually used for repotology where you add geometry on top of a mesh that has too many geometries (from either a model import or was built from sculpturing) and so many geometries that it's impractical to rig/animate with proper weight painting. By adding vertexes/faces overlaying on model, these less vertexes/faces can serve as the new weight paintable geometries for rigging/animation from the armature/bones..

Shift+Spacebar in Edit Mode -> Select Polybuild

![](https://i.imgur.com/6xXdS3L.png)


Click and drag out from an edge to create another face

![](https://i.imgur.com/OdcOrwr.png)

![](https://i.imgur.com/6Ui25Wd.png)

---

Click and dragging a vertex distorts the shape (originally a square)

![](https://i.imgur.com/Tm46aWK.png)


---

Shift clicking top left corner removes it, changing a square into a triangle (originally a square)
![](https://i.imgur.com/RCWE1cH.png)

---

Ctrl clicking an empty area will create a new vertex and connect continuous mesh to nearby vertexes

![](https://i.imgur.com/RAI6Dcg.png)

![](https://i.imgur.com/zDwoAMK.png)


---

Case study to combine other skills

After creating many faces with polybuild, we have problems with gap:
![](https://i.imgur.com/hA85HKn.png)

Lets fill in the above gap by going back to normal vertex editing tools
![](https://i.imgur.com/8PPMVgF.png)

![](https://i.imgur.com/8UC4axi.png)

![](https://i.imgur.com/yrctWZe.png)

![](https://i.imgur.com/n02AwGx.png)

Hint: Selected two vertexes (press 1), then filled (press f). That created an edge.
Next selected a third vertex (all three vertexes), then filled (press f). That created the face.