Problem: When you import into Unreal Engine, it’s multiple models instead of one model

---

You need one unifying object that holds onto the other objects

As you see here, the cylinder, cube, and plane (fire image) are all at the same level as siblings

![](https://i.imgur.com/EdBqHM5.png)

You need to set parent to child relationships.

Child belongs to the parent (Select child, SHIFT+Select parent), CTRL+P, Set Parent to Object

![](https://i.imgur.com/CpK0g4r.png)

  
Cube → Cylinder
Plane → Cube

btw the plane is the fire plane image. The cube is the fireplace. The cylinder is the tube leading to the fireplace.

In this approach, if you rotate the cylinder, it rotates the fireplace along with it...

---

Another approach is to have an invisible cube (Material Properties → Add material → Set Transparent BSDF as the Surface). Here the Source is an invisible cube. In this way, rotating the cylinder does not rotate the other objects.

![](https://i.imgur.com/6mcya9z.png)
