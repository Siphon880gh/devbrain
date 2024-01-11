
Look for the model’s feature to determine the appropriate method:

If there’s a pose component, you should go into Pose Mode. You are changing the position of the bone, so you have to select both bone and mesh then CTRL+P to have the options to make the bone into the parent (henceforth, the mesh is the child that follows the parent). This keeps future animations behaving as expected and prevents applying rest pose from only applying the bones and not the mesh.

If there are vectices or preferably polygon/faces, you select those vertices, then transform at the secondary menu's Move

If there is an object with no vertices and no bones/amature, you just select object in Object Mode then select Transform tool

---

Then you will reset the resting posture before exporting it back out as another FBX file to be imported into Unreal’s Content Drawer:

![](https://i.imgur.com/U5oLd3c.png)



See secondary menu strip has “Pose”
Navigate to 'Apply' > 'Apply Pose as Rest Pose'.