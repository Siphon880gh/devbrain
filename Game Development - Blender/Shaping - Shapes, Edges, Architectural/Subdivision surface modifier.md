
Subdivision breaks down current geometries into more geometries. You'd normally right click the object -> Subdivision, as many times repeatedly as needed to have the amount of geometries you want. This is destructive meaning you can only undo if you haven't closed the project yet. By adding a modifier, it'd be nondestructive and you can toggle on and off the amount of subdivisions. In addition, Blender has shortcut keys for the different levels of subdivision.

CTRL+# adds a modifier that is commonly used to smooth out the geometry of a model, making a low-poly object like a cube appear more rounded or sphere-like.

Here's a more detailed explanation of what happens:

- **Subdivision Surface Modifier:** This modifier increases the number of polygons in your model, smoothing out its appearance. It's a powerful tool for adding complexity and detail to your models without manually editing the geometry.

- **Level of Subdivision:** When you press `CTRL+2`, for example, you're setting the subdivision level to 2. The higher the level, the smoother and more rounded your object will become. Level 2 is often enough to transform a simple cube into something that looks more like a sphere because it quadruples the number of polygons for each subdivision level, significantly increasing the roundness of the model.

- **Applying the Modifier:** While `CTRL+2` adds the modifier to your object, it doesn't apply it permanently until you manually do so. This means you can adjust the subdivision level or remove the modifier later if you decide against the changes.

If you want to revert the cube back to its original shape, you can go to the Modifiers tab in the Properties panel, find the Subdivision Surface modifier you've just added, and either reduce the subdivision levels to 0 or delete the modifier entirely.

![](https://i.imgur.com/SC2gIE7.png)
![](https://i.imgur.com/NzXenIX.png)
![](https://i.imgur.com/wgpfwuS.png)
![](https://i.imgur.com/gwCvyER.png)


The above is a cube that went thru subdivision levels 2,3,4: CTRL+2, CTRL+3, CTRL+4

Remember these are modifiers meaning the geometry are programmed like this at 
![](https://i.imgur.com/qd7r0PZ.png)

Meaning everything can be reversed even if you had saved and reopened the project and therefore undo is impossible. In other words, the changes done with this is nondestructive