
Initially adds more faces without affecting initially shape. Afterwards you can use the new edges to separate clean cut shapes (or transform vertexes/edges to change the shape).

Cutting into separate shapes: Select that cut’s vertexes/edges and all the vertexes on that side of the cut. You can transform this cut then transform so it’s visually separated. If you want them to be distinctively selectable objects, then separate by selection (Press P → Separate by...) (or Right-click → Separate → Separate by...)

Here's a comparison between the tools:

| Feature         | Knife Tool                                         | Bisect Tool                                       | Loop Cut Tool                                      |
|-----------------|----------------------------------------------------|---------------------------------------------------|----------------------------------------------------|
| **Description**   | Allows precise cuts across faces, creating new edges and vertices. | Slices through a mesh with a straight line, creating new edges and vertices. | Adds loops of new edges along existing geometry, creating a flow of new vertices and edges. |
| **Control**       | High freedom of control. Users can make freehand cuts in any shape or direction. | Moderate freedom of control. The cut is a straight line defined by two points. | High control over the placement of the loop cut but constrained to existing geometry. |
| **Precision**     | Can be very precise, depending on the user’s hand. Offers options like snapping to vertices for more accuracy. | Precise in terms of creating straight, clean cuts. Less versatile than the Knife tool for complex shapes. | Precise in adding evenly spaced edges along the loop, with options to adjust the number and spacing of cuts. |
| **Usage**         | Ideal for detailed modeling tasks where specific cuts are needed. | Best for making clean, straight divisions or for cutting off parts of a mesh. | Perfect for adding detail or adjusting the topology of a model by inserting new edge loops. |
| **Options**       | - Cut through entire model (Toggle with 'Z')<br>- Constrain cuts to 45-degree angles (Toggle with 'C') | - Fill the cut with new faces<br>- Flip the direction of the cut | - Adjust the number of cuts<br>- Slide the loop cut before finalizing its position |
| **Activation**    | Press 'K' in Edit Mode.                            | Found in the Tool Shelf under Edit Mode or through the search menu (F3). | Press Ctrl+R in Edit Mode, then use the mouse wheel to adjust the number of cuts. |


---


For knife, press enter to commit (since clicking is taken, and Blender doesn’t take the same cue from photoshop about closing a loop would be a commit). More details on how to use knife: [[Knife]]