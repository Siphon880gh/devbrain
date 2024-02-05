
Easily add another face from an edge, whether it's a triangular or a rectangular face. As you add face after face, because each new face extended from a prior edge, they're connected together. Great for creating a complex cover over a model or for creating an architectural model or base model* from scratch. 
\*Base model from which you will sculpture from to add more organic round shapes and curves.

Polybuild is usually toggled between polybuild and normal editing:
- Adding more vertexes that are filled with continuous mesh: Press w to switch back to tweak, then add vertex with CTRL+LMB in an empty space, then select that new vertex and two vertexes of a nearby edge. Then press F to fill the face. Switch back to Polybuild to resume new faces.
- Distorting a face to desired shape: Press w to switch back to tweak, then select vertex (press 1), then G and move into new distortion, click to commit. Switch back to Polybuild to resume new faces.

Theory:
Polybuilding is actually a streamlined way to extrude edge (for rectangular face) and to fill a new vertex with two nearby vertexes (for a triangular face) but in a create-and-connect way.

Use cases:
Usually used for repotology where you add geometry on top of a mesh that has too many geometries (from either a model import or was built from sculpturing) and so many geometries that it's impractical to rig/animate with proper weight painting. By adding vertexes/faces overlaying on model, these less vertexes/faces can serve as the new weight paintable geometries for rigging/animation from the armature/bones..

Shift+Spacebar in Edit Mode -> Select Polybuild

![](https://i.imgur.com/6xXdS3L.png)

---

## Rectangular face

Click and drag out from an edge to create another face

![](https://i.imgur.com/OdcOrwr.png)

![](https://i.imgur.com/6Ui25Wd.png)


Because it extended from the nearest edge, this is a face connected to your previous faces of polybuild.

---

## Triangular Face

Hold CTRL and click an empty area to commit a triangular face. It creates a triangular face from the nearest edge to where you clicked in a new vertex. Because it extended from the nearest edge, this is a face connected to your previous faces of polybuild.

![](https://i.imgur.com/qUzbClQ.png)


---

Click and dragging a vertex distorts the shape (originally a square) just like you would if you had normally selected a vertex, G, then drag and click. Polybuild made this distorting process easier with less clicks.

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