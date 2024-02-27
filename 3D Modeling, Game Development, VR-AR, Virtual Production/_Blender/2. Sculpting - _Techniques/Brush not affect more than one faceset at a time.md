
Face sets lets you in sculpting affect only that faceset and not other facesets. A faceset could be an obvious protrusion of the object and a body of mesh, eg. torso, each arm, each leg, head, each ear - could be all facesets

We can have Blender only let you affect one active faceset at a time so that what’s under your brush’s radius won’t be multiple facesets being affected. You can have blender visualize the facesets as uniquely random-colored parts

4:29 demonstration with and without:
[https://youtu.be/HEA-XUfawOI?t=268](https://youtu.be/HEA-XUfawOI?t=268)

  
1. You can have Blender automatically create face sets:
 Sculpting’s secondary menu Face Sets → Initialize Face Sheets → By Face Set Boundaries


2. Enable faceset colored overlays. Click the viewport overlay settings while in Sculpting mode -> Facesets. Make sure at a high opacity.
   
   ![](https://i.imgur.com/6nMTtti.png)

    
 See there are different colored faces:

![](https://i.imgur.com/qi8tEEp.png)

2. Now you set the tools’ brush to only affect the active faceset.
Viewport options: Brush → Face Set (under Advanced, Auto-Masking)

![](https://i.imgur.com/Uacds6J.png)


---

Example of why you want to isolate faceset for your brush


When using grab, you can affect all the vertexes under the paintbrush
![](https://i.imgur.com/0Y1FDGH.png)
