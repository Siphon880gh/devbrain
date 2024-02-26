
Learned from:
https://www.youtube.com/watch?v=lRK8UMudejg

## Overview

You can create a curve object in the viewport editor, then adjust how it curves.
![](https://i.imgur.com/Dz0e253.png)


You have an array for duplicated objects:
How? Refer to - [[Duplicate object along a path - Array Modifier]]
![](https://i.imgur.com/eMzjCMU.png)


Then you will combine the two so that the duplicated objects follow the curve:


![](https://i.imgur.com/E0SOPiN.png)


----


## Create duplicated objects along a straight path


How? Refer to - [[Duplicate object along a path - Array Modifier


---

## Create path object

In Object Mode -> Shift+A -> Curve -> Path

That creates a straight path:
![](https://i.imgur.com/13Y0Pja.png)


In Edit Mode, you can change it into a curved path
![](https://i.imgur.com/fjBD3vN.png)

Refer to finetuning Path

---

## Combine both objects

Place the curvevd path over the duplicated objects' path. Try to have the same scale. And place them at the center of the scene. Set the 3d cursor at the center point of the scene as well (Shift+RMB).

![](https://i.imgur.com/HhTDkwy.png)

Then select both objects in Object Mode and apply all transformations: CTRL+A -> All Transformations. (This step is important because the modifier will be based off of 0,0,0 coordinates and we need to reset the objects to correspond to 0,0,0)

Select the duplicated objects, go into Modifer settings (wrench icon), add Curve modifier underneath the Array modifier which had been used to duplicate your object.

At the Curve settings, target the curve object. Here you'll see I targetted NurbsPath.001 which is the name of the curved object we created in an earlier section.
![](https://i.imgur.com/BWRtyET.png)


Switch the "Deform Axis" until the duplicated objects path match the curved path appropriately. It doesn't matter if the rotation or the placement is wrong - we adjust that in the next section. We are just focusing on the path of the duplicated objects.

---

## Further Tweaking - Into Position

**Explanation: **If you need to rotate/move the curved duplicated object or the path object, it will mutate  the curve that the duplicated objects take because it'll be applying the curve path at different coordinates of the duplicated objects.

**How:** If you need to rotate / move / resize the duplicated objects that follow a curved path. Create an empty object (SHIFT+A->Empty->Cube). Then pair the duplicated objects array as a child of the empty (Select the duplicated objects, then SHIFT+Select the empty, then CTRL+P -> Object). Then pair the path object as a child of the empty as well.

Now you can move/resize/rotate the cube instead, and it'll apply the transformation to the array of duplicated objects without distorting its curved path.

Tip: If you need to orientate your view back to seeing the curve/duplicated objects, it may help to go into ghost mode (CTRL+~) to position camera then click.

![](https://i.imgur.com/E0SOPiN.png)


---

Further Tweaking - More compliant object that bends to the path

You can see that each object on this curved path is rigid:


![](https://i.imgur.com/E0SOPiN.png)

---

Approach: In Edit Mode, you could Subdivide (press A to select all vertexes -> Right click object -> Subdivide). Subdivide a second time. This will allow each individual object to bend to the curved path in this particular way

![](https://i.imgur.com/CnUqCAF.png)


![](https://i.imgur.com/A7eaGFu.png)

---

Approach: In Edit Mode, you could add loop cuts (press A to select all vertexes -> Shift+Space to open labeled tools popup menu -> Loop Cut). Divide like so. This will allow each individual object to bend to the curved path in this particular way


![](https://i.imgur.com/VJZDUqg.png)

![](https://i.imgur.com/34BcAeI.png)

---

Approach: You could poly to low-poly to give it natural curves as if it bends at each individual object. Select object in Object Mode, CTRL+4 for level 4 subdivision surface modification. You can try other levels of details as well.

![](https://i.imgur.com/TFFMaI0.png)

---

## Dont be alarmed - Edit Mode

When you go into Edit Mode, the objects will flatten back to a straight path. That is expected. It'll go back to the curved path in Object Mode.

When in Edit Mode, selecting all (by pressing A) will highlight only the vertexes of the original object. Duplicated objects will appear as if they have no vertexes. Modifying the original object's vertexes in a way that changes the mesh will affect those of the duplicated objects.

---

## Practice

Create a curved road
https://www.youtube.com/watch?v=lRK8UMudejg
