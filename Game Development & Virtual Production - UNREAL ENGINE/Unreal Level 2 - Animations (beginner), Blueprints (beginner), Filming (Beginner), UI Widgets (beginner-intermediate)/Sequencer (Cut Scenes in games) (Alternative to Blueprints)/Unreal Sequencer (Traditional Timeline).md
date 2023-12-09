
Instead of using Blueprint to lerp your camera positions and rotations with nodes, you can use Sequencer which has a traditional timeline and keyframing like in other video editing software

![](https://i.imgur.com/R5UQq7o.png)

Bottom will open up a timeline
![](https://i.imgur.com/glzGsjq.png)

Have a cinecameraactor in position to shoot the first keyframe of your cut scene. Then drag from the Outliner to the bottom left of the Sequencer panel:
![](https://i.imgur.com/9RihgH5.png)


Now you can set timeframes on aperture, focal length, focus distance / location, rotation, and scale!
![](https://i.imgur.com/6WRryjB.png)

Hot tips: 
- ALT/CMD + Scroll up/down to zoom on the timeline
- Click the diamond between \<- and -\> to add a keyframe where you like the cinecameraactor is currently on at your level editor
- Click the arrows to jump to keyframes. To delete a keyframe, you can zoom in on the keyframe until it's clickable, right-click -> Delete key
- Magnet icon button is for toggling snapping

You can adjust easing:
![](https://i.imgur.com/Jue7ate.png)

---

Playing the sequence as part of a game or movie does require some Blueprint, but very minimal (unlike having to have timeline/lerp/set location nodes):

![](https://i.imgur.com/ij0FaHk.png)

![](https://i.imgur.com/ozIPKbl.png)

You are creating a Level Sequence Player, whose input Level Sequencer has a thumbnail dropdown of your saved sequences. Then you pipe out to a "Play To" node.

Finally, your sequence (select it from Outliner), must have Autoplay on. Next to it is Looping (Dont loop, Loop indefinitely, Loop x times)

---

## Troubleshooting - Can't find the sequence in outliner to enable Autoplay

If you cannot find the sequence in the Outliner, search for it in Content Browser, then drag and drop into the level editor viewport. It'll become accessible in the Outliner now.


---

## Practicality - Cut Scenes

You can play cut scenes in your game. Or you can play a movie

---

## Practicality - Export Movie

At the Sequencer you can export a movie directly:


![](https://i.imgur.com/fBVoHnJ.png)


You can preemptively open the output directory:
![](https://i.imgur.com/BsneFeL.png)

If you're on Mac, it would export movie files to:
/Users/{User}/Documents/Unreal Projects/{ProjectName}/Saved/VideoCaptures