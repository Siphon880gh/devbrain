
Status: Only helped my fps a little. Need to try all these (some take effort like yes this guide mentions Draw Call, but you have to research how to change that setting). Need to reformat this guide so is cleaner to read

  
---

## Report Stats

You type into command
```
stat fps
stat unit
```


<<
16 fps
Frame: 60

\<<
Which one is the frames per second?

\>>

**Frame Time**: It could represent "frame time," which is the time it takes to render a single frame, typically measured in milliseconds (ms). However, a frame time of 60 ms would correspond to a very low FPS (about 16.6 FPS), which is not a good performance indicator for real-time applications.  

  

---

## Per project lag

### 2 Landscapes really cause lag. 

Make sure it’s 1 landscape (if you need 2 types of landscapes, the right type of approach is blending/painting landscape layers)

Here’s proof

- 2 Landscapes → 1 landscape (hidden other one)
- 24fps → 16fps

  
### Floor or landscape too large

Also you may want to adjust the sizes (quads, components, etc) so it covers a smaller area (see green guidelines)

  

---

  

## When starting a new project

Make sure Raytracing is ticked. Otherwise then in your editing, you have to go into Edit → Project Settings after the fact, to change to Ray tracing (Refer to videos at Other Lag Fixes)


---


## Workflow Habits


Matching the desired axis' color in viewport to the axis setting's color in Outliner → Details. Click and dragging in the Details panel rather than manipulating object's transformation in viewport is less laggy and more precise

