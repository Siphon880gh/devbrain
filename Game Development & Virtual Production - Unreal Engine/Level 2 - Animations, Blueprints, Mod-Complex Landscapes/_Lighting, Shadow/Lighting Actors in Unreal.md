
Learning from: https://youtu.be/fSbBsXbjxPo
**Left off at**: https://youtu.be/fSbBsXbjxPo?t=511

---

Additional learning - Skylight: https://www.youtube.com/watch?v=BGoaPyfZlYg
Additional learning - Bake Lighting (Static and Stationary Lights): https://www.youtube.com/watch?v=hq1WFFF6iD0
Additional learning - Nanites explained: https://www.youtube.com/watch?v=P65cADzsP8Q

Next topics:
Chrome ball
Albedo (the higher, the more it'll reflect light) (a material ball will show as white with high albedo)
+Albedo. The Albedo map is **the base color input that defines the diffuse color or reflectivity of the surface**. This is very similar to a diffuse map but is more the pure color of an object, while diffuse is both color as well as shaded with some diffuse lighting
+Texture Maps: https://www.vntana.com/blog/what-are-texture-maps-and-why-do-they-matter-for-3d-fashion/#:~:text=Refraction-,Albedo,shaded%20with%20some%20diffuse%20lighting.
-
+Indirect lighting is how much light bounces off wall. You can control that light's indirect lighting bouncing off walls and materials 18:06. Select your light actor in outliner and set the Details: increase intensity. Or set the Details: Indirect Lighting intensity. Or affect the wall / subject.... (next)
+A wall's base color V (HSV - Hue, Saturation, **Value**) setting controls how much indirect light bounces off. You're controlling how bright that wall is. In real life, a brighter color will reflect back more light
![](https://i.imgur.com/XdKBYou.png)

+Can have emmisive materials which is self-glowing. In Blueprint, you pipe Light intensity U light color --> Multiply --> Emmissive
+Lumen works better with Nanite meshes for performance. Convert as many meshes into Nanites as possible (Content Browser -> Right click the "Static Mesh" -> Nanites -> Enabled)
-
Lighting lecture

----

### Actors

Windows -> Place Actors
Then drag and drop from "Place Actors" panel. Select light tab.
![](https://i.imgur.com/w0QFiLD.png)




----


## All Lights

### Light Options

Can adjust at Outliner's Details Subpanel:
- Intensity
- Light Color
- Temperature (Warm hues, Cool hues)

Mobility: Static, Stationary, Movable
Movable is best for beginners (Some lighting doesn't look right elsewise. The other light mobility have nuances that compromises lighting for performance)

> [!note] Light Mobility
> There are three types of lighting mobility: Static, Stationary, and Movable. Each type has its own characteristics and use cases, particularly in terms of performance and realism.
>
>
> I. Grouping A
> 1. **Static Lighting**:
>     
>     - **Description**: Static lights are lights that do not move or change during gameplay. Their lighting effects are precomputed and "baked" into lightmaps during the level's design phase.
>     - **Use Cases**: Ideal for environments where lighting conditions do not change, like static architecture or landscapes.
>     - **Performance**: Offers the best performance since the lighting calculations are done in advance and don't need to be recalculated in real-time.
>     - **Limitations**: Cannot be used for dynamic objects or scenes where lighting conditions change, such as day/night cycles.
> 2. **Stationary Lighting**:
>     
>     - **Description**: Stationary lights are a hybrid between Static and Movable lights. They can cast both baked (static) and dynamic (movable) shadows. The direct lighting is baked into lightmaps, but the shadows from moving objects are rendered in real-time.
>     - **Use Cases**: Useful in scenes where the main light source (like the sun) is stationary but you still have dynamic objects that need to cast real-time shadows.
>     - **Performance**: More resource-intensive than Static lights but less so than Movable lights. They provide a good balance between visual quality and performance.
>     - **Limitations**: There's a limit to the number of overlapping Stationary lights in a scene due to the complexity of combining baked and dynamic lighting.
> 3. **Movable Lighting**:
>     
>     - **Description**: Movable lights are fully dynamic and can change position, intensity, color, etc., during gameplay. All their lighting calculations, including shadows, are done in real-time.
>     - **Use Cases**: Essential for dynamic scenes, such as those with changing time of day, moving vehicles with headlights, or any scenario where light sources need to move or change.
>     - **Performance**: The most resource-intensive type of lighting. Real-time calculations can be demanding on hardware, especially in complex scenes with multiple light sources.
>     - **Limitations**: While they offer the most flexibility, their impact on performance can be significant, making them less suitable for large scenes or lower-end hardware.
>
> II. Grouping B
> - Bake Lighting: Static and Stationary Lights
> - Dynamic Lighting: Movable Lighting
>


---


## Directional Light

Directional Light: Behaves like a sun/moon light that's directional
For exterior environment. Or for interior environment with sunlight shining through a window

If lumen were disabled, it would be all black
![](https://i.imgur.com/uiNFkEI.png)

So make sure it's been enabled. Refer to [[Setup Unreal for Lighting Projects]]. Then it's more useable like this:
![](https://i.imgur.com/f8awbtR.png)


---


## Point Light

A point that emits light in all directions.
Like a light bulb


---

## Spot Light

Conical pattern of light
Like a stage's spot lights
![](https://i.imgur.com/5cCS1vu.png)

Control the shape of the light at "Outer Cone Angle"
![](https://i.imgur.com/pU2mBKx.png)

---

## Rect light (aka rectangle light)
Official definition: Rect Light emits light into the scene from a rectangular plane with a defined width and height**

Like soft box used in photography

Gives soft shadow because of the large light source.

Because of the soft shadow, great for portrait, cinematic work

Adjust shadow hardness / softness (defined edges) by resizing the rect light.

Place a reflective chrome ball to see the rect box actual size in the reflection as you resize "Source Width"

![](https://i.imgur.com/yzY9IRq.png)


![](https://i.imgur.com/6B7Coqz.png)
