
Required knowledge:
- Know how to create variables. Refer to [[Create object variables in Unreal]]
- Animating character or object movement. Refer to [[Animate character or object movement, Times One, or Loop Alternately (5.3)]]
- Know how to convert an object into Blueprint. Refer to [[Fundamental - Convert object to Blueprint]]


Firstly you'll create a cinecamera actor (Placed Actors panel) into the level. You'll convert it into a Blueprint from the Outliner/Details panels

You'll animate the path using similar nodes to [[Animate character or object movement, Times One, or Loop Alternately (5.3)]]

![](https://i.imgur.com/pNn2MLi.png)

Except, when linking the vector track outlet and primary outlet from Timeline node into the next node, you'll be linking to Set Actor Location. This is because the camera object is a special classification Actor

*Optional Reading:*
For deep dive theory on why Set Actor Location for Actor Objects, why there are actor objects, versus non-actor objects which use Set Relative Position, refer to [[Deep Theory - Actor vs Non Actor and Their Location Nodes]]

----

Secondly, you have to switch camera for the player playing the level. If not, your perspective will be from the PlayerStart by default, and you would think the camera animation had failed:
![](https://i.imgur.com/ZbjT29b.png)

:(


From the beginning:
At the main blueprint button, open up the Level Blueprint
![](https://i.imgur.com/PMlRKwA.png)


This is the main Blueprint for your game level. Now you need to setup nodes such that the game begins, then the view of a player gets blended into the camera's view:

![](https://i.imgur.com/N0dmUH1.png)

Syntactically, this is a mediator where the Set View Target with Blend receives a player as input and receives the camera as a second input. Then as a mediator, it helps blend the Cine camera view into the player's view. Under the hood, the C++ could be following a Mediator Design Pattern. 

Don't forget BeginPlay's primary outlet links to "Set View Target with Blend"'s primary inlet

**Issue 1**: If you cannot find "Set View Target with Blend" when right clicking a blank area to create a node, tick off the "Context Sensitive" filter. See top right here:
![](https://i.imgur.com/ClEDm19.png)

**Issue 2:**
You may have problem getting a node that references the cine camera actor blueprint that's from your level.

You have two options
- you can split your windows / monitors, and drag the cinecamera actor blueprint object (if not blueprint, you convert it). You drag from the level designer's outliner into a blank area of the blueprint editor's event graph. This is finicky and unreliable in unreal, sometimes not creating the node when you release the mouse
- the other option is to create a variable to that cinecamera actor blueprint type, then it allows you to select the cinecamera actor blueprint that exists in your level. Refer to [[Create object variables in Unreal]]. Once the variable is created, you can drag and drop from the "My Blueprint side panel" into the events graph

![](https://i.imgur.com/bUL6f98.png)

When dropping, select Get...
![](https://i.imgur.com/bhwTr4x.png)