
Required background - UI reference
No Select Circle tool? May be hidden. Click and drag down:

![](https://i.imgur.com/zZT8wb2.png)

Material Select Gotcha’s

Must always Deselect all materials before clicking Select on a material (or click a blank area on the viewport to deselect all!). Otherwise it adds onto the previous material’s face selections

---

Let’s make the feet of a model be able to take different materials when it was not modeled to do so. You imported it in Blender


Select your object. Go into Edit Mode. Select edit faces (3). Select Material Properties

![](https://i.imgur.com/p06iMvr.png)

For the part of the object you want to have material slot in Unreal, you need a new material. Create the new material and the settings you want.

Then you assign faces to this new material. While in Edit mode, use “Select Circle” tool and a combination of SHIFT+ClickDragging to select the faces. You can ALT+ClickDragging to remove faces. Make sure to rotate viewport to get all angles. These will be the faces you want for a new material slot.

Once a face has any other material information, it can be removed from older materials. 

- But first prepare the viewport: Deselect on all materials while in Edit Mode because when using “Select” on any material, you can use “Select” again on a second material, and then the viewport shows both materials’ selections. We want to make sure all faces unselected.
- Click the old material that has had visual information in this part of the model (we will remove the association). Click “Select” on this old material to show the applicable vertexes. Use ALT+ClickDragging to remove faces where it’ll be unassociated. Make sure to rotate viewport to get all angles. Now you want only all other faces to remain associated with the old material. Click “Assign” when ready.  
    
- You want to make sure the assignment worked. Make sure all materials deselected so no vertexes are selected in the viewport. Click “Select” on the old material. It should not select the faces that you had assigned the new material. If it does select some old faces still, that means it doesn’t have any other material information associated with those faces; You had missed some faces on the new invisible material; so you’d have to select the faces of the new invisible material, then add onto the new invisible material, then assign; then you would try to remove the vertexes again off the old material.


Learned from a combination of:
[https://youtu.be/cKl_USwNc8M](https://youtu.be/cKl_USwNc8M)  
[https://www.youtube.com/watch?v=JYyUMMboZFk](https://www.youtube.com/watch?v=JYyUMMboZFk)  
[https://chat.openai.com/c/9c245b8c-85f9-4472-80f6-6e24298f4ad7](https://chat.openai.com/c/9c245b8c-85f9-4472-80f6-6e24298f4ad7)  
[https://chat.openai.com/c/53b01569-fb50-4269-840f-0430658a44a1](https://chat.openai.com/c/53b01569-fb50-4269-840f-0430658a44a1)  
[https://docs.blender.org/manual/en/latest/render/materials/assignment.html](https://docs.blender.org/manual/en/latest/render/materials/assignment.html)  

Next you export as FBX. Then import back into Unreal. The feet should be assignable to different matieral.