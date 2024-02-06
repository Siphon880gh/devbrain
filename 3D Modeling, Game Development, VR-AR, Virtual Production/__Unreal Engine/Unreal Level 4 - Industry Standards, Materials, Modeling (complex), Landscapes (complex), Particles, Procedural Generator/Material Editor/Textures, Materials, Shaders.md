
## Mesh vs Materials
  
In Unreal Engine, meshes have geometry, while textures are applied to materials. Materials are what define how the surface of a mesh should appear, including textures for things like color, roughness, normal maps, etc. So, textures are typically associated with materials, not directly with the mesh itself.

---

## Textures vs Materials vs Shaders

In Unreal Engine, the terms "shaders," "materials," and "textures" refer to different aspects of the visual rendering process:

1. **Textures**: These are images (like PNGs or JPGs) used to add detail to 3D models. They can represent various properties like color (albedo), roughness, metalness, normal (for surface details), and more. Textures are essentially the raw data used to give surfaces a realistic appearance.
    
2. **Materials**: Materials in Unreal Engine are more like a recipe that defines how a surface looks and responds to light. They are created using a node-based editor (REFER BELOW) and can include various textures, constants, and mathematical operations. Materials define properties like color, transparency, reflectivity, etc. They determine how textures are combined and manipulated to produce the final look of a surface.
    
3. **Shaders**: Shaders are the underlying programs that run on the GPU to render graphics. In Unreal Engine, when you create a material, it automatically compiles into a shader. Shaders are more complex and include the algorithms for how light interacts with surfaces, how textures are sampled and combined, and other visual effects. They are responsible for the actual rendering of materials and textures on 3D models.
    

In summary:

- **Textures** are the raw images.
- **Materials** are the combination and manipulation of textures and other properties.
- **Shaders** are the programs that render materials and textures on the 3D models.


