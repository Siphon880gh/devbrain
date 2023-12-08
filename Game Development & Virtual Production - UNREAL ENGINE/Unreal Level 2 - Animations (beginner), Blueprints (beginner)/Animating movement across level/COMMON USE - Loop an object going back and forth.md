
A common use in games is a platform that goes left to right and right to left repeatedly. It's a flattened cube actor likely

Required knowledge:
Timeline with float -> Lerp vector -> Set World Location


Now you will be adding more nodes to the right
1. Add a Delay node that's as long as the first movement. 
2. After this delay is completed, it goes to Flip Flop.
3. Flip Flop A will run first. You want A to play reverse direction. Connect Flip Flop's A outlet to the Timeline's "Reverse" inlet
4. Flip Flop B will run in the forward direction. Connect. Flip Flop's B outlet to the Timeline's "Play from Start" inlet.
5. There on, when it reaches Flip Flop, it will run A, B, A, B...

Yes this means your right most node is Flip Flop and that it will connect backwards to some node Timeline on the left.

![](https://i.imgur.com/kytaUGN.png)
