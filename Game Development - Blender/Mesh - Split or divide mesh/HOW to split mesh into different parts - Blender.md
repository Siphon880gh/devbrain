
## Method Collection

The direct-to-the-point, no hand-holding:
https://www.youtube.com/watch?v=yFy0kiAIUXQ

---

## Method 1 - Cut by drawing

Draw a line then slice:
https://www.youtube.com/watch?v=PfIQxnRXNSo
![](https://i.imgur.com/9osNeL6.png)

Status: Tested partially only. Didn't have time to finish project.
1. Select the vertexes with a paintbrush method (Edit Mode, Tool: Select Circle, Click and drag. You may need to rotate camera in object mode to get all vertexes from lateral and posterior views. You'll want to SHIFT + Click drag to add additional paint-selects)
2. Bisect tool (may be hidden under Knife tool. Hover mouse over tool icons for name, click and hold to reveal more tools hidden under a tool). Click and drag where the object will be cut. 
	1. ^ Bisect tool's purpose is to filter in the selected vertexes within the plane and filter out those vertexes that fall out of the plane, lowering the number of selected vertexes to the relevant vertexes (which you will cut)
3. You will cut: Keep mouse near bisect line. Cut now by pressing V, then without moving the mouse, right click x1 (V is actually ripping and allows you to tear the vertexes with the mouse, so by right-clicking immediately without moving the mouse, you cut in place because you've confirmed the rip)
4. At secondary menu: Select -> Select Loops -> Select Loops Inner-Region
5. Press P for "Separate Menu", and separate by Selection
6. Go into Object Mode, and you'll see the other object that's been cut out can be translated/moved with g then x, then drag. You'll see that the object might be opened where it was separated which is not good for 3d printing, so if you choose so, you can fill the opening by pressing P

Curious why ripping allows you to move your mouse before finalizing with right-click:
- When you rip a vertex or a group of vertices, what you're doing is essentially creating a duplicate of the selected vertices and then moving them apart from their original position. This creates a gap in the mesh
- The ripped vertices exist as part of the mesh but are no longer part of the continuous surface of the original mesh. They have their own separate edges and faces, which can be manipulated independently of the original vertices from which they were ripped.
- Yes, the angle at which you rip before finalizing with a right-click can affect the appearance of the edge of the separated mesh in Blender. The angle and direction of the rip influence the resulting geometry, more noticeable in models where edge flow and topology are important.
- Technically after ripping, you should be able to select these "floating vertices", unless you 'Limit Selection to Visible' (also known as 'occlude background geometry').

---

## Method 2 - Cut by plane


Status: Tested partially only. Didn't have time to finish project.

Draw a plane, then fold the line with "loop cuts" (Think Chinese fan)
https://youtu.be/moPDPB4MY2U
![](https://i.imgur.com/zIc9B9U.png)



Make sure you have the "Object: Bool Tool" plugin enabled under Edit->Preferences->Add-ons. If you check its shortcuts, keep in mind that Bool Difference is Ctrl + Shift + Numpad Minus. If you just installed now, you have to restart Blender even if it didn't ask you to (else the cutting by Boolean Difference shortcut won't work).

You want to move the 3D cursor to where the plane that cuts your model will be placed. You SHIFT+Right click to move the 3D cursor to middle of where you will cut
![](https://i.imgur.com/2fST8na.png)


Then you Shift+A -> Mesh -> Plane to create a plane at the selector cursor.
^ Background: Shift+A is the "Add" menu

Press R then click and drag to rotate the plane into desired position, if necessary.

In this particular example, we dont want a straight cut. We can use loop cut tool to add foldable lines along the plane, then reshape the plane so it follows the seams of the jacket.

![](https://i.imgur.com/aHLw06Y.png)

Switch to Edit Mode. Then click Loop Cut tool
![](https://i.imgur.com/vYZgO0M.png)

![](https://i.imgur.com/96OdLFt.png)


Now you can move your mouse and it'll automatically predict your cut, and you click to commit the cut. I am using another model here for example because it's easier to see. The yellow line is the predicted line; The orange line has been cut:
![](https://i.imgur.com/HNLrFT7.png)

Now make it possible to select a loop cut that lets you fold the plane:
**Selection mode with edge selection**
![](https://i.imgur.com/sl9G80f.png)
^ Notice we went back to Select Tool (away from Loop Cut tool) and the selection mode is Edge mode (not vertex or face). See the mouse cursor icon is highlighted blue, and the second icon to the right of "Edit Mode" dropdown is highlighted.

With a line selected, we can start contorting the plane by pressing **g then x**. G stands for grab/move. X means X-axis. If it doesn't let you contort the plane in the direction you want, try **g then y** or **g then z**

![](https://i.imgur.com/G9pCuy9.png)

Before we separate, another problem! The plane is 1 dimensional. We need to make it thicker
Select the plane in the Outliner -> Add Modifier. 
Depending on your Blender version, looks different:
![](https://i.imgur.com/TnaNfpD.png)

![](https://i.imgur.com/IkHfdB1.png)


Add a **Solidify modifier**.

Then slide the "Thickness" appropriately (greater than 1 dimensional), so maybe 0.01m


In **Object Mode**, select your **Plane + Model**
**Shift+CTRL+Numpad Minus**
This only works if you had the "Object: Bool Tool" plugin enabled under Edit->Preferences->Add-ons

The plane of mesh should disappear and if you zoom in, you can see a cut. You've just done a Bool Difference (Where two meshes collide, the overlap will have mesh deleted)

Lets separate by loose parts:
Make sure in **Edit Mode**. 
**CMD+A** to select all vertexes. 
**Press P** to open Separate menu -> By Loose Parts

Now you have separated mesh. To prove this, you can go into Object Mode, select the arm/foot/whatever you've cut loose. Then press **g then x** and drag away.

----

Easily select the two parts? Then separate them by selection
![](https://i.imgur.com/YFCOJ0s.png)


Edit Mode -> Select Box ->
Make sure to rotate around the cube that all vertexes are selected
![](https://i.imgur.com/u2SyZ4j.png)

Press p for Separate Menu -> Selection

Now go back into Object mode and select a part. Make sure it doesn't select both parts. 
For a comprehensive test, select the other part too. If the other part makes both highlighted, you have to repeat the above steps selecting and separating in Edit Mode.

![](https://i.imgur.com/F2fXVJj.png)
