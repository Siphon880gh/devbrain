
You want one node to lead to two nodes running one after another
![](https://i.imgur.com/nL0hxMz.png)


Use a sequence node which has one inlet and two outlets
![](https://i.imgur.com/xAas8ps.png)

---

**Create a Sequence for Multiple Connections**: Say you want to connect "Event BeginPlay" to two different nodes, you'll need a "Sequence" node. This node allows one input to trigger multiple outputs in a sequence. Right-click on the graph, search for "Sequence", and add it to the blueprint.  

The "Sequence" node has multiple output pins (Then 0, Then 1, etc.). Gs. Let’s say you are controlling a character but you also want an animation running at the same time. Connect the first output (Then 0) to the "Cast to PlayController", and connect the second output (Then 1) to the "Timeline" node that begins the animation (For animating movement, refer to [[Animate character or object movement, Times One, or Loop Alternately (5.3)]].  

Btw you can add more sequence nodes by clicking “Add pin”.

---

Remember that although this lets you connect to multiple nodes, that they are ran in order:

> The Sequence node in Blueprints works by executing its output pins in order, one after another. When the Sequence node is triggered, it starts with the first 'Then' output pin (Then 0), completes the execution of all the connected nodes on that pin, and then moves on to the next 'Then' output pin (Then 1), and so on.
> 
> It does not execute the branches connected to its Then pins simultaneously. Each branch must complete before the next branch starts. This sequential execution allows for controlled, step-by-step execution of different parts of your Blueprint script.