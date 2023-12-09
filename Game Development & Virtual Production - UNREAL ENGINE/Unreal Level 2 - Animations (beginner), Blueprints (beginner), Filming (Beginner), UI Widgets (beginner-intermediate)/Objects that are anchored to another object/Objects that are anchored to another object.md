Say you have a NPC moving around in the level. You want text to be above that NPC's head at all times.

Or say you want a collapsible invisible shape that follows the NPC, so if you are inside this invisible shape, certain nodes start running. You'd anchor the invisible shape to this moving object. And you'd follow the steps at [[Location based triggers]]

And technically when you grab a weapon, that weapon became anchored to your pawn.

---

You'll want to  drag and drop objects* attaching them to the  actor. 

![](https://i.imgur.com/z3qooG5.png)

And you convert that actor into a blueprint. ^Here the actor was attached to 4 children and it became a blueprint actor.

Now any movement you program via blueprint event graph onto actor will be done to its children

---


Troubleshooting - \*Unable to attach because the types are not compatible?

Remember how you converted to Blueprint: 
![](https://i.imgur.com/ysxKxfB.png)

You can choose not to convert to Blueprint. Convert the new children into actor variations of themselves. See here I converted them to StaticMeshActor:
![](https://i.imgur.com/wL2rmt4.png)

Now they are compatible and can be attached to the actor. See Outliner:
![](https://i.imgur.com/IHiJ9Kt.png)

---

Troubleshooting - \*Unable to attach because the static/dynamic (Tooltip that shows up error)?

The parent is dynamic movable type, so the child should be set to movable and not static

![](https://i.imgur.com/MLTgBVL.png)

Is also related to an object not moving regardless of blueprint programming the object to move (in that case, the object already exists and does not need to be reorganized in the outliner hierarchy): [[Common Pitfall - I have the object or actor move from blueprint, but it doesnt move]]