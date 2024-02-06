
Here I see the right clavicle is missing in Pose Mode:
![](https://i.imgur.com/Fwg9Jet.png)

But when I switch to Edit Mode, the bone isn't hidden;
![](https://i.imgur.com/wxxdvDE.png)

The reason why is you had accidentally hidden a bone, probably from accidental shortcut key.

At the Outliner, select the bone in the mode where it's NOT hidden. Make sure you're at the bone properties.

Switch back to the editor mode where it's hidden. Then untick "Hide" under "Viewport Display".
![](https://i.imgur.com/XfV3rcj.png)

---

Explanation: Remember that hiding bones persists to the editor mode you're in. The reason why you have to select the hidden bone in the editor mode it's visible in is because of a quirk in Blender 4.0. You can't select the bone in the Outliner if it's hidden, so you have to switch to an editor mode where it's not hidden. Then you can select the bone and switch to the editor mode it's hidden, so you can untick "Hide" in the options. The options only appear for what you selected in outliner

At the same time, another quirk is it isn't clear if it fails to select the bone because of the above glitch. Notice here:
  ![](https://i.imgur.com/Ue3dS41.png)
- Even though shoulder.R is selected at the Outliner, the bone property shows the name spine.004 (I had actually selected spine.004 previously before I selected shoulder.R. This means the selection didn't go thru and Blender didn't have an invalidated color or any visual cue of the failure)
- 