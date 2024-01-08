

If the imported model has armature/bones/pose mode, this is the most involved when it comes to clicking different parts of the app

Use case:
You have a FBX file from Sketch Fab, 3DFree, etc but the posture of the arms are wrong
You want to pull the arms down to a more neutral standing position. Sure!

![](https://i.imgur.com/hAlmGv5.png)



Get Blender 4.0

Create new project

File → Import → FBX
Import the file

---

Useability

Move mode with Object Mode

![](https://i.imgur.com/aQ15EQK.png)



Now scroll wheel to orbit, CTRL+scroll wheel to dolly forward/back

CMD+Z works very well

Shortcuts: Ctrl+Tab to switch between Object/Pose mode etc

---

Correct use: What Mode is available to you depends on what’s selected


Select Armature at the Outliner panel if you want Pose Mode to be available. CTRL+Tab to quickly see the modes available

---

At Outliner panel top right

Collection → Armature → Pose → ... Forearm
Btw this is only available in Pose Mode


LeftForearm adjust X
RightForearm adjust X

![](https://i.imgur.com/2kvuD07.png)

![](https://i.imgur.com/SqmdCQY.png)

  

Then play between left arm and left forearm

And right arm and right forearm, and you’ll get:

![](https://i.imgur.com/XGmKCkb.png)


Parent the mesh to an armature so when you set the pose of the armature (the structure made of bones), both the mesh and the armature will set the resting pose (rather than none of them resets or stays put)
 - Video on how: https://www.youtube.com/watch?v=PtOYyQpcLJk
 - TLDW: Be in object mode. 
Select object you want to parent to the character (the mesh)

![](https://i.imgur.com/U7QU4Xq.png)

- Hold shift and select athe amature
- Then go into Pose Mode
- Select the bone you want the pairing to finish
- Ctrl+P for “Set Parent To”, and select Bone (which is Amature)

Now you need to apply your pose as the resting pose before exporting it back out as another FBX file to be imported into Unreal’s Content Drawer:
![](https://i.imgur.com/lQYrpgj.png)

See secondary menu strip has “Pose”
Navigate to 'Apply' > 'Apply Pose as Rest Pose'.

---

An alternative to setting a parent relationship is to apply the Armature Modifier, which is not recommended.

When you apply the Armature modifier to a mesh, the mesh takes on the shape of the armature's current pose as its new rest position. This is generally not recommended during the rigging and animation process because it removes the flexibility of the rig. Instead, you typically want to keep the armature modifier active but unapplied so you can continue to pose and animate your mesh.

How you would do it anyway is, after adjusting the appearance in Pose Mode, go into Object Mode. Select the relevant Modifiers → Armature → Armature

![](https://i.imgur.com/3D5sTqJ.png)

Then in Properties → Modifiers (Wrench)
![](https://i.imgur.com/fzyGSbQ.png)

Proceed to set rest pose as usual.

---


Background:

When you set a pose in Blender, you're actually manipulating the armature, not the mesh directly. Here's how it works:
Armature (Bones): The armature is a structure made up of bones. In Pose Mode, you select and manipulate these bones. Moving, rotating, or scaling the bones will change the pose of the armature.

Mesh Deformation: The mesh is typically linked to the armature through a process called skinning or weight painting. Each vertex of the mesh is assigned a weight for one or more bones. When you pose the armature, the vertices of the mesh move according to the weights of the bones they are associated with. This is how the mesh deforms and follows the pose of the armature.

The Armature Modifier: This modifier is what connects the mesh to the armature. It's responsible for calculating how the mesh deforms when the bones of the armature move. The actual geometry of the mesh remains unchanged; it's the modifier that provides the real-time deformation effect.

Setting a Pose: When you set a pose, you are adjusting the positions, rotations, and scales of the bones in the armature. The mesh follows these changes because of the weights assigned to it through the Armature modifier. The actual mesh data (like vertex positions) doesn't change until you apply the modifier, which is generally not done until you're completely finished with rigging and posing.

Pose Mode vs. Object Mode: In Pose Mode, you're specifically adjusting the pose of the armature. In Object Mode, you can move, rotate, and scale the entire object (which can include both the mesh and the armature if they're parented or linked together), but you're not affecting the individual bones' positions within the armature.
Animation and Keyframes: If you're animating, you'll set keyframes for the bones in various poses. The mesh will follow these poses throughout the animation due to its connection with the armature via the Armature modifier.

In essence, when you set a pose, you're moving the armature, and the mesh follows due to the relationship established between the mesh vertices and the armature bones. This allows for a flexible and non-destructive way to animate characters and objects.

ChatGPT more info:
https://chat.openai.com/c/dd44ea05-e1a1-4325-afec-2410e0f5835c
https://chat.openai.com/c/c07f2737-ff46-4f7b-b7b1-6b3d9bcbb364