
Key technique: Press E to extend

---


With vertexes/edges/faces selected, you press E to extrude

Mind the behavior:
If you had selected all vertexes of a cube, it'll duplicate which is probably not what you want:

![](https://i.imgur.com/5I0ZVTy.png)

![](https://i.imgur.com/VuiiYvz.png)

---


But if you selected the top face (Press 3 for selection mode face), then press E for extrude, and this is the behavior that people want when they mean extrude:

![](https://i.imgur.com/eEyeYG0.png)


How it works: That face will be duplicated into the new position in the tangent direction to the face mesh, then blender fills in the side gaps with continuous mesh


---

If you extrude (E) a vertex from the cube, you can click somewhere in the distance to create a new vertex connected as an edge:

![](https://i.imgur.com/hYm8UBU.png)


![](https://i.imgur.com/6E7o2OX.png)


----

Btw, if you extend a bone, it creates more bones:
![](https://i.imgur.com/7Je5bfX.png)
