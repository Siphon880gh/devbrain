
## What are modifiers?

Modifiers in Blender are tools that allow you to automatically perform complex operations on mesh objects, curves, texts, and other object types. They are used to non-destructively transform, deform, and modify the geometry or appearance of an object in various ways. Here's a brief overview:

1. **Non-Destructive Nature**: Modifiers are non-destructive, meaning they can be applied to an object without permanently altering the original geometry. You can adjust, reorder, disable, or remove modifiers at any point without permanently changing the object.
   
   In the outliner, after adding a modifier to make a wall thicker (mesh plane aka wall, solidify aka thicken):
   ![](https://i.imgur.com/mc3yM7c.png)
^This means I can toggle the modifier off or remove it, reverting the wall / mesh plane back to its default 1 pixel thinness.

2. **Types of Modifiers**:
   - **Generate Modifiers**: These add geometry to an object, like Array (creates copies of the object in an array), Mirror (mirrors the object across an axis), or Subdivision Surface (smooths the object by subdividing its faces).
   - **Modify Modifiers**: These change existing geometry in some way without adding new geometry, like Boolean (combines two objects in various ways), Edge Split, or Decimate (reduces the polygon count).
   - **Deform Modifiers**: These deform an object's shape, like Armature (for skeletal animation), Bend, Lattice, Simple Deform, or Wave.
   - **Simulate Modifiers**: These are used for simulation effects like Cloth, Fluid, Soft Body, or Particles.

3. **Stacking Modifiers**: You can apply multiple modifiers to a single object. The order of these modifiers in the stack is important, as it determines the order in which the operations are applied to the object.

4. **Animation and Modifiers**: Modifiers can be animated over time, allowing for complex effects. For example, you can animate the strength of a Displace modifier to create a waving effect.

5. **Common Uses**: Modifiers are used for a wide range of purposes, from simple tasks like creating symmetrical models with the Mirror modifier, to complex animations and simulations with the Cloth or Particle system modifiers.

6. **Performance Considerations**: While powerful, modifiers can also be computationally intensive, especially when used in large numbers or with high complexity. This can impact the performance and responsiveness of Blender, particularly on less powerful hardware.

Overall, modifiers are a central part of 3D modeling and animation in Blender, providing a flexible and powerful way to create and animate complex models and effects.


----

## Example: Making a wall thicker

Here I have a wall that's very thin. Im going to thicken it with the Solidify modifier. (The wall is made of a plane mesh)

Select the plane in the Outliner -> Add Modifier. 
Depending on your Blender version, looks different:
![](https://i.imgur.com/TnaNfpD.png)

![](https://i.imgur.com/IkHfdB1.png)


Add a **Solidify modifier**.

Then slide the "Thickness" appropriately to achieve the wall thickness you want.

---

## Example with alternate method (Not Modifier)

Alternately, to make a wall thicker, we could have simply pressed **s then x** or whatever plane the wall needs to rescale towards. Then drag and commit the new size.

But this would be destructive, meaning the only way to make the wall thin again is to resize it or undo it. Whereas if you had the resizing done using Solidify, you can delete or toggle off the modifier in the Outliner.