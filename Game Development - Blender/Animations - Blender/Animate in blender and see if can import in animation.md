
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


*-- TODO: TO BE CONTINUED --*