
## Shadow Elongation

The elongation of shadows is primarily influenced by the angle and position of the light source relative to the object casting the shadow. When the light source is low or at an angle, shadows tend to be longer. When it's directly above or very close to the object, shadows are shorter.

If you want to elongate the shadow of an object in Unreal Engine, you would typically move the light source or change its angle relative to the object.

---

## Shadow Hardness / Softness

Larger Light Source: A larger light source relative to the subject tends to produce softer shadows. This is because the light rays come from different angles, filling in shadows and reducing the contrast between light and dark areas. The edges of the shadows become less defined and more gradual.

Smaller Light Source: Conversely, a smaller light source relative to the subject creates harder, more defined shadows. This happens because the light rays are more parallel and concentrated, leading to a clear distinction between the lit and unlit areas. The edges of the shadows are sharp and well-defined.

In Unreal Engine, this principle applies when you're setting up lighting for a scene. Adjusting the size of light sources like Rect Lights, Point Lights, or Spotlights will affect the softness or hardness of the shadows they cast. For instance, enlarging a Rect Light will generally result in softer shadows, while reducing its size will make the shadows sharper.

The light actors that can affect the casted shadow's hardness / softness (how defined the edges are):
- Rect Lights
	- Adjust Source Width, Source Height, or Scale
- Point Lights
	- Adjust Source Radius or Scale
- Spot Lights
	- Adjust Cone Angles

Applying the principle of Shadow Penumbra
https://en.wikipedia.org/wiki/Umbra,_penumbra_and_antumbra

---

## Shadow Hardness/Softness - Indirect Methods

1. **Directional Lights**: These lights simulate sunlight and have an infinite range and a constant direction. The size of a directional light source can't be adjusted in the same way as local lights like point or spotlights. The softness of the shadows from a directional light is more influenced by the sun's angle (time of day in the simulation) and atmospheric conditions rather than the light source size.

	- Indirect setting: Increase the "Source Angle" for soft shadows (less defined edges)
	- Indirect setting: Decrease the "Source Angle" for harder shadows (more defined edges)

1. **Ambient Light / Skylight**: This type of light simulates indirect lighting from the sky and doesn't have a definable source size. It generally produces very soft, diffused lighting without distinct shadows. The concept of adjusting the size to change shadow softness doesn't apply to ambient lighting.
    
3. **IES Light Profiles**: These are based on real-world lighting data and are used to simulate the precise distribution of light from real physical light sources. Since the light distribution is based on a fixed profile, you have limited control over the softness or hardness of the shadows.
    
4. **Emissive Materials**: While not a light actor per se, emissive materials in Unreal can emit light. However, the control over shadow softness is not as direct or intuitive as with dedicated light sources. The effect is more dependent on the material's properties and the overall lighting setup.
    

For most practical purposes in Unreal Engine, when you need precise control over shadow softness, you would typically use Rect Lights, Point Lights, or Spotlights, as these offer the most direct control over size and, consequently, shadow characteristics.


---

### Directional Lights

When discussing the softness of shadows cast by a Directional Light in Unreal Engine, which is often used to simulate sunlight, several factors come into play, but the size of the light source isn't one of them. This is because a Directional Light in a 3D environment like Unreal Engine is treated as if it's infinitely far away, with its rays considered parallel. This characteristic means that the traditional concept of "size" of the light source, as it applies to local lights like point or spotlights, doesn't apply to Directional Lights. Instead, other factors influence the softness of the shadows:

1. **Sun's Angle / Time of Day**: The angle at which the light hits objects can change the appearance of shadows. Early morning or late afternoon (low sun angle) will produce longer, softer shadows due to the increased path through the atmosphere, which scatters more light. Around noon, when the sun is overhead, shadows are shorter and can appear sharper.
	- **Physics of Noon Shadows**: Around noon, when the sun is overhead, the path of sunlight through the Earth's atmosphere is shorter compared to sunrise or sunset. This shorter path results in less atmospheric scattering of sunlight. Scattering is a process where particles and molecules in the atmosphere diffuse light in different directions. Less scattering means the light remains more concentrated and direct, leading to sharper, more defined shadows. Additionally, the overhead position of the sun means that objects cast shadows that are more compressed and shorter, as the light is hitting them more directly from above.
    
2. **Atmospheric Conditions**: The presence of atmospheric effects like haze, fog, or pollution can scatter sunlight, leading to softer shadows. Unreal Engine's atmospheric and volumetric effects can simulate this scattering, affecting how sharp or soft shadows appear.

	- **Examples of Atmospheric Effects in Unreal Engine**:
		- **Sharp Shadows**: In a clear, dry environment with minimal atmospheric scattering (like a bright, sunny day in a desert scene), shadows will be very sharp and well-defined. This is because the light is less diffused by the atmosphere.
		- **Soft Shadows**: In contrast, in a scene with fog, haze, or pollution, the shadows will be softer and less defined. This is due to the increased scattering of light by the particles in the atmosphere, which diffuses the light and fills in the shadows, reducing their contrast and sharpness.
    
