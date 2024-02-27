
A modifier is not working as expected - seemingly out of sync with the object/model? 

Some modifiers, like the Mirror modifier, depend on the object's origin and its scale to function correctly. 
	- You want to set the 3d Cursor and object to 0,0,0 origin
	- Applying all transformations ensures that the object's scale is reset to 1,1,1, which is often necessary for modifiers to work as intended.

For example:  If an object has been scaled non-uniformly (e.g., more in one direction than another), it can cause the Mirror modifier to behave unexpectedly. 

---

**Set Origins**
1. Object Mode: Snap menu (Shift+S ) -> Cursor to World Origin
2. Object Mode: Select object -> Object Properties (at Properties panel) -> Set Location X, Y, Z to 0,0,0
3. Object Mode: Right click object -> Set Origin -> Geometry to 3D Cursor


**Apply All Transformations:**
1. Object Mode: Select Object (A to select all) -> Apply menu (CTRL+A) -> All Transformations

---

In Blender, applying all transformations (using the shortcut Ctrl+A and then selecting "All Transformations") is a crucial step for several reasons, especially in modeling, animation, and when preparing your models for export. Here’s a detailed breakdown of its purpose and effects:

1. **Resets Object Transforms**: When you apply all transformations, Blender resets the object's location, rotation, and scale to their defaults (location to 0,0,0; rotation to 0°; scale to 1,1,1) without changing the object's apparent position, orientation, or size in the 3D viewport. This means the object's current state becomes its new default state.

2. **Improves Rigging and Animation**: Applying transformations is critical when rigging and animating. If an object's scale is not applied (set to 1,1,1), it can cause issues with how the object deforms when rigged with bones. Non-uniform or unapplied scales can lead to unexpected behavior during animation, such as skewed deformations.

3. **Facilitates Model Export**: When exporting models to other software or game engines, applying transformations ensures that the object behaves as expected in the target application. Unapplied transformations can result in objects appearing at incorrect scales or orientations when imported into other software.

4. **Enhances Precision and Consistency**: By applying transformations, you ensure that the object's scale is consistent, which is particularly important for precision modeling and when objects need to interact or fit together in a scene. It helps in maintaining consistency across different objects in your project.

5. **Avoids Non-Uniform Scale Issues**: Applying scale is particularly important because non-uniform scaling (scaling differently in different axes) can cause issues with modifiers, physics simulations, and other Blender features. It ensures that any operations or simulations that follow behave correctly.

To apply all transformations:
- Select the object(s) you want to apply the transformations to.
- Press `Ctrl+A` to open the apply menu.
- Choose "All Transformations" from the list. This applies the object's location, rotation, and scale, effectively "zeroing out" these properties while keeping the object's appearance and placement in the scene unchanged.

Remember, applying transformations is a non-reversible action that resets the object's transformation data. Always ensure you're ready to commit these changes before applying them.