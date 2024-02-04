## Sensitive to type of object

When you drop a model or object into the viewport editor and you want it to rotate or move or teleport, you have to pay attention to the type.

Depending on the type of object, you have to add the proper rotation or location node. Here are a couple but not an exhaustive list of variant nodes, and as you can see - the Target needs to match the type:

![](https://i.imgur.com/keNJwki.png)

![](https://i.imgur.com/tDu4cLU.png)


If the type match doesn't your object in the viewport, it just won't rotate/move/teleport/etc. There'd be no compile errors most the time.

## Static Mesh

See what you dropped from the Content Drawer - it says is a Static Mesh:

![](https://i.imgur.com/3T7o7Lo.png)

  

1. Place actor (yes it’ll be invisible)

![](https://i.imgur.com/SADe2jT.png)

2. Convert actor into Blueprint
3. In blueprint viewport add Scene CaptureComponentCube. Then add the static mesh there. You may have to assign the mesh in details.

![](https://i.imgur.com/sXEov5w.png)


If you look at the viewport editor, you'll see the static mesh now anchored to the actor:

![](https://i.imgur.com/8byIOVC.png)


Now the blueprint:
![](https://i.imgur.com/vBv6hr0.png)


In this example, we will rotate on z axis:
Timeline with float track from 0 to 5 seconds, 0 to 360. Make sure duration setting at the Timeline doesn't cut off the animation. Pipe the float track into Make Rotator's Z. Then Make Rotator can pipe return value to New Rotator parameter of "Set Relative Location and Rotation". Finally, the next execution is a Delay of 5 seconds (the complete animation duration) before replaying from start - this has to be done because Timeline and Setting Coordinates happen asynchronously. The static mesh target was drag and dropped from Components panel in blueprint event graph (Window -> Components)

---

## Skeletal Mesh Actor

Could be Quinn or Mannequin

![](https://i.imgur.com/a7kXGCp.png)

See from Content Drawer it's a Skeletal Mesh Actor:
![](https://i.imgur.com/06QvxOr.png)

Dont have to mess with the components. The set coordinate node can work with the parent class.

Here is the blueprint:
![](https://i.imgur.com/QxDhSwX.png)

In this example, we will rotate on z axis:
Timeline with float track from 0 to 5 seconds, 0 to 360. Make sure duration setting at the Timeline doesn't cut off the animation. Pipe the float track into Make Rotator's Z. Then Make Rotator can pipe return value to New Rotator parameter of "Set Actor Location". Finally, the next execution is a Delay of 5 seconds (the complete animation duration) before replaying from start - this has to be done because Timeline and Setting Coordinates happen asynchronously.