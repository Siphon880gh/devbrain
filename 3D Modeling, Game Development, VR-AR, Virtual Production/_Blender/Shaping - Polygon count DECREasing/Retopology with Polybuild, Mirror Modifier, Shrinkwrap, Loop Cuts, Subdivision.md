
Polybuild can decrease polygon count if you snap and shrink wrap it to the object, then merge the vertexes by distance.

Use cases:
Usually used for repotology where you add geometry on top of a mesh that has too many geometries (from either a model import or was built from sculpturing) and so many geometries that it's impractical to rig/animate with proper weight painting. By adding vertexes/faces overlaying on model, these less vertexes/faces can serve as the new weight paintable geometries for rigging/animation from the armature/bones..

In order to perform repotology, there is a collection of techniques and tools to make it easier to create faces and vertexes close to the surface of the old model. Blender does not have a "repotology" button or tool


Required Skills: Refer to all basic lessons at [[Polybuild]]

## Setup

Now add those faces on the mesh. You can practice off of Suzanne the monkey:
![](https://i.imgur.com/7R0hCLp.png)

![](https://i.imgur.com/h6P0X6z.png)

Add a subdivision level 2 modifier (CTRL+2). Refer to [[Subdivision Surface Modifier]]. This will make it easier to add our new less and simplified geometries

Right click object -> [[Shade Auto Smooth]]

---

Add a small mesh plane to top right forehead (Top right because we will mirror across forehead to add simpler geometries/vertexes). Hint: Shift+A -> Mesh -> Plane. Resize, grab/move, click into place

---

We will prepare to mirror.

Select all objects by pressing A.

Then apply all transformations (CTRL+A -> All Transforms). This resets the new rotation and position as 0,0,0 and bew scale as 1,1,1, so mirror can work properly (future step)

---


Make mirror so can be symmetrical, cutting your work down to half. Make sure plane mesh selected, go to Modifier option (wrench icon), add Modifier, searching for "Mirror". Make sure to tick "Clipping"


![](https://i.imgur.com/kAGHVwy.png)

![](https://i.imgur.com/vfCoSWX.png)

![](https://i.imgur.com/V39ZMG3.png)


---

Why we add clipping to mirror?


Without clipping, when you selected vertexes in Edit Mode and move them, they can have mesh cross the origin "mirror barrier"


![](https://i.imgur.com/fBu5Ad7.png)


With clipping, you cannot pass the "mirror barrier" which is likely your intended use

![](https://i.imgur.com/d1PMHBr.png)

![](https://i.imgur.com/1LGE8BF.png)


---

Now we have the plane snap to the face by enabling snapping, snap to face, and even aligning rotation to the face:

![](https://i.imgur.com/hkABKMV.png)

![](https://i.imgur.com/QPpUfzr.png)

You still won't see any changes until you grab the mesh plane. Then it'll snap to the face.

![](https://i.imgur.com/bzIV6Y7.png)


Sped up tutorial:
You will add more faces to cover the mesh using polybuild. You will add shrinkwrap modifier to merge pane meshes to the surface of another object.


---


## Polybuild

Perform all Polybuild techniques in order to create a cover of polygon faces around the model. This cover will replace the previous vertexes and polygons because there are less vertexes and polygon, making animating/rigging more achieveable. Refer to [[Polybuild]] for the polybuilding techniques. Next step is shrinkwrap which will bring the cover of polygon faces and vertexes closer to the model's mesh.


---


## Shrinkwrap:
From - https://www.youtube.com/watch?v=YksPYPa05LM

![](https://i.imgur.com/bYgH5L8.png)

After:
![](https://i.imgur.com/L5UjHnu.png)

![](https://i.imgur.com/R3TipVO.png)


----


## Finetuning Retopology


![](https://i.imgur.com/bV7afWs.png)

If some retopology faces are not compliant to the underlying shape, you can add more gives to the faces by adding more geometry lines: 
- With subdivision to both axes (right click -> S) 
- Or with loop cut to one axis (ctrl+r) aka round cuts


---



## Cleanup


Merge by distance. Edit Mode: Press M -> Merge by distance

![](https://i.imgur.com/Us3LaAF.png)

Apply all modifiers to bake them in. Press CTRL+A or click down caret -> Apply.
![](https://i.imgur.com/nCpOhJH.png)



---


Learned from:
https://www.youtube.com/watch?v=r5ZLJ0tNlhc&t=122s