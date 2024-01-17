
## Two methods but Lerp way better

**Friendlier**: Door Opens with Lerping the Rotation (with Alpha Float Track to control animation steps)
Timeline Float 0 to 1 → Lerp → Set Relative Location (Scene Component)

Lerping is a lot easier because you can just type in the X Y Z values directly instead of shift+clicking on the buggy timeline editor's vector tracks

![](https://i.imgur.com/Klmb9xz.png)

**Not as friendly**: Door Opens with Primarily Tracks (Requiring manipulating keyframes for specific values)

So if you dont like the result of a level play, you have to go back into the Timeline Editor’s track and play with the keyframes’ specific values. It’s slow. And often you need to reset the view horizontally and horizontally. Not user friendly.

![](https://i.imgur.com/pJPuYu6.png)

  

---

## Lerp Practice

The easy practice in this case is to see the two locations by duplicating the object of interest to your desire location (Shift+OPT drag). Now you can easily have two coordinates when you select one after another. Then in your blueprint event graph, you copy the two coordinates into a lerp node. And as a quick reminder, the lerp node has its steps controlled by a precedent timeline node. The track is the float track from one time point to another time point with the float value 0 to 1. That flow track is inbounded into the alpha input at the lerp node, meaning 0 is taking no animation steps and 1 is having taken all the animation steps. 

## Lerp Alphas

Alpha is really steps so your keyframes are Float track at some seconds value 0, then some seconds later value 1, representing taking no steps towards all steps to completion over the number of seconds.
![](https://i.imgur.com/C5uMWsP.png)

## Namesake - Lerp

**Linear interpolation**, or “lerp” for short, is a technique commonly used when programming things like games or GUIs. In principle, a lerp function “eases” the transition between two values over time, using some simple math.


## ## Misc - If needed

##### How to Lerp:

[https://www.youtube.com/watch?v=wWjLpSxGpz0](https://www.youtube.com/watch?v=wWjLpSxGpz0)