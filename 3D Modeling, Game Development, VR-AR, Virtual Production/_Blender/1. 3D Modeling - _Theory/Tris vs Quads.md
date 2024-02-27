
For the the rendering itself, everything is turned into tris. All quad topology does is make the topology easier to triangulate since if u divide a quad in half you get 2 triangles

But for modelling tools, modifiers, and deformation algorithms, quads are typically better. Quads can be subdivided unambiguously and lines can be drawn across them unambiguously also.

Some parts of mesh sometimes gets better deformation if u strategically mix triangles with quads (like joints in arms, legs, and fingers) because it keeps the volume of the mesh consistent when bent also less pinching artifacts.