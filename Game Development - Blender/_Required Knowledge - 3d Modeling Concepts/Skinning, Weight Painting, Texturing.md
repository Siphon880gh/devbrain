
**Skinning** refers to the process of attaching a 3D model's mesh (the outer surface that defines its shape) to a skeletal structure (a rig). This process allows the mesh to deform or move according to the movements of the rig. When you skin a model, you are essentially defining how different parts of the mesh are influenced by different bones of the rig. The goal is to make the model move in a realistic or expected manner. In Blender, skinning has several steps:
	- Aligning bones with mesh
	- Parenting bones to mesh
	- Applying weights on the influence of bone to mesh
		- Automatic Weight
		- Weight Painting

**Weight Painting** is a method used within the skinning process to fine-tune how much influence each bone of the rig has on different parts of the mesh. This is typically visualized through colors—where one end of the spectrum (often red) indicates full influence (weight of 1.0) and the other end (often blue) indicates no influence (weight of 0). Weight painting allows animators and riggers to adjust these weights manually, ensuring that the deformations look natural. For example, ensuring that when a character bends their elbow, the skin deforms correctly without affecting the shoulder or wrist disproportionately.

Texturing involves applying 2D images (textures) to the 3D model to give it color, detail, and realism. This can include details such as skin tones, patterns, scars, or any other visual details that contribute to the character's final appearance.