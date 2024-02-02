
Adding bevels to a shape is very involved in that there are different types of bevels:
- Bevel edge
	- Fillet
	- Chamfer
	- Bevel aka ramp
- Bevel vertexes
- Bevel face

## Bevel Edges 

Concept: Bevel and chamfer are usually used interchangeably unless you want to be technical about it: A bevel is actually a ramp and a chamfer is a partial ramp that makes up the edge.

Challenge: Make one of the edges a chamfer edge (technical word). Layperson word: have the edge beveled.
![](https://i.imgur.com/HeeyQhL.png)

Select edge -> Bevel tool (CMD+B)
Not B because B is for Select Box

How it works. Tangent to the edge at 45 degrees will create two new 3d vertex points (as in, 2 vertex at end of edge and 2 more vertexes at the other end of edge) and it will subtract mesh from those two points

Industry: Chamfered edges have a variety of functions during the manufacturing process. They remove sharp edges from workpieces and, therefore, facilitate safe handling. Chamfering also aids in the assembly of parts and serves a cosmetic purpose by improving the look of **[machined parts](https://www.madearia.com/blog/cnc-machined-parts/)**. Chamfer mills and chamfer planes are some of the tools used to machine chamfers.
https://www.madearia.com/blog/chamfer-vs-bevel/

---

Challenge: Create a ramp out of a box. Technical word: Bevel.

![](https://i.imgur.com/0vBuLjI.png)


Select edge -> Bevel Tool (CMD+B)
Go all the way until the two new 3d vertex points (as in, 2 vertex at end of edge and 2 more vertexes at the other end of edge) juxtapositions over the old vertexes.

Industry: Unlike a chamfered edge which covers a fraction of the plane between two parallel surfaces, a beveled edge runs for the entire length of the plane. Therefore, we take out more material to create beveled edges compared to chamfered edges.
https://www.madearia.com/blog/chamfer-vs-bevel/

---

Therefore bevel tool allows you to create a chamfer or a bevel/ramp depending on the extent you go with it

---

Extra Challenge: 
Chamfer all four corners

![](https://i.imgur.com/kyqC5lb.png)

Hint: select all 4 edges -> CMD+B while in Edit mode -> Then drag to choose desired level of bevel/chamfer

---

## Bevel Vertexes

Instead of CMD+B, SHIFT+CMD+B will bevel the vertex

With edge selected in Edit Mode, SHIFT+CMD+**D**

![](https://i.imgur.com/nJR2Caq.png)



----


## Fillet / Smooth out the bevel

![](https://i.imgur.com/rohOB1s.png)


While adding bevel, use mouse scroll before committing with a click:
![](https://i.imgur.com/NXgiAmj.png)

Gone too far will make the cube a quarter with a fillet face
![](https://i.imgur.com/AiEILgF.png)

Also works on the vertex bevel mode (SHIFT+CMD+B):
![](https://i.imgur.com/XHtKOul.png)

![](https://i.imgur.com/evNquCb.png)



---


## Face bevel

Face bevel is like a pull (from push/pull) with a fillet
![](https://i.imgur.com/WeKtjHW.png)

You select the face, then CMD+B, then drag.


----

For more of workflow on adding the edges:
https://www.youtube.com/watch?v=QFyw21IVMQM

![](https://i.imgur.com/mKfKoig.png)


---

## Troubleshooting

Problem: Moues scroll doesnt cause a curving or filliting

You probably already commited the bevel change. Try to bevel again and before clicking the mouse, drag a bit to have new space to see the curve, THEN try the mouse scroll.

You'd try to bevel again using CMD+B or CMD+SHIFT+B, but NOT by using the bevel handle:
![](https://i.imgur.com/w9i1zXC.png)
