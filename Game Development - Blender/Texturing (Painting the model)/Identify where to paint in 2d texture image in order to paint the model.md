
Figuring out where to draw into texture image from the model. Several approaches:

  

**By selecting vertexes in viewport, you can see their corresponding areas in the texture image map**

- Go into Edit Mode. Open the UV Editing module. This will cause a split screen between the default viewport and the UV Editing screen.
- At the viewport, either select all vertexes by pressing A, or select only the relevant vertexes where you want to match the object’s part to the texture image’s part
- At the UV Editing module, whatever vertexes is selected in Edit Mode will highlights dots on the UV Editing module.

![](https://i.imgur.com/G5ZwQC2.png)

- Or if there is a lack of texture images (starting from scratching?), go to Image → New to create a blank canva. The blank canva will still have highlighted dots corresponding to your vertex selection at the viewport.
- Navigation tip: You may want to View →  Frame All (canva in view with some breathing room around canva) , or View → Frame All Fit (Maximize canva to screen).
- Navigation tip: + or - while UV Editing module in focus to resize and zoom on the canva

**When dealing with mesh that’s divided into parts (can have material slots)**

- You can divide the object into parts so each can have their own material/texture image. Refer to: [[HOW to split mesh into different parts - Blender]]

- If you want to select a part or material slot and have its relevant areas on the image map highlighted in the UV Editing module (This works because you’re selecting all vertexes of the mesh part in the viewport via the material properties, then therefore the UV Editing texture image will highlight the respectively points)

![](https://i.imgur.com/Pa7kE3n.png)

- If your model has many divided meshes but the entire model looks the same color  (your model looks all gray, for example), you can add Background Color to an interested part. For example, here I made a part of the body all red (Material Properties → Surface → Base Color → RGB Curves – under Color). Make sure to also name the parts appropriately (in this example, some parts are only identified by numbers, which isn’t helpful, so I’m also going to rename them after I identify what part they are based on background color) (You rename by double clicking the name):

![](https://i.imgur.com/iQfitFz.png)

![](https://i.imgur.com/2YmMiSZ.png)
