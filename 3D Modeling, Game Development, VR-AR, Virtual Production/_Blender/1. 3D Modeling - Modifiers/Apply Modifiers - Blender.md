
## Applying modifiers

It’s like baking modifiers

Lets say the the legs on this cat model have been mirrored via a Mirror Modifier. Now you join the legs to the body by clicking the legs, then Shift clicking the body, then right click → Join. 

Oh no, the modifier disappears! That's because after joining them into a whole new model, the last joined is the one that passes the settings down (in this case, the torso that doesn't have Mirror Modifier).  Had you clicked the mesh without a modifier (torso), then clicked the mesh with the modifier (legs), then joined - then the mirror modifier carries over to the newly joined model.

Once you apply a modifier, its settings disappear from the object’s modifier settings; it’s become a permanent mesh for good or for bad.

![](https://i.imgur.com/huxQuh4.png)

--> becomes this after joining:


![](https://i.imgur.com/sGZhcRl.png)

Therefore you have to bake in the mirror modifier first (unless you prefer to figure out the correct order of clicking before joining). 

How to bake/apply the modifier: Under the leg’s modifier settings (wrench), you click down caret to apply over at Mirror:
![](https://i.imgur.com/hhaRKOA.png)

Now you can join leg to torso without the mirror modifier disappearing because the leg’s mirror modifier would be applied (aka baked in):
![](https://i.imgur.com/huxQuh4.png)
