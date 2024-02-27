
Make sure animations can play or you finish designing your animations. Refer to [[Animate in blender]]

## Make animation exportable

Switch the animation editing context to Action Editor

## Overview
You have to make animations friendly to other software like Unreal before you export with the model:
	- Animation time is a multiple of fps
	- Constraints and other data native to Blender cleaned out (This is Baking an animation)
	

## Set end of animation to a multiple of the fps

- Get fps by clicking object → Output Settings → Frame Rate
- Set the ending frame at the animation bottom panel → Dope Sheet → Action Editor → Open your animation asset at the center of the title bar. Then set the “End” number bottom right to the multiples of a fps. Do this for every animation asset (center of title bar)


![](https://i.imgur.com/32DWjGE.png)

![](https://i.imgur.com/No0xJtn.png)



![](https://i.imgur.com/bBam2q3.png)



FYI: The keyframe timeline is the Dopesheet. Dope was an old slang that stood for “data” or “information”. Before computers, animation was done on a sheet to track the timing of each frame, camera movements, dialogue, etc.



---

## (Help with the Action Editor)


You can see/manage all actions and save your changes at the center of the title bar for the animation Action Editor panel:

![](https://i.imgur.com/mc03L10.png)


![](https://i.imgur.com/khYIflv.png)


When setting the animation ending frame, it will become a whole number multiple of 30fps or 26fps, etc, whichever is your object's fps (at Output Settings)

![](https://i.imgur.com/Rw7SBqe.png)


---



## Bake the animations

Constraints and other data native to Blender cleaned out (This is Baking an animation), so that the animation is compatible with outside software like Unreal.

Make sure the animation you want to bake - you bake to decrease glitches in other software by removing all Blender constraints and data - is opened in the Action Editor.

At Animation module, at secondary menu go Object → Animation → Bake Action. Tick off “Only Selected Bones” and tick in “Clear Constraints” and “Overwrite Current Action”. Set Bake Data to Pose

![](https://i.imgur.com/adW0XIO.png)

![](https://i.imgur.com/TEJlM00.png)


---

## Export the model with the baked animations

Export as glTF or preferred format, but make sure baked animations are on at the bottom right.

---


## When importing into Unreal:


At Unreal when you import the model, make sure you import the animations and you import by animation time (not exported time). If you don’t match the times and fps correctly from the above steps, Unreal could fail to import animations in the output log stating mismatch between fps and length of animation.

![](https://i.imgur.com/ETIzjBP.png)
