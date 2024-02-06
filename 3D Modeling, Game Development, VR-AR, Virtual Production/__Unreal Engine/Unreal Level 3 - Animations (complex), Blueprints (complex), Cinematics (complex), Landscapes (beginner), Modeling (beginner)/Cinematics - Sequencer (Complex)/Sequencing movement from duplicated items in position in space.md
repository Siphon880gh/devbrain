

Why
When animating complicated paths like Captain America’s shield or Link’s boomerang, you may want to simulate the movement by piloting the camera with timemarks showing and also see the item duplicated along the path - giving you an idea of the spatial and the timing.

Big Picture

When sequencing movement and rotation, you can duplicate the object across the map into positions you like with the shortcut keys. So you have one original item and multiple duplicated items making a path of where you want the original item to travel when animated with the sequencer.

Then for each item you copy the movement and rotation (you can right click and copy all three components for movement, and also all three for rotation). Paste into text file which becomes a special code

During sequencer transformation you can carefully move the current timeline indicator and transform with the positions pasted back into that one original item (not the duplicated items)

You’ll remove the duplicated items later.

In terms of getting the time just right, you can Play then pilot the camera along the objects’ path and have the elapsed time like 0, 0.1, 0.2, 0.3, 0.4, and write down on paper what you think the key times should be. You’ll have to repeatedly pilot the camera along the path until you have all the times recorded.

Setting up elapsed time to record the proper timemarks

Duplicate an item along the space where you will animate them into positions over time: OPT+SHIFT click and drag on location axes of the object. Now you have duplicates of that object in the path it will take.

You will setup a countup 0.0, 0.1, 0.2... 1, 1.1, 1.2,... While you pilot the camera, to get a sense of the exact timemarks your keyframes will be for the animation.

In your Level Blueprint, have a countdown every 0.1 second. Keep playing and restarting until you figure out the rough time marks (eg. 0 for first position, 1.2 for second position, 2 for third position, etc).

![](https://i.imgur.com/sdMEX42.png)

Have a variable elapsed that’s Float type

Your showElapsed function:
![](https://i.imgur.com/JQdfIv6.png)

  

Select the original item in position 0. Add that to Sequence.  Click second item and copy their location, rotation and scale into any text editor using the Right Click → Copy, because you will be pasting back in reverse order for your new keyframe. 

Eg. Here I am copying the rotation
![](https://i.imgur.com/wYzbB3G.png)




Click the original item in the Outliner and then click the same original item in the Sequencer (they should both be highlighting the same item they represent), and you will be manipulating this original item to animate through the positions of the other duplicated items. 

Move Sequence current cursor into half or quarter a second later (will be for all future positions at this interval because a much later step will be to change the time position). 

Now paste from text each line over to corresponding Location/Rotation/Scale from text editor back into Unreal Engine. 

Finally, click keyframe icon of Transform (not the individual components Location/Rotation/Scale). Now scrub left and right on the timeline to make sure it animates the new keyframes and if it doesn’t, then the copy and pasting didn’t go through (Unreal can be finicky)

Repeat process next by clicking the duplicated item in the second position. Then repeat process for the next duplicated item in the third position

```
(X=-2300.000000,Y=-540.000000,Z=400.000000)  
(Pitch=-8.523313,Yaw=-19.567991,Roll=-100.383474)  
(X=0.150000,Y=0.150000,Z=0.150000)
```


Do a final scrubbing to animate the path of movement (Playing will probably be a quick movement).

Then it’s time to adjust the times: Adjust each keyframes’ time. 

Approaches recommended:
If entering precise times:

Change one of the keyframes (either location, rotation, or scale) in the vertical:
![](https://i.imgur.com/Vh2pOvl.png)

Then drag the other two to line them up
![](https://i.imgur.com/gWwtoCS.png)

=>

![](https://i.imgur.com/YXgmkYu.png)

Approximation approaches:

- If only have two timemarks you had recorded from the timer experiment: Work on the first and final keyframes, then drag the intermediate keyframes to what positions may make sense.
- If you are going to estimate all timemarks, then just drag each set of keyframes into positions

If Unreal Engine is finicky and dropping your keyframe value changes from the Properties, you can enter the exact value on the left of Sequence with a keyframe selected. You can also drag left/right on these values:

![](https://i.imgur.com/JalDYFQ.png)

Use the duplicates’ distance from each other and whether you want equal speed through the entire path, to help approximating.

Another visual assistance for the approximation is the dots along the path line. It shows as long as the object is highlighted on the left of the Sequence. The dots correspond to the keyframes

![](https://i.imgur.com/XYZBEX1.png)

Once done with the first approximations, remove the duplicate objects at the same time (multiple select in Outliner), then hit play to watch the original object animate across the map. If you need the duplicates back into position for reference, you go to Edit → Undo History