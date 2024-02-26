
Goal:
Change face mesh with an edge along an edge - vs- a vertex along an edge

Some of this content figured from:
https://www.youtube.com/shorts/oycQeevKZ18

## Edge Slide
Edit Mode:
Edge Slide tool.
![](https://i.imgur.com/uymZEV0.png)

Select either an edge or a vertex or a face. There would be different effects sliding along an edge or all edges of a face

## Vertex Slide
Edit Mode:
Vertex Slide tool.
![](https://i.imgur.com/xbXNmqJ.png)


## Automatic edge or vertex slide
Instead of clicking the Edge Slide or Vertex Slide tool, you could have selected the selection tool select for the edge/vertex/face, then press G twice. The first G is for translating and the second G is for a shortcircuitted shortcut to Edge or Vertex Slide depending on what's selected.  At the bottom of Blender, you'll see where it'll shortcircuit to either vertex or edge slide.
- If edge or face selected, it'll do edge slide
- If vertex selected, it'll do vertex slide.
![](https://i.imgur.com/FyFfUto.png)


After you pressed G twice, you have the option of turning off clamping by pressing C. By pressing G -> G -> C, you are no longer limited to the edge within the confines of the mesh; the edge will extend to infinity.

Here demonstrates clamp off (by default, clamp is on, clamping the edge being slid on to the confines of the mesh). Top edge of plane mesh selected, then pressed G twice, then pressed C.

![](https://i.imgur.com/SkQLqzg.png)

![](https://i.imgur.com/Zg7deRq.png)

![](https://i.imgur.com/ahQNpP7.png)

If you had selected another edge, then G->G->C
Or had you change direction after pressing G->G by moving the mouse, then pressed C

![](https://i.imgur.com/KkunNbz.png)



---

## Edge-sliding an edge along a plane mesh
It like a sliding door

![](https://i.imgur.com/USMscfH.png)

## Edge-sliding a face along a cube mesh

Can morph a cube towards a plane mesh
![](https://i.imgur.com/5TsgWVK.png)

### But sliding in the other direction
would collapse the edge it follows into a diagonal (think quads reduce to tris, so that's the next edge). Causing the face being slid to become a smaller face, morphing the cube towards a pyramid.
![](https://i.imgur.com/TJR3bPD.png)




## Vertex sliding

Vertex slide would slide the edge A along the edge B without keeping edge A perpendicular to B:

![](https://i.imgur.com/dDECrNU.png)

Moving the mouse in the other direction will change the edge B to another adjacent edge of the vertex:
![](https://i.imgur.com/STpC6v4.png)


Had it been edge slide, edge A would be perpendicular to edge B at all times
![](https://i.imgur.com/nnAx70m.png)

You can also shortcitcuit vertex sliding with G->G->C to have an infinite axis rather than being limited to the edge of the mesh:
![](https://i.imgur.com/EiyWD9N.png)

When you press C will set the infinite axis. Here shortly before pressing C:
![](https://i.imgur.com/IQXkjbI.png)
or
![](https://i.imgur.com/SoXIjsz.png)

## Vertex slide of cube:
![](https://i.imgur.com/FgYHn7u.png)
![](https://i.imgur.com/X6b7vYk.png)
