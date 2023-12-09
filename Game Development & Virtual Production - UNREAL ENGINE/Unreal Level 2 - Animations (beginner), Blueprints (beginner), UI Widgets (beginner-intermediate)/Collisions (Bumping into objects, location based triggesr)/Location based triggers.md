Briefly:
Think of them as collision overlap event between two objects and at least one object allows overlap

They must be set to generate overlap events in their details

---

A.

Create a cylinder or square where the user will walkthrough, at least by their feet. Resize as appropriate. Dont resize it so the player steps on the shape, but resize it so part of the player is inside the shape.

Make the shape walkthroughable by going to details for Collision presets -> Overlap all

MUST enable "Generate overlap events" in details.

Optionally (or you can do this once everything's finalized), make the shape invisible in the game by changing the materials to the invisible one (likely first material in the dropdown)

---

B.
Then you must make the second item that overlaps possible to generate overlap events. If your pawn is generated on game start, you can't select it in outliner to edit the settings. You can instead search for the blueprint in the content drawer, then Edit, then in the Blueprint viewport on the right is your details panel to find and tick on "Generate overlap events". If you need help finding the spawned pawn's class to search for on Content Browser, look into the World settings for what pawn class is generated from (Window->World Settings; Tab is next to Details).


----

C.
Make sure your objects are blueprints. Refer to [[Convert object into Blueprint - FUNDAMENTAL]]

You can select the overlapping area/shape and edit their blueprint, then the nodes are are simply:
![](https://i.imgur.com/N89oA75.png)

ActorBeginOverlap is one of the nodes that come included (like beginPlay) when you recently converted into a blueprint

---

Or--C:
Alternately, you could check two objects overlap while in another blueprint (so a blueprint that is neither of the two object's)

![](https://i.imgur.com/8T3CVPq.png)

^ Is Overlapping Actor's Target inputs: You use get actor of class to get the specific shape that overlaps. The other object is the player pawn
- But notice that Get Actor Of Class is an executive node so it must be connected in the flow of nodes.
- Its return value is either True or False and should be passed into a Branch that can run nodes depending on if overlapping or not.
