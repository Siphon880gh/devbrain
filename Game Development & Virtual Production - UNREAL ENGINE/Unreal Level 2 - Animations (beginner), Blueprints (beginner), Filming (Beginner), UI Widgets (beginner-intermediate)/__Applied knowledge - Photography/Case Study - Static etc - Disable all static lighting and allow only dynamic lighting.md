
https://forums.unrealengine.com/t/how-to-disable-all-static-lighting-and-force-dynamic-lighting-only/300270

Background:
In Unreal Engine, lighting plays a crucial role in creating realistic and visually appealing environments. Understanding the different types of lighting is essential for game developers and level designers. Here's an explanation of static lighting, dynamic lighting, and stationary lighting:

1. Static Lighting:
    
    - Static lighting, also known as baked lighting, is a type of lighting that is precomputed and stored in textures or lightmaps before the game is run.
    - This lighting method is suitable for objects or environments that do not change during gameplay, such as buildings, terrain, and most static props.
    - Static lighting is highly optimized and can achieve high-quality results but is not suitable for objects that move or change position in the game world.
2. Dynamic Lighting:
    
    - Dynamic lighting, as the name suggests, is lighting that can change in real-time during gameplay.
    - Dynamic lights can move, change color, intensity, and direction, making them suitable for objects like characters, vehicles, and interactive elements.
    - Dynamic lighting is computationally more expensive than static lighting and may require more powerful hardware to run smoothly.
3. Stationary Lighting:
    
    - Stationary lighting is a hybrid lighting solution that combines some aspects of both static and dynamic lighting.
    - It is often used for objects or environments that need to appear mostly static but still have some dynamic properties.
    - In stationary lighting, direct lighting (e.g., sunlight) is precomputed (similar to static lighting), but indirect lighting (e.g., bounce light) is calculated in real-time.
    - Stationary lights can cast dynamic shadows and have some flexibility for changes during gameplay without the full performance cost of dynamic lighting.

In summary:

- Static lighting is precomputed and suitable for non-changing parts of the environment.
- Dynamic lighting is real-time and suitable for objects that change during gameplay.
- Stationary lighting is a compromise that combines precomputed direct lighting with real-time indirect lighting, providing a balance between quality and performance for some types of objects and environments.

The choice of lighting method in Unreal Engine depends on the specific needs of your project and the performance capabilities of your target platform. Unreal Engine provides a variety of tools and settings to help developers achieve their desired visual results while maintaining good performance.