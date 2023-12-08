
Figuring out the animation times to set your lerp values or  timeline vector tracks

Reworded: need to adjust your lerping or keyframes for your actors over time?

### Timeline node while in simulation will show seconds elapsed

Just keep the blueprint event graph opened and click "Play"

![](https://i.imgur.com/Wzaz3Tg.png)


Notice Playing @ s
That tells you at what point of the timemarks

Or

### Set Timer to print seconds elapsed while playing

Have elapsed seconds when playing. Unreal 5.3 does not support this, so you have to create a setTimer to show elapsed seconds. Refer to [[Blueprint repeated timer]]

^ There is a "Get Game Time in Seconds" that you can cast into a string for "Print String"