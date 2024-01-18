Emissive color is the glow

When changing the emission of an item (eg. adding glow to Text Render), your constant3vector will receive rgb for the color, but if you had multiplied that to a number, you can affect the glow spread:
![](https://i.imgur.com/V2pJMBS.png)


0.3 vs 3
![](https://i.imgur.com/FqbpbgE.png)

![](https://i.imgur.com/3QK6QjY.png)


0.3 vs 3 on the viewport:

![](https://i.imgur.com/SoPolhm.png)


![](https://i.imgur.com/QuBpbci.png)

^ Keep in mind base color is white

---

Reworded:

In Unreal Engine's Material Editor, when you add a Constant3Vector to the Emission Color input of a material, it defines the base color of the glow. However, controlling the intensity or "how much" it glows involves a few more steps:

1. **Scalar Parameter for Intensity**: To control the intensity of the glow, you can multiply the Constant3Vector with a Scalar Parameter. This allows you to adjust the intensity of the glow dynamically. Create a Scalar Parameter by right-clicking in the material editor and selecting 'Scalar Parameter'. You can name this parameter something like "Glow Intensity". Connect this Scalar Parameter to a Multiply node, and then connect the Constant3Vector to the other input of the Multiply node.
    
2. **Adjusting the Scalar Parameter**: By adjusting the value of the Scalar Parameter in the material instance, you can control how much the material glows. A higher value results in a stronger glow, while a lower value reduces the glow.
    
3. **HDR (High Dynamic Range) Values**: Unreal Engine supports HDR values for colors, which means you can set values above 1.0 for the Constant3Vector or the Scalar Parameter to achieve a more intense glow effect. This is particularly useful for creating materials that appear to emit light.