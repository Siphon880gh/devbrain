[https://www.youtube.com/watch?v=usZmddoDMak](https://www.youtube.com/watch?v=usZmddoDMak)  

Background knowledge:

- Is it called tweening back when flash animations are done and you set the initial time in a X position with a final time in another X position? Yes
- The term "tweening" comes from "in-betweening." In traditional animation, it refers to the process of creating intermediate frames between two images to show the appearance of movement from the first image to the second. In the context of Flash animations (and other computer animation tools), tweening is the automated process of generating intermediate frames between two states to give the appearance of motion or transformation.
    
- There are two main types of tweens in Flash:
    
- **Motion Tweens:** This is where an object is moved from one place to another.
- **Shape Tweens:** This is where one shape morphs into another.

You will be creating nodes that affect the event, if/then, input transformation, and subject. In the middle, you will create a “Vector track” that lets you tweek X/Y/Z coordinates between time points.


When it comes to the distance of X/Y/Z, it’s by spaces. Using “First Player Template” as a reference, you will see multiple grid walls, each grid with smaller grids. When moved 20 spaces, that’s one small grid. When moved 100 spaces, that’s 1 large grid.

![](https://i.imgur.com/h8yhnAI.png)


  

Highlights

- You edit a Blueprint Third Party Character, shape, etc. from Outliner panel. Then the Blueprint editor (looks like DaVinci Resolve Fusion Node editor).
- Must always hit Compile after node changes.
- You Shift+Click in the vector timeline to create time nodes for your tweening.
- The cube node in the video example is your character,etc (if character, it is the mesh).

- Set update outlet from Vector Track node to Play inlet of SetRelativeLocation node
- Set vector track (tweened track) of Timeline node to “New Location” inlet of SetRelativeLocation node

  

Does your character appear lifted off the ground? The Y axis is not necessarily 0 because it depends on the map / level design. You have to click the map floor and look into the Outliner → Details → Transform → Location, to see what the Y value is. Then match it to the vector timeline. The Y value is the blue color.

  

  

2:10 Looping (to be completed)

[https://youtu.be/usZmddoDMak?t=131](https://youtu.be/usZmddoDMak?t=131)