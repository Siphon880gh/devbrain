Example: Cat
Obligated: https://youtu.be/HEA-XUfawOI?si=VHRwUYgdWQODt3bU

Quickly create a cartoon model using duplicate, mirroring, modifier applying, and joining

Create a sphere, then resize it along Z axis (S → Z) to create a vertical oval.

Know there are two common ways to duplicate
Shift+D, Hold shift while dragging - Duplicate and move ortho-ly
Shift+D, Z or Y or Z, Hold shift while dragging - Duplicate and move in a locked-in axis

Duplicate and place the feet
![](https://i.imgur.com/cx7NfK7.png)

Enable mirroring

1. Add a “Mirror modifier” under modifier settings (wrench icon)

2. Eye dropper from Mirror Object is a click tool. Select the body of which the object will mirror over.

![](https://i.imgur.com/q4QfmOZ.png)

So whatever changes you make will automatically copy over

![](https://i.imgur.com/S5IFb8F.png)

## Note on mirroring at viewport mirror settings

The modifier mirror is similar to viewport’s mirror settings found at the top right:
![](https://i.imgur.com/ggekmX6.png)
Notice the “butterfly” icon - that’s where the mirror settings is. But that is global! With mirror modifier, it can be relative to a specific part of the object or another object.


---

## Applying modifiers

It’s like baking modifiers... This is necessary because once you join meshes together (torso, legs, arms, etc) there's a chance your mirror modifier could be undone. Explanation and how to apply modifiers: [[Apply Modifiers - Blender]]


---

## Remesh to higher polygon count to make limbs seamless with torso

Next refer to Remesh tutorial to make the edges between the cat parts (legs, etc) more seamless, so it appears more like an organically grown character than a modeled character with geometries jammed together. Hint: R for remesh, drag then click for a specific detail, CMD+R to commit to that remesh.