3. **Light Settings**: Certain settings in the Directional Light properties, like Source Angle or Soft Shadow settings, can also influence the softness of the shadows. These settings simulate the effect of a larger angular size of the sun, which can make shadows softer.
	
	- **Large vs. Small Angular Size of the Sun**:
		
		- **Large Angular Size**: When the sun appears larger in the sky (not in actual size, but in its apparent size from the observer's perspective), it's akin to having a larger light source. This can happen during sunrise or sunset or can be simulated in Unreal Engine using light source angle settings. A larger angular size means the light rays hit the object from a wider range of angles, softening the edges of shadows and making them less defined.
		- **Small Angular Size**: Conversely, when the sun is directly overhead or simulated to have a smaller angular size, it behaves more like a point source of light. The rays are more parallel and concentrated, resulting in sharper, more defined shadows with clear edges.
	    
1. **Global Illumination**: The overall lighting environment, including bounced light and ambient light, can also affect shadow appearance. In a scene with strong global illumination, shadows might appear softer due to the indirect light filling in the shadow areas.
    

In summary, while you can't change the "size" of a Directional Light in Unreal Engine to affect shadow softness, you can manipulate the sun's angle, atmospheric conditions, and certain light settings to achieve a similar effect.

---

### Directional Light directly above subject

Aka sun light directly above subject.

If a sun is directly above, there will be defined shadows, as in clear edges on the shadows.
Explanation:

When the sun is directly overhead, such as around noon on a clear day, the shadows cast by objects will generally be more defined, with clearer and sharper edges. This is due to a few key reasons:

1. **Direct Angle of Sunlight**: With the sun directly above, the light rays are hitting objects from a more perpendicular angle. This means that the shadows are cast straight down, or very close to the object, reducing the area over which the shadow is diffused.
    
2. **Reduced Atmospheric Scattering**: At noon, the sunlight has a shorter path through the atmosphere compared to early morning or late evening. Less atmospheric scattering of light occurs, resulting in more direct and concentrated sunlight.
    
3. **Parallel Light Rays**: The overhead sun produces light rays that are more parallel when they reach the Earth's surface. This parallel nature of the light rays leads to sharper shadow edges, as there is less divergence of light around the object casting the shadow.
    

In 3D rendering and game engines like Unreal Engine, this effect is often simulated to create realistic lighting conditions that mimic the behavior of natural sunlight. By adjusting the position and angle of a directional light source (representing the sun), you can replicate how shadows would appear at different times of the day.

---

### Global Illumination

Global Illumination (GI) is a key concept in 3D rendering and game development, including platforms like Unreal Engine. It refers to the way light is simulated to behave in a realistic manner, not just in direct illumination from a primary light source (like the sun or a lamp), but also how it reflects, refracts, and scatters off surfaces and objects, contributing to the overall lighting of a scene. Here's a detailed explanation:

1. **What is Global Illumination?**
    
    - Global Illumination encompasses all the ways light interacts with the environment beyond the initial point of contact. This includes indirect lighting, where light bounces off surfaces and illuminates other areas, and color bleeding, where light carries color from one surface to another.
2. **Components of Global Illumination**:
    
    - **Indirect Light**: This is light that has bounced off one or more surfaces. It's softer and more diffused compared to direct light.
    - **Color Bleeding**: When light hits a colored surface and then bounces to another, it carries some of that color with it. For example, light hitting a red wall might cast a subtle red hue on the nearby white ceiling.
    - **Ambient Occlusion**: This is a shading method that adds depth by darkening areas where light is less likely to reach, like tight corners or crevices.
    - **Reflections and Refractions**: These are aspects of how light interacts with reflective or transparent materials, like mirrors or glass.
3. **Importance in Rendering**:
    
    - GI contributes significantly to the realism of a scene. It helps create natural-looking environments by simulating the complex ways light interacts with objects.
    - It's crucial for scenes where realism is key, such as architectural visualizations, cinematic content, and immersive game environments.
4. **Challenges and Solutions**:
    
    - **Computational Intensity**: Calculating GI can be resource-intensive. Solutions like baked lighting (pre-calculating light for static scenes) and approximation techniques help manage this.
    - **Real-Time Rendering**: For real-time applications like games, achieving realistic GI is challenging. Technologies like Unreal Engine's Lumen (introduced in Unreal Engine 5) offer real-time GI solutions that balance quality and performance.
5. **Examples in Unreal Engine**:
    
    - **Static vs. Dynamic GI**: Unreal Engine supports both static (baked) and dynamic (real-time) global illumination. Static GI is used for scenes where lighting conditions don't change, while dynamic GI is for environments with changing lighting.
    - **Ray Tracing**: Unreal Engine's support for real-time ray tracing enhances GI, especially in terms of reflections and accurate light behavior.

In summary, Global Illumination is a cornerstone of realistic rendering, adding depth, realism, and a natural feel to digital environments. Its implementation, especially in real-time contexts like games or interactive media, represents a significant technical achievement in the field of computer graphics.


---

Asked AI here: https://chat.openai.com/c/36a392e4-c007-4926-b461-991e33848dac