

**Situation**:
Setting the pivot point of an object directly in Unreal Engine can be a bit tricky, as Unreal does not provide a straightforward way to permanently change the pivot of a static mesh within the editor itself. 

**Scope**:
This will just animate a door opening. You’ll have to add more nodes for triggering door open on collision or pressing a key on collision.

There are various methods to do so, but this tutorial will cover “Method 1: Using a Blueprint”. Other methods are at:
https://chat.openai.com/c/5c9fdef4-15ed-4319-9e13-7e59d10798a5

---


Using a Blueprint
Create a Blueprint: Create an Actor Blueprint for your door.
Add a Scene Component: (Will go into detail later)
Inside the Blueprint, first add a 'Scene Component'. This will act as your new pivot point.
Place the Scene Component where you want the pivot point of the door to be (typically on one of the edges for a door).
Add the Door Mesh:  (Will go into detail later)
Add the door mesh as a child of the Scene Component.
Adjust the door mesh position relative to the Scene Component to ensure it aligns correctly with where the door should be hinged.
Rotate Using the Scene Component:  (Will go into detail later)
When rotating the door, rotate the Scene Component. The door mesh, being a child, will rotate with the Scene Component, effectively using it as a new pivot point.

OR: Using QBridge:

1. First you need to have dropped a door into Unreal. See Qbridge for a nice wooden door
Make sure is extended into a BluePrint. If not, convert into Blueprint at sidepanel


----

## Going into details

**\* Add a Scene Component**:  

- With your Blueprint open, go to Viewport tab
- You'll see the Components panel on the top left side. If you don’t see the Components panel, you may have to enable it

![](https://i.imgur.com/jn7qaoY.png)

  

- Click on 'Add Component'.
- In the search bar, type “SceneCaptureComponent2D”.
- Select 'SceneCaptureComponent2D' from the list to add it to your Blueprint. This component will act as an invisible pivot point for your door. The invisible pivot point will have a child that’s basically your door superimposed.


![](https://i.imgur.com/yZ3mX2C.png)

  

3. **Position the Scene Component**:
    
- The Scene Component will initially be at the center of your Blueprint. Since you want it to act as a pivot for a door, you should position it where the hinges of a real door would be. Typically, this is along one of the vertical edges.
- You can move the Scene Component using the translation tool in the viewport.

5. **Add Your Door Mesh**:

- Click on 'Add Component' again.
- This time, add a 'Static Mesh' component. This will be your door.
- In the Details panel, assign your door mesh to this component.

![](https://i.imgur.com/oSWvHHa.png)
![](https://i.imgur.com/Og5krOg.png)

5. **Parent the Door Mesh to the Scene Component**:
    
- Drag your door mesh component onto the Scene Component in the Components panel. This makes the door mesh a child of the Scene Component (indented below).
- Now, any transformation applied to the Scene Component will affect the door mesh as well.

![](https://i.imgur.com/EWIeWH6.png)
6. **Adjust the Door Mesh Position**:

- Select the door mesh in the Components panel.
- Use the viewport to position the door mesh relative to the Scene Component so that it aligns as a real door would (because one door is superimposing the other door, you’ll only see one door), with the pivot point (Scene Component) at the hinge side.

![](https://i.imgur.com/QzZ4Ymx.png)

7. **Add Functionality**:
    
- Now, you can add functionality to your door, like rotating it when the player interacts with it. This is done using the Event Graph within the same Blueprint.

8. **Test Your Door**:

- Compile and save your Blueprint.

Remember, the Scene Component doesn't render anything in the game; it's just a point in space that you can use as a reference for transformations. In this case, it acts as the hinge point for your door.


---

## Adding functionality

### Variation 1: Door Opens with Lerping the Rotation (with Alpha Float Track to control animation steps)

Timeline Float 0 to 1 → Lerp → Set Relative Location (Scene Component)

![](https://i.imgur.com/GiqU6PJ.png)

  

### Variation 2: Door Opens with Primarily Tracks (Requiring manipulating keyframes for specific values)

![](https://i.imgur.com/KC2UK6u.png)

---

## Advanced - If you want the door to swing open or close when possessed pawn interacts with it:
https://youtu.be/dkeVrlRFJDk

^Highlight from above video:
![](https://i.imgur.com/uKZqcFC.png)

---

## ## Common Problems - The door opens but looks invisible on the backside

Enable double side. The designer made it only rendered on one side.

Instructions:
Double click the material, going into Material Editor, then go to Details. Enable Two-Sided

![](https://i.imgur.com/wVQS8UP.png)


---

## ## Common Pitfall - There’s another door underneath after door opens

You want to punch a hole in the original door. Unfortunately, you want to do this without the scene component and child mesh superimposed door. If you already done the above setup, you may want to duplicate the door/scene/door on the level, so you have two copies (the second copy will be for copying back later). In the original, you can delete the scene and door mesh (the one that’s a direct child of the scene component). Then when done punching a hole, you can paste back the components and blueprint nodes.

To review how to punch a hole in objects, refer to... Briefly, you had to have enabled Modeling Mode (Edit -> Plugin -> Modeling Tools (Both the mode and the editor)), then you select both the cube intersecting where you want the hole to be and the subject, then while in Modeling Mode (instead of Selection mode), going into Model → Boolean → Either: “Difference A-B” or “Difference B-A” → Accept

You may to rebuild all before hitting play
![](https://i.imgur.com/rNyZCMh.png)
