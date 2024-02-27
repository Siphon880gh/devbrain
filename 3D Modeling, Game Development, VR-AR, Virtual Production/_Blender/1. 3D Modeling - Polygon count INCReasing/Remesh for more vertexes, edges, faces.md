Sculpting mode: R -> Drag to adjust number of faces -> Click to soft commit
Then CMD+R for hard commit

![](https://i.imgur.com/aJlQML8.png)

Can go back into Edit Mode to see the new vertexes introduced. Rectangular sharp objects become more rounded and spherical.

![](https://i.imgur.com/B9Hh0nH.png)

->

![](https://i.imgur.com/O9v3CPd.png)


---

If you are remeshing more complicated objects, you may find the object look odd or the vertexes get messed up after remeshing.

You want to tick on "Fix Poles"
![](https://i.imgur.com/KEURyB0.png)

---

Explanation of Fix Poles:

When using a feature like "Fix Poles" during remeshing in Blender, the tool aims to address and optimize the distribution and impact of both N-Poles and E-Poles within a mesh. Here's how it relates to these types of poles briefly explained:

1. **N-Poles (where more than four edges converge)**: These vertices can create areas of high complexity within the mesh, potentially leading to pinching or artifacts when the mesh is subdivided or deformed. "Fix Poles" works to reduce the occurrence of N-Poles or redistribute them in a way that minimizes their impact on the mesh's surface quality and deformation behavior. The goal is to achieve a more uniform distribution of vertices and edges, enhancing the mesh's overall topology for smoother results in sculpting, animation, and other 3D modeling tasks.

2. **E-Poles (where fewer than four edges converge, typically three)**: E-Poles can also affect the mesh's smoothness and are often necessary for reducing mesh density or terminating edge loops. In the process of remeshing with "Fix Poles" enabled, Blender will attempt to manage E-Poles by either minimizing their number or strategically placing them where they are less likely to cause visible issues or deformation problems.

Overall, "Fix Poles" in the context of remeshing seeks to optimize the mesh topology by addressing both N-Poles and E-Poles. It does so to ensure a smoother, more uniform surface that behaves predictably during further editing, subdivision, and animation, ultimately leading to higher quality models with fewer artifacts.

