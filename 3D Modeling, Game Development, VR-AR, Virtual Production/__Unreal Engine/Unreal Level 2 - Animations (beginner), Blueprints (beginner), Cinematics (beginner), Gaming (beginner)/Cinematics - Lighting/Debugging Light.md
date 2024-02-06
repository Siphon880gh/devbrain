
**Add a reflective chrome ball:**

Creating a mirror ball in Unreal Engine to reflect lighting involves several steps. Here's a basic guide to help you get started:

1. **Create the Sphere:**
    
    - In Unreal Engine, you can start by creating a sphere that will act as your mirror ball. You can do this by adding a sphere mesh to your scene.
2. **Apply a Reflective Material:**
    
    - To make the sphere behave like a mirror, you need to apply a highly reflective material to it. You can create a new material in the Material Editor.
    - In the Material Editor, you should set the material's metallic value to a high level and the roughness value to a low level. This will make the material highly reflective.
3. **Adjust Lighting Settings:**
    
    - Ensure your scene has proper lighting. A mirror ball reflects the environment, so the lighting in your scene will significantly impact how the mirror ball looks.
    - You might need to adjust the light source settings, such as intensity and color, to get the desired reflection effect.
4. **Enable Reflections:**
    
    - Unreal Engine uses Screen Space Reflections (SSR) by default, but for a more accurate reflection, you might want to use Reflection Capture actors. Place a Reflection Capture actor (like a Sphere Reflection Capture) near your mirror ball to improve the quality of reflections.
5. **Fine-Tuning:**
    
    - You may need to fine-tune the settings of both the material and the reflection capture to get the desired effect. This includes adjusting the intensity, size, and position of the reflection capture actor.
6. **Testing:**
    
    - After setting up your mirror ball, test it by moving the camera around and observing how the reflections change. This will help you determine if further adjustments are needed.

Remember that real-time reflections can be performance-intensive, so you might need to balance between reflection quality and performance, especially if you're working on a game or an interactive application.

For more specific or advanced techniques, you may want to consult Unreal Engine's documentation or look for tutorials specific to the version of Unreal Engine you're using, as features and best practices can vary between versions.

---

**Turn on Detailed Lighting or Lighting Mode**

![](https://i.imgur.com/uK8v3hY.png)
