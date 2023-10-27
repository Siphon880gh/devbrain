Environment (level design or virtual production)
Blueprint (akin to DaVinci Fusion nodes)
Vector track (akin to tweening position in space)
Level / Level (akin to gaming map. Used intertchangeably in the editor)
Textures on third person character (akin to NPC skin)
Foliage

Behavioral Tree
Blueprint
Events Graph
View Port


----


A Behavior Tree is a technique used in game AI programming to create intelligent and realistic NPC behaviors. Here are some key points about Behavior Trees:

- It is a tree-like structure that contains different nodes representing high-level behaviors, composite tasks and atomic actions.

- The nodes are arranged hierarchically into a flowchart-like structure that defines the AI decision making logic.

- Leaf nodes represent simple atomic tasks like playing an animation. Composite nodes define sequencing, selection and parallel execution of child nodes.

- Common composite nodes include Sequence (do nodes sequentially), Selector (try each child until one succeeds), Simple Parallel (do nodes in parallel) etc.

- The tree is traversed from the root node as the AI makes decisions each tick, running behaviors based on game state.

- Key advantages are easy to visualize logic, clean separation between behavior design and implementation, and modularity.

- Behavior trees allow designers to rapidly prototype and iterate on AI behaviors by adjusting the tree structure visually.

- It avoids complex scripted behaviors or finite state machines that can get unwieldy in large games.

- Behavior trees shine for human-like AI but can control any type of NPC behavior from robot drones to organic creatures.

In summary, a Behavior Tree provides a modular, scalable and intuitive way to define complex AI behaviors in games by structuring them into a hierarchical flowchart-like structure. This facilitates rapid iteration and complex decision making.

----

A mesh in Unreal Engine refers to a 3D model that is composed of vertices, edges and faces that define the surface of an object. The key things to know about meshes in Unreal 5.3 are:

- Meshes are one of the main primitive object types used in building 3D scenes, along with spline, terrain, foliage etc. 

- They consist of a collection of vertices (points in 3D space), edges connecting those vertices, and polygon faces defined by those vertices and edges.

- The mesh defines the visual surface of a 3D object, while the collision model defines its physical surface for simulations and gameplay interactions.

- Meshes can be created and imported into Unreal in various 3D modeling programs like Blender, Maya, 3ds Max etc. 

- In Unreal, static meshes are used for static geometry like architecture and environment assets, while skeletal meshes are used for characters made of bone & skeletal structures.

- Meshes can have materials and textures applied to define their look and shading. The Material Editor is used to create materials that reference textures.

- Level of detail (LOD) meshes can be used to optimize performance by swapping higher/lower detail meshes based on distance from camera.

- Mesh properties like vertices, UVs, normals etc can be accessed and modified in the Unreal Editor for advanced use cases.

So in summary, a mesh is the 3D geometric surface that gives an object its visual form in Unreal, and serves as the basis for rendering, collisions and other systems.



The main differences between materials and textures in Unreal Engine are:

- Material - Defines the visual properties and shading of a surface. Materials reference one or more textures and combine them with shading models, values and node networks to create a certain look.

- Texture - A bitmap image file that provides color/pixel information for a material. Textures are mapped and wrapped onto surfaces based on UV coordinates.

In more detail:

- Materials control how a surface looks, including properties like color, roughness, reflectivity, opacity etc. Textures provide the color/image data that gives surfaces detail.

- You can have multiple textures feeding into one material. For example, a diffuse color texture, a normal map, a roughness map etc can all be combined in a complex material.

- Materials use shading models like Lambert, Phong, Blinn, Oren-Nayar etc to determine lighting behavior. The shading model is part of the material, not textures.

- Materials can use nodes to create complex shader networks mixing different textures, values and logic. Textures are simple image inputs into these networks.

- Many materials don't require textures at all. Constants can be used for color/values rather than texture maps.

So in summary, textures provide image data for detail, while materials take textures as inputs and use shading models, nodes and values to determine final surface appearance in a rendered scene. Materials dictate look, textures feed in image data.

