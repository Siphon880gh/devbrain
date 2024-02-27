

Note that not all modifiers support only applying to a certain part of an object\, and unfortunately, subdivision surface modifier does not support vertex group. In that case you have to cut your object into parts (bisect, knife, loop cut, etc, then select one part, then separate by selection), and then that modifier can only apply to an entire object, then you join the two objects back together.

Lets say we have a cylinder and we want to subdivision surface modifer at level 3 on one end of the cylinder to make that end more rounded. We will do the above procedure:

![](https://i.imgur.com/cD6Qxrd.png)

Loop cut then select those faces at the end of the curriculum:
![](https://i.imgur.com/b2mKgzC.png)

Separate by selection:
![](https://i.imgur.com/Jwlh9z3.png)


Switch to Object Mode (tab), and select the end part of cylinder
![](https://i.imgur.com/g5f7TwP.png)

Press CTRL+3
![](https://i.imgur.com/oodzwJm.png)

  

Select both parts and join them back together into one object![](https://i.imgur.com/ayF13Wn.png)

  

Final:
![](https://i.imgur.com/tONj7XW.png)


---

An alternate procedure is combining bevel and smooth modifiers which do support vertex groups. However, the result does not follow faithfully to how a subdivision looks:

[https://blenderartists.org/t/pseudo-subdivision-limited-to-vertex-group/1309632](https://blenderartists.org/t/pseudo-subdivision-limited-to-vertex-group/1309632)