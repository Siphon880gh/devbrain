
Learned animating keyframes in Blender:
[https://www.youtube.com/watch?v=AEAc_lLjOMc&t=470s](https://www.youtube.com/watch?v=AEAc_lLjOMc&t=470s)  

Learned how to manage multiple animations as Actions in Blender:
[https://www.youtube.com/watch?v=ElkRd074Asg](https://www.youtube.com/watch?v=ElkRd074Asg)

---

## Editor Setup:

You don’t need to open the Animation module from the primary menu strip

There’s an animation panel at the bottom of the viewport. You may need to resize. Then you want to add the Summary, which is akin to video editing software’s track names, except here it’ll show you which transformations and objects are keyframed:
![](https://i.imgur.com/35yt8bK.png)

![](https://i.imgur.com/jmYpaOq.png)

---

## Output Setup

Setup the correct FPS and animation length

If you will be exporting the model (which will include animations) into Unreal Engine, bear in mind that Unreal Engine by default will use different fps based on the project template. If you chose a Project Template, game template is 30fps, film/movie template is 24fps. A mismatch could throw errors when importing a model with their animations. Your option is to change Unreal’s fps (probably not the ideal), or to change Blender’s fps. In Blender, you’d click the object with the keyframes, go into Output Properties, then change Frame Rate (More info below). You also have to make sure in the Output Properties that the animation ending frame is a whole number multiple of 30fps or 26fps, etc (eg. 250 frames is not correct for 30fps, but 300 frames is), whichever your fps needs to be.

---

## Adding Keyframes

With your object/model/shape selected, in Object Mode, open the Object properties:
![](https://i.imgur.com/goL7XL4.png)

![](https://i.imgur.com/7RSfI00.png)

Or press I (for insert keyframe)

Or have it automatically insert keyframes:

![](https://i.imgur.com/vIpGXJd.png)

  

## Finetuning Keyframes

**Selection of objects affect what keyframes appear in the timeline**

Your keyframes dont show up in the animation timeline if your object(s) isn’t selected in Outliner. You can ALT click to select more than one object. You shift click to select continuous objects between the first selected and where you shift clicked.

**You can drag keyframes on the timeline of frames**

**You can affect the bezier curve of two keyframes’s lerping. Go into Animation module which will expand the animation controls you have. Go to Animation module’s primary menu View, then select ”Toggle Graph Editor”**

![](https://i.imgur.com/Ppe2ETf.png)

  
This is the graph view.  At a keyframe is an anchor point with left and right handles that let you finetune the curvature of path segments between anchor points, similar to Photoshop’s Pen Tool used to create selection paths.

![](https://i.imgur.com/rZI3mAS.png)

  

---

  
## Troubleshooting Dope Sheet

Keyframes dont show up on the Dope Sheet / Animation Timeline
- Make sure the object with keyframes is selected at the Outliner.

---

## Make animation exportable

You have to create an “Action”

Switch the animation editing context to Action Editor

![](https://i.imgur.com/32DWjGE.png)

![](https://i.imgur.com/No0xJtn.png)


FYI: The keyframe timeline is the Dopesheet. Dope was an old slang that stood for “data” or “information”. Before computers, animation was done on a sheet to track the timing of each frame, camera movements, dialogue, etc.

Shield icon saves as an action (animation preset). Type your desired action name, then click shield

![](https://i.imgur.com/mc03L10.png)


And you can see/manage all actions:

![](https://i.imgur.com/khYIflv.png)
  
---

## When exporting the model (FBX, gltf, glb, etc)

Make sure Baked Animations are ticked

Explanation: This is crucial for ensuring that procedural or Blender-specific functionalities are converted into keyframed animations that can be understood by other software or engines.

---

## When importing into Unreal:


Make sure “Import Animations” is ticked
![](https://i.imgur.com/cS9ZLnr.png)

  
---

## Unreal importing errors:

**Animation length 5.125 is not compatible with import frame-rate 30 fps (sub frame 0.75), animation has to be frame-border aligned. Either re-export animation or enable snap to closest frame boundary import option.** 

The error message you're encountering while exporting an animation from Blender to Unreal Engine is due to a mismatch in the frame rate settings and the actual length of the animation. The error indicates that the animation length does not align perfectly with the frame rate you've set for the import. Here's how you can resolve this issue:

1. **Adjust Animation Length in Blender**: The simplest solution is to adjust the length of your animation in Blender so that it aligns with the frame rate. Since your frame rate is 30 fps, the animation length should be a multiple of 1/30th of a second. For an animation length of 5.125 seconds at 30 fps, it doesn't align perfectly with the frame rate (5.125 * 30 = 153.75 frames, and you can't have a fraction of a frame). You could adjust the length of your animation to 5.1 seconds (153 frames) or 5.1333 seconds (154 frames) to align properly.
    
2. **Enable Snap to Closest Frame Boundary in Unreal Engine**: If adjusting the animation length in Blender is not feasible, you can choose to enable the 'snap to closest frame boundary' import option in Unreal Engine. This option will automatically adjust the imported animation to align with frame boundaries. However, be aware that this might slightly alter the timing of your animation.
    
3. **Re-export with Compatible Frame Rate**: Another approach is to re-export your animation from Blender with a frame rate that matches the length of your animation. You might need to experiment with different frame rates to see which one aligns perfectly with your animation length.
    
4. **Manual Adjustment of Keyframes**: If the animation is short and not too complex, you might consider manually adjusting keyframes in Blender to ensure that all key actions occur on frame boundaries.
    

Remember, the goal is to ensure that the number of frames in your animation is an integer value when multiplied by the frame rate. This ensures compatibility with Unreal Engine's requirements for frame-border alignment.

---

**To adjust animation length:**

You have to make sure in the Output Properties that the animation ending frame is a whole number multiple of 30fps or 26fps, etc (eg. 250 frames is not correct for 30fps, but 300 frames is), whichever your fps needs to be. 

In the Timeline or Dope Sheet, look for the 'End' frame setting. This is usually located at the bottom of the Timeline.

![](https://i.imgur.com/bBam2q3.png)


---

**Another way to adjust animation length -**

Select your object with the keyframes, go into Output properties ![](https://i.imgur.com/jQXvepq.png)

Then under Format, adjust Frame Rate.

---


**To adjust fps:**

Select your object with the keyframes, go into Output properties ![](https://i.imgur.com/jQXvepq.png)

Then under Format, adjust Frame Rate.


---

## Confirm

Scrub or play the animation timeline / dope sheet to confirm your keyframes are animating.


---


## Saving as Animation you can export with the model

  
In Blender, saving animations as actions is an important step, especially when you want to export them or use them in different contexts. After saving as an action, you want to bake into the model. Your model may contained multiple baked animations.

1. **Create Your Animation**:
    
    - First, create your animation using keyframes. This can be done by selecting the object or armature you want to animate, moving to the desired frame on the timeline, and then setting keyframes (usually with the 'I' key) for the properties you want to animate (like location, rotation, scale).
2. **Open the Dope Sheet**:
    
    - Go to the Dope Sheet window in Blender. This area allows you to see all the keyframes of your animations.
3. **Switch to Action Editor**:
    
    - In the Dope Sheet, find a dropdown menu usually set to 'Dope Sheet' and switch it to 'Action Editor'. The Action Editor is used for more detailed editing of keyframes and is ideal for managing actions.
4. **Create New Action**:
    
    - Click on the 'New' button to create a new action. If you already have keyframes set, they will automatically be associated with this new action. Name your action appropriately.
5. **Adjust Your Keyframes**:
    
    - You can now adjust, add, or remove keyframes as needed for your animation within this action.
6. **Push Down or Stash the Action** (Optional):
    
    - If you want to save the action for later use or apply multiple actions to the same object, you can 'Push Down' or 'Stash' the action. This makes the action a non-linear animation (NLA) strip, allowing you to layer or blend multiple actions.

7. Refer to Baking section

8. **Export Model**:
    
    - If you are exporting your model and animations to another format (like FBX), ensure you select the appropriate options in the export dialog to include animations. (Bake Animation most bottom export option)


---

## Reference: Baking Animation

### Baking Object Animations

1. **Select Your Object**: First, select the object with the animation you want to bake.
    
2. **Open the Animation Panel**: Go to the 'Animation' workspace from the top menu to get easy access to timeline, dope sheet, and other animation tools.
    
3. **Choose Bake Action**:
    
    - At Animation module, make sure in Object Mode. At secondary menu, go to `Object` > `Animation` > `Bake Action...` in the 3D Viewport menu. This opens the Bake Action settings.
4. **Set Bake Action Settings**:
    
    - **Frame Start/End**: Set the range of frames you want to bake.
    - **Only Selected Bones** (for armatures): If you're baking an armature, you can choose to bake only selected bones.
    - **Visual Keying**: Bakes the animation as it appears in the viewport, taking constraints and modifiers into account.
    - **Clear Constraints**: Removes constraints from the object after baking.
    - **Overwrite Current Action**: Replaces the existing animation with the baked one.
    - Adjust other settings as needed based on your specific requirements.
5. **Bake**: Click on the 'OK' or 'Bake' button to start the baking process. Blender will create keyframes for each frame in the specified range, capturing the animation exactly as it appears.
    

### Baking Physics Simulations

For physics simulations (like cloth, soft body, or particles), the process can be slightly different:

1. **Select the Object with the Simulation**: Make sure you have the correct object selected.
    
2. **Physics Properties**: Go to the Physics tab in the Properties panel.
    
3. **Bake the Simulation**:
    
    - Find the appropriate section for your simulation type (e.g., Cloth, Particles).
    - Look for a 'Bake' button or similar option. This might be under 'Cache' for many physics types.
    - Click 'Bake' to calculate the simulation and store it as keyframe data.

### Baking Options

- **Overwrite Current Action**: If you enable the "Overwrite Current Action" option when baking, Blender will replace the current animation action with the baked animation. This means that the procedural or constraint-driven animation that existed before will be converted into keyframe data, and the original action (the one containing the procedural or constraint-driven keyframes) will be overwritten by this new set of keyframes that represent the baked animation.
    
- **Without Overwrite**: If you do not select "Overwrite Current Action," Blender will create a new action for the baked animation. This allows you to keep the original action untouched. You can switch between the original and baked actions in the Action Editor. This approach is safer if you might want to return to the original animation to make adjustments.


### Why Bake Animations

Baking animations in Blender can significantly enhance compatibility with other software, including game engines like Unreal Engine. The primary reason for this increased compatibility is that baked animations convert procedural animations, constraints, and simulations into a series of individual keyframes that describe the exact position, rotation, and scale of animated objects or bones at every frame. This process generates a straightforward animation that doesn't rely on Blender's specific features or constraints, making it more universally readable.