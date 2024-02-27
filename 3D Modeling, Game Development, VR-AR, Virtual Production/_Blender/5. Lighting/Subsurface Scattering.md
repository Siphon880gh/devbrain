
Subsurface scattering (SSS) is a mechanism of light transport in which light penetrates the surface of a translucent object, is scattered by interacting with the material, and exits the surface at a different point. This effect is crucial for rendering materials like skin, wax, marble, milk, and other organic and inorganic substances realistically, as it accounts for the way light diffuses beneath their surfaces.

In Blender, subsurface scattering is a feature available in the material settings when using rendering engines like Cycles or Eevee. It allows artists to simulate this light behavior to achieve more lifelike textures and materials. By adjusting the subsurface scattering properties, you can control how light diffuses through the material, affecting its appearance in terms of softness, depth, and color.

Parameters typically include:

- **Subsurface**: Controls the amount of SSS effect; higher values result in more light being scattered beneath the surface.
- **Subsurface Radius**: Defines the distance light scatters beneath the surface, often with separate values for red, green, and blue light, allowing for chromatic dispersion effects.
- **Subsurface Color**: Determines the color of the light as it scatters through the material.
- **Scale**: Adjusts the overall scale of the subsurface scattering effect, useful for tuning the effect based on scene scale.

Using subsurface scattering can significantly enhance the realism of materials in 3D scenes, especially for organic subjects, by replicating the complex interactions between light and translucent materials.