
Learned from:
https://youtu.be/4QIcHicY9Ks

## Scale

Pressing S and scaling will scale the vertexes to the set pivot point (usually global origin)

Changing the pivot point: When resizing, the operation appears at the bottom left and you can expand for quick options - you can change the orientation. Options include local (local origin) and Cursor and even Parent.

![](https://i.imgur.com/M3eYf0W.png)


Disadvantage of scale is that the vertexes may look ugly or not what you expect

---

## Shrink / fatten

The scaling is based on the normals (perpendicular axis to the surface axis, aka direction the polygon is), which will have the vertexes remain more normal after alteration.

![](https://i.imgur.com/zx0IyEs.png)
^ Right side is after shrink / fatten. Left side is scaling

Scaling
![](https://i.imgur.com/fAVevmQ.png)

vs Normal
![](https://i.imgur.com/Aeg91PL.png)

^/^^ Shrink and Fatten looks more natural than scale

---

Another con for scales is you may want to resize in the direction of the faces (kinda balloon them outwards), making you have to think what axis to lock out (eg. S->Z or S->Shift+Z), and that's only if the faces are lined up with the axis.