
![](https://i.imgur.com/RcwdREo.png)


--> Changes to

![](https://i.imgur.com/YEf9Sax.png)

For that planar mesh, you want to go into Geometry Nodes module.


With the planar mesh selected in outliner, go into Geometry Nodes (primary menu)
![](https://i.imgur.com/l9muVvy.png)

Make sure to click new document for the Geometry Nodes panel
![](https://i.imgur.com/jP4hyuu.png)

![](https://i.imgur.com/fcysxFY.png)
If you break the connection, notice the mesh disappears. This is similar to DaVinci resolve input/output time-directional nodes
![](https://i.imgur.com/BwQaR2i.png)

Add a new node by right clicking empty area. Add -> Instances -> Instance on Points
![](https://i.imgur.com/4wJcyi5.png)


Drag and drop the object you want to duplicate at the points from Outliner into the Geometry Nodes panel. Lets have a sphere from the outliner dropped into the Geometry Nodes panel
![h4k8K6K.png](https://i.imgur.com/h4k8K6K.png)



![](https://i.imgur.com/xw4YuFR.png)



![8ZVLvc7.png](https://i.imgur.com/8ZVLvc7.png)



![](https://i.imgur.com/CQpOaYZ.png)


If you messed up, you can select a node and press X to delete.

Now we connect the nodes in such a way that the original mesh gets filtered into an Instances of points, and those Instances of points take the sphere's object, then piped into the final output

![](https://i.imgur.com/Df73bf1.png)

Application: And if you have a screw object along the points of a mechnical shape, it'll look like a technical part with screws (aka rivets)

![](https://i.imgur.com/QIJahia.png)


Learned from:
https://www.youtube.com/watch?v=m81mFjpbLa4