
Select a group of vertexes and you save it for later selection or for applying modifier effects on only those parts of the object.

Note that not all modifiers support only applying to a certain part of an object (via a vertex group aka vertex points you selected). For example, and unfortunately, subdivision surface modifier does not support vertex group. In that case you have to cut your object into parts (bisect, knife, loop cut, etc, then select one part, then separate by selection), and then that modifier can only apply to an entire object, then you join the two objects back together.

Continuing...

In Edit mode you select the vertexes of an object you want to apply modifiers etc and you’ll create a new vertex group from it. See that we are in the data/vertex properties, and we click +

![](https://i.imgur.com/dSmuFmQ.png)

Then you click Assign to assign the selected vertex to that group:
![](https://i.imgur.com/IFKsMZT.png)


Btw with multiple vertex groups, you can select which are addictive and you can deselect which is subtractive, allowing you to select multiple vertex groups simultaneously.

Some modifiers have vertex group, limiting the modifer’s effect to a part of the object:
![](https://i.imgur.com/xT79XvI.png)

---

Alternate:

[https://youtu.be/OYg2fyQMtJc?si=gZME4_re0YAPsntS](https://youtu.be/OYg2fyQMtJc?si=gZME4_re0YAPsntS)