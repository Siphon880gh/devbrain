

\<<
I was moving a character across the map and having a camera follow behind the character.

My character I imported uses a Set Relative Location, but my camera (which I noticed its name is an actor - CineCameraActor) uses Set Actor Location

Why this difference?

\>>
Yes, your imported character can be moved using `Set Relative Location` instead of `Set Actor Location`, and this is primarily due to the way characters are structured within Unreal Engine. Here’s a deeper look into why `Set Relative Location` is often more appropriate for characters:

1. **Character Structure and Hierarchy**:
   - **Hierarchical Nature**: Characters in Unreal Engine are typically part of a hierarchy. A character usually consists of a main Actor (often a Pawn or Character class) and several components attached to it, like a skeletal mesh, animations, cameras, and so on.
   - **Component-Based Movement**: When you move a character using `Set Relative Location`, you're usually adjusting the position of one of these components relative to the character's root. This is useful for animating or repositioning parts of the character without moving the entire character in the world.

2. **Why `Set Relative Location` Works for Characters**:
   - **Local vs. World Space**: `Set Relative Location` adjusts an object's position relative to its parent, not in the absolute world space. For a character, moving a component like a mesh or a camera relative to the character's root is often more relevant than moving the entire character.
   - **Animation and Movement Systems**: Characters often have complex animation and movement systems that handle their positioning in the world. These systems might work with relative positions rather than absolute world positions.

3. **Difference with `Set Actor Location`**:
   - **Global Positioning**: `Set Actor Location` moves the entire actor in the world space. It's suitable for objects that aren't part of a larger hierarchy or when you need to reposition the entire entity, like a `CineCameraActor`, which is typically a standalone actor.
   - **Less Common for Character Components**: Using `Set Actor Location` on a character can disrupt its hierarchy or its built-in movement and animation systems, as it repositions the character's root in the world space.

In summary, using `Set Relative Location` for your imported character is appropriate because it allows for movement relative to the character's own coordinate system, which is often more aligned with how characters are animated and moved in Unreal Engine. This approach respects the hierarchical structure of characters, making it more suitable for nuanced adjustments and animations within the character's framework.