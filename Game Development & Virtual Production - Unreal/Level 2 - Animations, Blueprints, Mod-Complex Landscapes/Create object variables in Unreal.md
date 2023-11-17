Say you need to create variables that reference objects (eg. cameras) from your level. This would be dropped into your nodes, especially for targets.

For instance:

![](https://i.imgur.com/bUL6f98.png)

To create variables, make sure "My Blueprint" side panel is available. You can Window -> My Blueprints

At Variables, click the plus circular button. Name your variable in a meaningful way. Make sure the type (eg. in this case, cine camera...) matches the type of the object in the level. 

- Hint: You can visit the level designer's Outliner. You'll see the type on the right:
![](https://i.imgur.com/EAXKVnd.png)


Next, you have to match that variable to the object in the level. At the Details panel of that variable, under Default Value, you can select the object in your level. Only the objects of that type are available, so the key was to select the right type.
![](https://i.imgur.com/3e7Mm5n.png)

---


You're done! Now you can drag and drop from "My Blueprints" into the nodes, especially if you need to set a Target for nodes like "Stop (Animation)", Set Relative Location (Non actors), Set Actor Location (Actors only)


![](https://i.imgur.com/bUL6f98.png)


When dropping, select Get...
![](https://i.imgur.com/bhwTr4x.png)

Don't forget to link to your Target inlet, etc, whatever applies

