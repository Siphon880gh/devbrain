
Rig a model so it can animate, pose, or be playable possessable (Incl automatic weight and weight painting)

---


Two phases:

- Create Rig
- Confirmation Rig that mesh are overlapping (And apply as rest pose)
- Tie mesh to rig - Automatic Weights or Weight Painting

  

---

  
## Create Rig

**Four Options (A, B, C, D)  
  


### A. You can create rig with plugin Riggify which has templates of rigs

#### Installation

- Open Blender and go to Preferences then the Add-ons tab.
- Click Rigging then Rigify to enable the script.
- Restart Blender

**Using (if or when it’s installed)**  

Shift+A at viewport for Add menu

Armature → Basic → Basic Human Rig

For aligning the rig to the mesh, refer to Alignment section

Learned from
[https://www.youtube.com/shorts/B2SbP0WLlRc](https://www.youtube.com/shorts/B2SbP0WLlRc)

----

### B. Or you can manually create rig from bone to bone

Set where you want your first armature bone to appear. Shift-right click to set the 3d cursor at coccyx  
Create your first armature bone: Shift+A → Armature → Single Bone  
If mesh is hiding your armature making it difficult for you to transform armature into alignment with mesh, you may want to put armature in front of mesh. Refer to: [[_Rigging best practice - Armature - In Front]]. Quick tip: Go to object property of armature then under Viewport Display, tick In Front

  
-Once done with one bone, press E to “extrude” which adds another bone at the end of current bone, creating a joint, and you can resize the new bone in an extrusion movement of the mouse

  

**Align rig to mesh**  
Refer to Alignment section  
  
Learned from:  
[https://youtu.be/XkiWBSSuxLw?si=JYda05WWyzSzzyJN](https://youtu.be/XkiWBSSuxLw?si=JYda05WWyzSzzyJN)  
[https://www.youtube.com/watch?v=9dZjcFW3BRY](https://www.youtube.com/watch?v=9dZjcFW3BRY)

---

### C. Can use another model with similar rig as a base

Open a modal in Blender that’s similar rig shape (doesnt matter if A pose, I pose, or T pose because will adjust later). You can export unreal mannequin to be imported into Bender if appropriate

Right click and “Copy” the amature of bones from outliner

Now open the model without bones in Blender.

You’re going to make that model have bones/armature  

Paste into Collection.

![](https://i.imgur.com/QhOHoMD.png)

Check if the root of the armature is at the Collections level. See the two cyan icons? That’s the root of your armature. And it’s not necessarily going to be named root for you. In this example, the root of the armature is enclosed. We need to move it out so it’s at the Collections level. Drag the root item into the Collections

![](https://i.imgur.com/Zf7LCKW.png)

### D. Can use a rigged mannequin from unreal engine as base

**Export the mannequin character which has rigs. You export by: Content Drawer → Right click mannequin → Asset actions → Export**

**It’ll export as FBX. Then refer to the section:** Can use another model with similar rig as a base

---

## Alignment

Hot tips:

-Can move joint itself with G  
-Tip: G then z to move in z axis (again, G for grab)  
-A bit bend at elbow (G in the joint) else IK system doesn’t know it can bend. Same for knee.  
-Name right body parts suffixed with .R; same with left with .L; So blender can do auto symmetry. With those L bones selected in Edit Mode, press F3 for in-context menu search, then search for and activate Symmeize. It will create the right half.  


**I. General Alignment**

Make sure the armature are in the general alignment with the mesh. If the arm or leg poses dont match, we will adjust. If too tall or short, you can resize (r->x, or r->y, or r->z depending on your model)

Reworded: Make your armature into the same orientation, size, and placement as the mesh’s

![](https://i.imgur.com/pLquttW.png)

  

**II. Arm/Leg alignment**

Now transform either the mesh or the armature to have the body parts come into alignment. I’ll cover either way. But transforming the mesh is messier because you could miss a selection of vertex or polygon face. Transforming the armature is much easier because there are less pieces to select.


**A. Approach A: Transform the armature/bone parts to fit inside the mesh**

In pose mode you can readjust bones at any socket to fit into the mesh better

Warning: If you dont rotate in Pose Mode, you can’t rotate the bones attached to the joint. Instead, you’ll either be affecting the joint itself or the individual bone.

Hint: If can’t go into Edit Mode, it’s because your armature isn’t selected in the Outliner

![](https://i.imgur.com/5zwzWxL.png)

![](https://i.imgur.com/00G1015.png)

If you need to transform an individual joint (without moving its bones) or an individual bone, you select the peice (joint or bone) while in Edit Mode. Then you can transform with g/r/s, x/y/z keys

**B. Approach B: Transform the mesh parts to fit over the armature/bone**

This approach is NOT recommended because you could mis-select the vertexes causing deformity.

You can select the polygon faces of the arm in Edit Mode. Use a combination of Select Tools and SHIFT selecting to completely select the relevant part of the body.

From here, you can could try the macro approach to tweaking the mesh part transformation:

Go Pose mode. Can select joints and rotate

![](https://i.imgur.com/OKoG0p8.png)

If macrotweaking in pose mode just isn’t enough, you can microtweak that mesh’s part (either the joint or an individual bone). Go into Edit Mode. With the vertexes or polygon faces selected, you can perform g/r/s, and x/y/z.

When microtweaking a joint, don’t worry about snapping off and causing it to not work with the rest of the armature. In this example, you see the arm is still attached by a fine line. The arm will just be a ghost arm in armature view and it can still affect the mesh.

![](https://i.imgur.com/ujInwEO.png)

## Confirmation that mesh and rig are in alignment

  
1. Now confirm that the armature is inside the mesh and that they’re both the same height (S for rescale), and that they’re both in the same arm poses (T pose or A pose or I pose). Btw T pose is helpful for weight painting
2. Confirm resting pose

Go between Edit Mode and Pose Mode to see they are the same:

In this case, it’s not the same:
Edit Mode:
![](https://i.imgur.com/DVnXn02.png)

Pose Mode:
![](https://i.imgur.com/uPktTQw.png)

Then you’d have to set this new Rest Pose. From the Pose Mode (Pose Mode is available only when you have the armature selected), go to secondary menu Pose → Apply → Apply Pose as Rest Pose

![](https://i.imgur.com/Oyzv5fc.png)

---

## Tie mesh to rig - Automatic Weights or Weight Painting

Automatic Weights is having Blender’s engine determine how much a bone and joint affects the mesh. It may get the estimations wrong.  
Weight painting is you visually setting how much a bone and joint affects the mesh using a paint system. You will do automatic weights then use weight painting to work out the kinks.

## Automatic Weights

In Object Mode, select mesh then SHIFT + select the armature. Press CTRL+P then parent it to Armature Deform... With Automatic Weights.

To confirm successful: 

Go into Pose mode, when you select the bone (maybe upper arm) and move the bone, so will the mesh move (arm mesh would move)


Good:
![](https://i.imgur.com/lH0WyR8.png)

Bad:
![](https://i.imgur.com/s59Dobh.png)

Don’t forget to test ball joints too. Character rotates along the joints of the bones:
![](https://i.imgur.com/Eve8l7r.png)

---

## Weight painting to work out the kinks

Eg. Moving the arm at the shoulder joint caused hair to move?!

![](https://i.imgur.com/doUKde8.png)

While in Object Mode, select the armature, then SHIFT+ select the Mesh. Now you can and should go into **Weight Paint.** This gives a general coloring.

Blue means no effect. Green means mid effect. Yellow is slightly more. Orange even more. Red means max effect.

![](https://i.imgur.com/tIDDVdV.png)


General coloring is not useful. You want to look at the coloring on the mesh from a particular bone. While still in Weight Paint editor mode, with your armature selected in outline, go to **Data settings**
![](https://i.imgur.com/ViF8cuf.png)

Click a vertex group to see a bone and their effect on what mesh area(s).
![](https://i.imgur.com/csJR3zt.png)

To start painting, make sure the areas are selected in the viewport. Press A. Without pressing A, painting and blurring will be ignored.

Blur tool: Smooths out the _weighting_ of adjacent _vertices_. In this mode the _Weight_ Value is ignored. The strength defines how much the smoothing is applied. 

Paint brush:

Weight: 0 is blue, 1 is red (blue/green/yellow/orange/red) . 0 is no movement of the mesh, whereas 1 is max. So weight corresponds to a painted color and how much the selected bone deforms/moves the painted mesh
Radius...
Strength...  
  
Works like a paintbrush like it were in a photo editing software. So you can click and drag to paint. You can paint at a spot but you may have to click multiple times depending how strong you want the paint.

You can add or subtract weight paint with ALT/SHIFT + clicking the mesh in the editor. If you only click (without ALT/SHIFT), then it’s based on the weight (setting to 0 erases, setting to 1 adds weight)

You can add or subtract from a noncontinuous area with ALT/SHIFT + clicking the mesh in the editor.

Case in point, if you had painted an active right arm AND active abdomen to the right arm, when you rotate the arm in animation or poses, it affects the arm mesh and also the abdomen will do a weird worm popping out or hernia extrusion.  
  

---

  
There may be more nuances to keep in mind depending on your model and use cases, requiring you to change some settings. Eg. whether your painting affects the other side of the model, and other considerations:  

[https://www.youtube.com/shorts/eDTMlpPloIc](https://www.youtube.com/shorts/eDTMlpPloIc)  

  

---

## Painting not working?

Here you imported a model from somewhere and hypothetically it has rigs (aka armature) included. The right shoulder animations/poses causes part of her hair to move as well. This was a bug so you want to remove the hair’s weight paint or set it to blue (aka 0 weight)

![](https://i.imgur.com/baoHKUR.png)

However, it doesn’t let you.

You have to select all (press A). Now notice the visual change:
![](https://i.imgur.com/7mCh5nY.png)


With weight set to 0, now it allows you to paint. Notice we removed the hair from being affected by the right shoulder movements in animations/poses/character possession:
![](https://i.imgur.com/K50w3St.png)


---

Learned from:

[https://www.youtube.com/watch?v=9dZjcFW3BRY&t=11s](https://www.youtube.com/watch?v=9dZjcFW3BRY&t=11s)