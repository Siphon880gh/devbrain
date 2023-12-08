You'll want to Place Actors -> Actor

That'll place an invisible object. Then you can drag and drop objects* attaching them to the invisible actor. 

![](https://i.imgur.com/z3qooG5.png)

And you convert that actor into a blueprint. ^Here the invisible actor was attached to 4 children and it became a blueprint actor.

Now any movement you program via blueprint event graph onto actor will be done to its children

---


\*Unable to attach because the types are not compatible?

Remember how you converted to Blueprint: 
![](https://i.imgur.com/ysxKxfB.png)

You can choose not to convert to Blueprint. Convert the new children into actor variations of themselves. See here I converted them to StaticMeshActor:
![](https://i.imgur.com/wL2rmt4.png)

Now they are compatible and can be attached to the actor. See Outliner:
![](https://i.imgur.com/IHiJ9Kt.png)

---

Still not moving? Refer to Details to make sure the object is not Static: [[Common Pitfall - I have the object or actor move from blueprint, but it doesnt move]]