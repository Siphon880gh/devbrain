You can change which camera at the start if you do not want your perspective from the PlayerStart by default, or the camera following the character (if third person template, etc):
![](https://i.imgur.com/ZbjT29b.png)


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