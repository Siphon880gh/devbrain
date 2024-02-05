
If your model doesn’t have armature/bones/pose, but it has vertices and polygon faces, and you are changing its pose, you have to select all the relevant vertices and transform them as a group.

Use case:
**You have a FBX file from Sketch Fab, 3DFree, etc but the posture of the arms are wrong**
You want to pull the arms down to a more neutral standing position. Sure!

## Selection

You will select all the vertices/polygon faces that need to be translated/rotated together

Go into Edit Mode:
![](https://i.imgur.com/66WOKVW.png)

![](https://i.imgur.com/hT1sFGg.png)

![](https://i.imgur.com/6IEYs3D.png)

You can drag in the axes, zoom, and hand panning to orbit around the character
![](https://i.imgur.com/7v0lM5h.png)

You have to make sure you don’t miss any vertices/polygon faces
![](https://i.imgur.com/W5nY22K.png)

You select an area of vertices/polygon faces with:
SHIFT+drag over area

But when you over selected vertices that shouldn’t be included:
Shift+click can deselect the particular vertex

You can also use a paint action to add vertices (Like in Windows Paint). You click the Select Circle in Edit Mode, then click and drag over vertices (if adding to previous vertice selection, hold Shift while you click and drag)
![](https://i.imgur.com/1hhiXQi.png)

## Transformation

Once the vertexes are selected, you can transform:

![](https://i.imgur.com/pAlhoN0.png)

---

![](https://i.imgur.com/lBctLSA.png)

![](https://i.imgur.com/CsIqaZC.png)


---

![](https://i.imgur.com/OSETgGe.png)

![](https://i.imgur.com/M6Qav8q.png)

![](https://i.imgur.com/XTAWI47.png)

![](https://i.imgur.com/HYyOfZr.png)


---


Rotate:
![](https://i.imgur.com/zuhqTpF.png)

Move:
![](https://i.imgur.com/PNbEgZZ.png)

I missed a polygon on his left arm (off his wrist) - noo! Then you can either undo (there's Undo History) and restart this or try deleting that one-off vertex to see if it affects the model's appearance

You may find that after rotating and translating the arm, the shoulder might have sharp extrusions. Refer to this for fixing: [[Sculpturing Related - Smoothen]]