
## Bevel arch edge:

Edit Mode:
Select edge (3). That’s requirement

Press CTRL+B. Then drag mouse

Increase the number of subdivisions by scrolling the mouse scroll button
Or press S for a handle to drag and lastly click to commit
Or press S then press 1,2,3... for increasing subdivisions, and lastly click to commit

The subdivisions is what makes the bevel edge into an arch:
![](https://i.imgur.com/czFOm31.png)


---

## Bevel stepwise edge:

Edit Mode:
Select edge (3). That’s requirement

Press CTRL+B. Then drag mouse

Do not increase the number of subdivisions (mouse scroll being scrolled or pressing S or pressing 1) or at most only few subdivisions. Adding subdivisions would make it round/arched. We want stepwise:

![](https://i.imgur.com/ZgF3pRm.png)

---

Remember it’s been CTRL+B, NOT B. B by itself is just box select shortcut

----

## Corner bevel (stepwise)
![](https://i.imgur.com/h552qzq.png)
  

Not really using bevel tool

Choose a vertex where you want a triangular face

At a corner, select a connecting edge (2) → right click → subdivide. Then select the new vertex (1) and move the new vertex along the axis (G->X) closer to the vertex
![](https://i.imgur.com/9WJoYAF.png)

![](https://i.imgur.com/tb4N5Et.png)

Repeat for all three edges of that vertex:
![](https://i.imgur.com/858sjKy.png)

Delete the corner vertex
![](https://i.imgur.com/R326GNl.png)

Select the three relevant vertexes from before then press F for fill:
![](https://i.imgur.com/GMSfCNG.png)

You want to fill the other faces that were lost too. In this case it’s simply fixed by selecting all vertexes then hitting F:
![](https://i.imgur.com/qLzLQWb.png)

---

## Bevel corner edges - thin

This is only 1/4 corner
![](https://i.imgur.com/rKch1nK.png)


How:

Select 3 edges adjacent to a corner vertex

Press CTRL+B

Then rotate along the circular handle slightly. Click to confirm

![](https://i.imgur.com/LZ2AM2B.png)

![](https://i.imgur.com/REyVfYE.png)


---

## Bevel corner edges - thick
This is only 1/4 corner
Like a corner of a mechanical structure

![](https://i.imgur.com/d9YU8q6.png)


How:
Select 3 edges adjacent to a corner vertex
Press CTRL+B
Then rotate along the circular handle slightly, then exaggerate clockwise. Click to confirm

Not exaggerated yet:
![](https://i.imgur.com/aXjov9z.png)


Exaggerated for the thick edges we want - so thick they are pretty much the same sizes as the main faces:
![](https://i.imgur.com/IFQUgSp.png)



All bevel edges of a cube:
Select all (doesnt matter all vertexes, edges, or faces)
CTRL+B → circle handle drag clockwise → Click to commit

![](https://i.imgur.com/0ExojJY.png)


---


Bevel - Create 3D diamond

All bevel edges of a cube:
Select all (doesnt matter all vertexes, edges, or faces)
CTRL+B → circle handle drag clockwise → Then overexagerate the clockwise until becomes diamond → Click to commit

![](https://i.imgur.com/66ZHPWP.png)


![](https://i.imgur.com/0EhaCPN.png)


You can resize it into a thinner diamond by resizing X and Y axis (Object Mode → S → Shift+Z)
![](https://i.imgur.com/xoeoKZa.png)
