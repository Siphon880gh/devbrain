Use case: When you import a model into Unreal, it came in pieces that you have to assemble together. You don't have time for that. So you can open in Blender which will place all the pieces together as divided meshes

Then you will join the mesh. Now when you import back into Unreal, it'll be one peice that you don't have to assemble:

Problem:
![](https://i.imgur.com/Mrk4f98.png)

Desired:
![](https://i.imgur.com/zUviJw6.png)

---

Import model into Blender. Then try to select the model. You'll see a part of it is selected:
![](https://i.imgur.com/Da1nluv.png)

We will merge all parts:
Object Mode → Press A to select All
Right click → Join (which is CTRL+J or CMD+J depending on computer)

![](https://i.imgur.com/eswF4CQ.png)


Can’t join? Doesn’t show join option? Make sure to exclude other objects such as Camera and Light in your selection

Click the model to double check it selects the entire model
![](https://i.imgur.com/n1qTdi1.png)

Now export it out. When you import back into Unreal, it should be all in one piece.