![](https://i.imgur.com/0qqNXaj.png)





---


## Other Lag Fixes:

[https://youtu.be/esrnQBq75qg?si=JCtyGQinTnjnEsE6](https://youtu.be/esrnQBq75qg?si=JCtyGQinTnjnEsE6)  

[https://youtu.be/BlMyL8J7HPo?si=fPjVzi0QefAAGSA4](https://youtu.be/BlMyL8J7HPo?si=fPjVzi0QefAAGSA4)  
[https://www.youtube.com/shorts/woH3E-g8l-8](https://www.youtube.com/shorts/woH3E-g8l-8)  


Highlights:

- Raytracing set in various places at: Edit → Project Settings  

- Or when you start a project, you had ticked “Raytracing”

- Engine scaling settings (Think you’re scaling an engine to better hardware)


![](https://i.imgur.com/dtyUYaM.png)
  

 ^ Note it’ll affect your final rendering for the consumers, so plan accordingly


---


## Lag Fixes per ChatGPT

  

[https://chat.openai.com/c/d742dd2c-d9d5-4a7d-9e7a-0298afa02584](https://chat.openai.com/c/d742dd2c-d9d5-4a7d-9e7a-0298afa02584)

  

Creating a smooth-running Unreal Engine landscape on a Mac involves optimizing both your project and your Mac's resources. Here's a list of strategies you could employ:

  

1. **Lower Landscape Complexity**: Reduce the number of components and the overall resolution of the landscape. Use simpler materials.

  

2. **Level of Detail (LOD)**: Adjust the Level of Detail settings to reduce the complexity of the landscape as the camera moves away from it.

  

3. **Use Level Streaming**: Divide your landscape into multiple levels that can be loaded and unloaded as needed.

  

4. **Cull Distance**: Set up culling distances to avoid rendering objects that are too far away to be seen.

  

5. **Lighting Optimization**: Use static lighting instead of dynamic if possible, and be cautious with the number of light sources.

  

6. **Reduce Draw Calls**: Merge static meshes and reduce the number of individual objects that need to be rendered.

  

7. **Texture Optimization**: Use smaller texture sizes and more efficient compression.

  

8. **Shader Complexity**: Simplify your shaders and materials to make them less demanding on the GPU.

  

9. **Optimize Foliage**: If you have foliage, use instancing, and make sure it's set to billboards at distance.

  

10. **Hardware Check**: Make sure your Mac meets the minimum system requirements for Unreal Engine and that your drivers are up to date.

  

11. **Close Background Applications**: Ensure no unnecessary applications are running in the background that could be consuming CPU, memory, or disk resources.

  

12. **Graphics Settings**: Lower the graphics settings in Unreal Engine to reduce strain on your hardware.

  

13. **Profiler Tools**: Use Unreal Engine's built-in profiler tools to identify and address performance bottlenecks.

  

14. **Asset Quality**: Use assets that are optimized for performance, considering their impact on rendering and memory.

  

15. **MacOS Optimization**: Keep your MacOS updated and optimized for performance. Disable system features that may use up resources, like automatic backups and graphics switching.

  

By methodically adjusting these settings and staying within the performance budget of your Mac, you should be able to create a landscape in Unreal Engine that performs well. Remember that Macs, especially those without dedicated GPUs, may struggle with the demands of real-time 3D rendering, so managing expectations regarding graphical fidelity and complexity is also important.  
  
++++++  
  
If you're only getting around 16 FPS in your Unreal Engine project on a Mac, this can be quite limiting for both development and gameplay experiences. To increase your FPS, you should consider both hardware and software optimization techniques:

  

### Software Optimization:

  

1. **Quality Settings**: Reduce the overall quality settings in Unreal Editor. You can do this by going to Edit -> Editor Preferences -> Performance and adjust for better performance.

  

2. **Screen Resolution**: Running Unreal Editor at a lower screen resolution can greatly increase FPS.

  

3. **Viewport Settings**: In the viewport, use the 'Shaded' view instead of 'Lit' view while editing. You can also lower the resolution of the viewport directly.

  

4. **Simplify Scene**: Temporarily hide or remove complex assets while you're working on other aspects of the scene.

  

5. **Disable Real-Time Rendering**: When not necessary, turn off real-time rendering in the viewport.

  

6. **Render Scale**: If you're running a version of Unreal that supports it, reducing the render scale can improve performance.

  

7. **Static Meshes and Actors**: Use instanced static meshes where possible and combine meshes to reduce the number of draw calls.

  

8. **Post Process Effects**: Minimize or disable post-process effects as these can be quite heavy on performance.

  

### Hardware Considerations:

  

1. **Graphics Card**: While Macs aren't typically known for their graphics prowess, some models do come with more powerful GPUs. If you have a Mac with a discrete GPU, make sure Unreal Engine is utilizing it instead of an integrated GPU.

  

2. **System Resources**: Make sure your Mac has enough RAM and a fast enough CPU to handle Unreal Engine's demands. Close any unnecessary applications to free up resources.

  

3. **Thermal Throttling**: MacBooks, in particular, can suffer from thermal throttling. Make sure your Mac has adequate cooling to prevent this.

  

4. **External GPU (eGPU)**: If you have a compatible Mac and Thunderbolt 3 port, you can consider using an external GPU to improve performance.

  

### Unreal Engine Specific:

  

1. **Occlusion Culling**: Make sure occlusion culling is properly set up to not render objects that are not in view.

  

2. **Material Complexity**: Simplify materials and reduce the number of texture samples within them.

  

3. **Blueprints Optimization**: Ensure your blueprints are optimized and not running unnecessary calculations every frame.

  

4. **Garbage Collection**: Manage your memory usage and ensure that garbage collection is not running too often.

  

5. **Lighting**: Use baked lighting instead of dynamic lighting if possible, and keep the number of dynamic shadows to a minimum.

  

### Performance Profiling:

  

1. **Stat Commands**: Use Unreal’s in-editor console commands to see stats in real-time (`stat fps`, `stat unit`, etc.).

  

2. **Profiler Tool**: Use the Unreal Engine profiler tool to pinpoint exactly what is causing the most significant drops in frame rate.

  

Once you have identified the areas that are consuming the most resources, you can target them for optimization. Often, a few targeted changes can result in significant FPS improvements. Keep in mind that Unreal Engine is a powerful tool, and squeezing out performance may require some trade-offs in visual quality, especially on hardware that is not primarily designed for high-end game development like most Macs.

  

  
++++++  

  

To ensure that Unreal Engine is using the discrete GPU instead of the integrated GPU on your Mac, you can follow these steps:

  

1. **Check Your Mac’s Specs**:

   - Click on the Apple icon in the top left corner of your screen.

   - Select "About This Mac."

   - Look for "Graphics" to see if you have more than one GPU listed. If there's an integrated GPU (like Intel Iris) and a discrete GPU (like AMD Radeon), then your Mac supports automatic graphics switching.

  

2. **Energy Settings**:

   - Open "System Preferences" from the Apple menu.

   - Go to "Energy Saver" for older macOS versions or "Battery" for macOS Monterey and later.

   - If you have the option "Automatic graphics switching," unchecking this option can force the use of the discrete GPU. However, be aware that this will increase energy consumption and can drain your battery faster if you're on a MacBook.

  

3. **Forcing the Discrete GPU**:

   - Some applications can control which GPU is used. In Unreal Engine, however, you don't have a direct setting within the engine to select the GPU. It usually defaults to the most powerful GPU available.

  

4. **Activity Monitor**:

   - Open "Activity Monitor" from the Utilities folder.

   - Click on the "Energy" tab to see the "Requires High Perf GPU" column. This will tell you which applications are requesting the use of the discrete GPU.

  

5. **Use Graphics Card Status Apps**:

   - There are third-party applications, like "gfxCardStatus," which can give you control over which GPU your MacBook uses (though compatibility varies with updates to macOS). These apps can allow you to switch manually between GPUs.

  

6. **Update Your macOS**:

   - Keeping your macOS up to date can also help, as Apple often includes performance and compatibility improvements in updates.

  

7. **Monitor GPU Usage in Unreal Engine**:

   - You can monitor the GPU Unreal is using in real-time by using macOS's Activity Monitor or by using third-party software that shows which GPU is active.

  

If you've ensured that the discrete GPU is selected but are still experiencing low FPS, the problem may lie elsewhere, such as in Unreal Engine's settings or your project's optimization. Remember that even with a discrete GPU, Macs might not match the performance of a similarly equipped Windows PC due to differences in how macOS handles graphics processing, thermal limitations, and possibly the optimization of the Unreal Engine itself for macOS.

  

  

  

---

  

## ^ What is FPS?

  

In the context of performance metrics for video games and applications, "FPS" stands for frames per second. This is a measure of how many images (frames) your computer graphics can render and display in one second. So when you mention "16 fps," that means your application is rendering 16 frames each second.

  

On the other hand, "Frame: 60" is not a standard way of representing performance metrics. It could mean several things depending on the context:

  

1. **Frame Time**: It could represent "frame time," which is the time it takes to render a single frame, typically measured in milliseconds (ms). However, a frame time of 60 ms would correspond to a very low FPS (about 16.6 FPS), which is not a good performance indicator for real-time applications.

  

2. **Frame Number**: It could be referring to a specific frame number in a sequence or animation. For instance, if you are looking at frame-by-frame analysis, "Frame: 60" might simply refer to the 60th frame in the sequence.

  

3. **Target FPS**: It might represent a target FPS setting or the refresh rate of the monitor, although these are usually expressed in terms of "Hz" for refresh rates (e.g., 60Hz).

  

In gaming and real-time applications, a higher FPS is typically desired as it leads to smoother motion and a better overall experience. Standard targets for FPS are 30 FPS for acceptable performance and 60 FPS for smooth performance. Higher-end systems and monitors can aim for even greater FPS, like 120 FPS or 144 FPS, for very smooth and responsive gameplay.

  

Based on your original message, "16 fps" is your current frames per second, and that's the metric to consider when evaluating the performance of your game or application. If you are experiencing 16 FPS, you are likely noticing significant lag and would want to increase this for a better experience.

  

  

---

  

  

## ^ What is Draw Call

"Draw calls" is a term commonly used in computer graphics and game development. It refers to the process of instructing a graphics processing unit (GPU) to render images or scenes on a computer screen. Each draw call represents a request to render a specific object or set of objects in a 3D scene. These calls are essential for creating graphics in video games and other interactive applications.

  

Here's a brief overview of how draw calls work:

  

1. Application Code: The application's code (e.g., a game engine or program) sends commands to the GPU through a graphics API like DirectX or OpenGL.

  

2. State Setup: Before making a draw call, the application sets up various states, such as shaders, textures, and rendering parameters, to define how the object(s) should be rendered.

  

3. Draw Call: The application issues a draw call to the GPU, specifying what to render, how to render it, and where to render it on the screen. This can include information about the 3D model, its position, shaders to be used, and more.

  

4. GPU Processing: The GPU processes the draw call and performs the necessary calculations to render the object(s) based on the provided information. This involves vertex processing, fragment shading, and other graphics operations.

  

5. Output: Finally, the GPU generates the pixels that make up the image and displays it on the screen.

  

Optimizing draw calls is crucial for achieving good performance in graphics-intensive applications like games. Minimizing the number of draw calls and efficiently batching objects together can help improve frame rates and overall rendering performance.

  

If you have more specific questions or need further information about draw calls or related topics, feel free to ask!

  
  

  

  

  

---