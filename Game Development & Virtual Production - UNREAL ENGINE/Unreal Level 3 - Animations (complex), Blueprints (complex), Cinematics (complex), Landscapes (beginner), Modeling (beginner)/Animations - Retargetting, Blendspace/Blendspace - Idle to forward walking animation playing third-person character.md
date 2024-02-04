
Learned blendspacing for character locomotion animation when in motion
[https://www.youtube.com/watch?v=WUXvq6At6pE](https://www.youtube.com/watch?v=WUXvq6At6pE&t=235s)

---

If your character is something the player controls and you expect the character to be running around with their arms and legs swinging: You need to add Blendspace animations.

Briefly, a blendspace animation allows your character to go from idled animation to walk forward slow animation or to walk forward fast animation. It does this by lerping between idled position and walk forward position based on your character speed as you control the character, blending two animation assets. And futhermore, the walk forward animation speeds up as your character's movement speeds up, lerping even further.

Requirements: Idled animation asset, Walk forward animation asset. Character must have bone/skeleton/rig.

How the blend space is connected to your character:
Instead of animation asset, you set an "animation blueprint" which allows for more logic. In the animation blueprint, you can track the speed of the character being controlled by player, and feed it into blendspace.

Assets besides your character:
- Idled animation asset
- Walk forward animation asset
- blendspace asset
- animation blueprint asset

---


## Create Blendspace
Right click in content drawer → Animation → Blend Space. Pick the appropriate skeleton (your target) so it can blend in your animations with that character

Open the Blendspace editor (by double clicking the blendspace asset in Content Drawer)

Set the Horizontal Axis min and max as appropriate. 0 and 500 are good numbers
![](https://i.imgur.com/xNRP3ol.png)

^For information on what’s horizontal axis vs what’s vertical axis, refer to appendix

Drop Idled to Walk Forward animations into the keyframe timeline from 0 speed to 500 speed:
![](https://i.imgur.com/ACkLygd.png)

## Create Animation Blueprint

Back at view port editor, set Animation Mode to Use Animation Blueprint. We’ll need to create an animation blueprint that we can set this to (Will come back to this as the last step in this section).
![](https://i.imgur.com/58ylVEn.png)



Right click in content drawer → Animation → Animation Blueprint. Pick the appropriate skeleton (your target) so it can manage its complex animations including blueprint appropriate to the skeleton

Open the Animation Blueprint editor (by double clicking the animation blueprint asset in Content Drawer)

Note there are two modules - Anim Graph and Event Graph

### 1. Anim Graph

![](https://i.imgur.com/IHRDUFI.png)

^ Default node is Output Pose. Feed it the blendspace (from Asset Browser panel). Right click the Speed → Promote to variable

### 2. Event Graph

#### **2a/c. Initialize tracking character on map**

![](https://i.imgur.com/zPFf0Eg.png)

![](https://i.imgur.com/e8LNFKq.png)

^Perform proper casting of the pawn owner (aka the character which inherited pawn class - aka the character that the animation blueprint will belong to). When properly casted, you promote it to a variable for the next nodes - See where red circle is, you would right click and promote to variable


#### **2b/c. Blend**

![](https://i.imgur.com/wc9EJ3A.png)

**^** You get the velocity of the playable character we’re tracking. That velocity is a vector of direction and speed  at x,y,z so we convert it into a length, and unreal does the pythagorean formula to solve into a float value for speed; hence we have nodes “Get Velocity” and “Get Length”. We save this value to the variable “Speed”.  
^ At every animation update tick, we are updating the variable “Speed” that Anim Graph feeds into Blendspace


Quick review:

To have a node that sets the speed, you drag and drop the variable into the Event Graph, then select “Set Speed” from the resulting context menu

![](https://i.imgur.com/oE9ieqR.png)

![](https://i.imgur.com/Lo3s57j.png)

Node underlying theory: You can ask ChatGPT to prove the above statements with  [In unreal engine "Get Velocity" node represents speed and direction of x, y, and z? Then "Vector Length" node uses pythagorean theorem to find the hypotenus value representing the actual speed in the 3d movement?]

#### **3c/c. Finalize at viewport editor**

Finally, back at the viewport editor, under the character’s Details panel, set the animation blueprint we just finished working on.

---

## Final Walk to Test Blendspace

Test the character animation from idled to walking slowly to walking fast. If funky, you have to do more tweaking. Refer to second half of this video:

[https://www.youtube.com/watch?v=WUXvq6At6pE](https://www.youtube.com/watch?v=WUXvq6At6pE)

---

## Appendix: Blendspace Axes

The horizontal axis in a Blend Space is one of these user-defined parameters. You can configure it to represent any variable, but commonly it's used for things like the character's speed or turning rate. For instance, in a simple 1D Blend Space used for character movement, the horizontal axis might represent the character's speed, where one end of the axis represents standing still, and the other end represents full speed running. As the character's speed changes, the Blend Space blends between the standing and running animations accordingly.

For a 2D Blend Space, which allows for more complex blending based on two parameters, the horizontal axis could be used alongside a vertical axis to blend animations in two dimensions. For example, in a character movement Blend Space, the horizontal axis might represent speed (from standing to running), while the vertical axis might represent direction (turning left to right).