When you have a model imported in that needs animations - you can copy off mannequin or quin’s animations.

The problem is the bone/skeleton might not match exactly between the two character. Unreal Engine has a retargeting system that allows you to conform some bones/joints of one character to the other character even if they’re in different proportions or different poses (I pose vs T pose vs A pose)

Requirement: Both models must have bones. If your imported model does not have bones, you have to add bones/armature in Blender, aka Rigging. If you need to do so, refer to Blender tutorial on rigging.

For more information on retargetting:
- Refer to [[Retarget copying one character's animation to another character - CONCEPT ONLY]]
- And refer to [[Retarget copying one character's animation to another character - GET STARTED]]