Render Engines:

- Evee
- Workbench
- Cycle

![](https://i.imgur.com/0ZHCOhU.png)

![](https://i.imgur.com/mI0L7WM.png)

## An example when render system matters
When making a material transparent, you can make the material invisible in various ways depending on the rendering engine you are using (e.g., Eevee or Cycles). 
For instance:
- For Eevee: Set the material's 'Blend Mode' to 'Alpha Blend' and reduce the 'Alpha' value to 0. This makes the material fully transparent.
- For Cycles: Use the 'Principled BSDF' shader and set the 'Transmission' to 1 and 'Roughness' to 0 to create a clear, glass-like material. Additionally, you can mix it with a 'Transparent BSDF' shader using a 'Mix Shader' and control the factor to adjust transparency.