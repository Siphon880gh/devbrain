[https://www.youtube.com/watch?v=usZmddoDMak](https://www.youtube.com/watch?v=usZmddoDMak)  

## Background knowledge:

- Is it called tweening back when flash animations are done and you set the initial time in a X position with a final time in another X position? Yes
- The term "tweening" comes from "in-betweening." In traditional animation, it refers to the process of creating intermediate frames between two images to show the appearance of movement from the first image to the second. In the context of Flash animations (and other computer animation tools), tweening is the automated process of generating intermediate frames between two states to give the appearance of motion or transformation.
    
- There are two main types of tweens in Flash:
    
- **Motion Tweens:** This is where an object is moved from one place to another.
- **Shape Tweens:** This is where one shape morphs into another.
  
  This lesson concerns motion tweens

### Background knowledge - Spaces in x/y/z settings:
- When it comes to the distance of X/Y/Z, it’s by spaces. Using “First Player Template” as a reference, you will see multiple grid walls, each grid with smaller grids. When moved 20 spaces, that’s one small grid. When moved 100 spaces, that’s 1 large grid.


## Times One Movement (No Loop)
### 1. Necessary Prep in the Level Map

Drop a character into the level. Then drop an animation into that character (Search for walk or run in the Content Drawer)

### 2. Nodes

Edit the Blue Print of the character object -> Go to Events Graph
Create a timeline node. Then double click it to be at the Timeline editor

You will create a “Vector track” that lets you tweek X/Y/Z coordinates between time points.
- Suggestion: In the Viewport, you can adjust the location at the Outliner -> Details with a click and drag, then copy that value into the Timeline Vector as a second time point value.
- Suggestion: Lock Y and Z if you're only editing X, for example.
- You must have at least two time points. Use SHIFT+Click to create a new time point.


![](https://i.imgur.com/h8yhnAI.png)


Then you pipe out the update and the track (by default might be called "New Track 1")  into the primary inlet and the "New Location" inlet respectively. In addition, you have to pipe the object (Named something like Skeletal Mesh Component) into the "Target" inlet:

![](https://i.imgur.com/X3FJ5kk.png)

Now we need to pipe into a Delay node of X seconds duration, that then Stops the animation (targetting the character) by way of piping into a Stop (Animation type) node. This will stop the gaiting and arm swinging animation on the character

Reflect back:
Notice that the delay is necessary because the Set Relative Location node does not wait for completion of location update before running the next nodes. The next nodes run immediately. It is the Delay node's Completion outlet that functions as an on completion event that triggers the next node (Stop). So Set Relative Location and Delay runs at the same time.

![](https://i.imgur.com/hs01B9L.png)


In total:
![](https://i.imgur.com/liiWtCe.png)


  
[https://youtu.be/YajlbmK-Wso?t=112](https://youtu.be/YajlbmK-Wso?t=112)  
1:52

**Highlights**

- You edit a Blueprint Third Party Character, shape, etc. from Outliner panel. Then the Blueprint editor (looks like DaVinci Resolve Fusion Node editor).
- Must always hit Compile after node changes.
- You Shift+Click in the vector timeline to create time nodes for your tweening.
- The cube node in the video example is your character,etc (if character, it is the mesh).

- Set update outlet from Vector Track node to Play inlet of SetRelativeLocation node
- Set vector track (tweened track) of Timeline node to “New Location” inlet of SetRelativeLocation node

  
**Common pitfalls:**
Does your character appear lifted off the ground? The Y axis is not necessarily 0 because it depends on the map / level design. You have to click the map floor and look into the Outliner → Details → Transform → Location, to see what the Y value is. Then match it to the vector timeline. The Y value is the blue color.

  
---


## Looping

**Status**: Need to write this still.


2:10 Looping
[https://youtu.be/usZmddoDMak?t=131](https://youtu.be/usZmddoDMak?t=131)

Sneak Peak:
- You add a delay after set relative location because nodes after set relative location runs right away without waiting for the location update to finish.
- After delay, you add an if-else branch, except it's always true, and when true, the node progression loops back to Timeline.
