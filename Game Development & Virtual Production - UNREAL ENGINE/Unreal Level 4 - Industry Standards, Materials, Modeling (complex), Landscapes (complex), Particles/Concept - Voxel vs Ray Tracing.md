Voxels are **essentially 3D pixels**, but instead of being squares, they are perfect cubes. In theory, voxels are the perfect modeling technique for replicating reality.

![](https://i.imgur.com/i50TSgv.png)


A voxel is a 3D cube that is part of a 3D grid. It is the 3D equivalent of a pixel, which is a square in a 2D image. Voxels are used to create 3D models. 

Voxel Plugin brings the voxel technology to Unreal in a separate mode called Voxel Mode. Free and Pro have the same blueprint API. However, free is missing the implementation of some functions, and will show a Voxel Plugin Pro only popup if you try to use them. This means that you can start a project with Free, and painlessly migrate it to Pro later on.

https://wiki.voxelplugin.com/index.php?title=Quick_Start&mobileaction=toggle_view_desktop#:~:text=Free%20and%20Pro%20have%20the,it%20to%20Pro%20later%20on.



Voxel vs Ray Tracing

Creating a 3D scene can be approached using various techniques, each with its advantages and challenges. Two prominent methods are voxel-based rendering and ray tracing. Here's a comparison of the two:

### Voxel-Based Rendering
1. **Definition**: Voxels are the three-dimensional equivalent of pixels. Voxel-based rendering uses these 3D cubes to build up a scene.
  
2. **Performance**: Generally faster for certain types of scenes, especially where complexity is low to moderate. It's often used in games for its speed and simplicity.

3. **Quality**: Can produce a stylized look as each voxel represents a fixed point in space. However, it might lack the smoothness and detail that other rendering methods offer.

4. **Memory Usage**: Can be memory-intensive, especially as the resolution of the voxel grid increases.

5. **Use Cases**: Often used in stylized games, medical imaging, and any application where a blocky, distinct look is acceptable or desired.

### Ray Tracing
1. **Definition**: Ray tracing simulates the way light interacts with objects. It traces the path of light as pixels in an image plane, simulating effects like reflection, refraction, and shadows.

2. **Performance**: Generally slower than voxel-based rendering due to the complex calculations required for each ray of light, especially in high-detail scenes.

3. **Quality**: Can produce highly realistic images with accurate lighting, shadows, and reflections. It's the go-to for photorealistic rendering.

4. **Memory Usage**: While not necessarily memory-intensive, the computational demand is high, requiring powerful hardware for real-time applications.

5. **Use Cases**: Used in high-end graphics work like movies, architectural visualization, and any application where visual realism is paramount.

### Comparison Summary:
- **Performance**: Voxels are typically faster but less detailed. Ray tracing is slower but produces higher quality images.
- **Quality**: Voxels give a unique, blocky style, while ray tracing aims for photorealism.
- **Memory Usage**: Both can be demanding in different ways; voxels in terms of space, ray tracing in terms of computational power.
- **Use Cases**: Voxels for stylized or less demanding visual applications; ray tracing for high-end, realistic imagery.

In choosing between the two, consider the desired outcome, resources available, and the specific needs of the project. Some modern games and applications even combine both methods to balance quality and performance.