
The difference between two coordinates in the level editor is not the same as the delta you would set to move across that distance in blueprint event graph

\<<
I duplicated the text and put the second text where I want it. I then compared the two X values between the texts subtracting them to figure out the delta. When I play, it goes in the direction I wanted, but it went way passed

It looks like the difference between the textrender and the desired text render location (via a duplicate placed in desired location) is off to an entirely different scale than the offset delta


\>>
If the difference (delta) between the current location of your TextRender actor and the desired location seems to be on a different scale than expected, there are a few potential issues and solutions to consider:

1. **World vs. Local Coordinates**: Ensure that you're working in the correct coordinate system. If you're using world coordinates, the positions should be relative to the entire game world. If you're using local coordinates, they're relative to the actor's parent or origin. Mixing these up could result in vastly different scales.

2. **Scale Factor**: Check if there is a scale factor applied to either of the TextRender actors or their parents. If one actor is scaled differently than the other, their world coordinates will not directly correspond to each other.

3. **Blueprint Logic Check**: Re-examine your Blueprint logic. Ensure that the way you're calculating the delta and applying it to the actor's position is consistent and correct. It might be helpful to add some debug outputs to print the current position, the target position, and the calculated delta to the screen or log during play.

4. **Use of Delta in Timeline**: If you're applying the delta through a Timeline, make sure that the values in the Timeline are set up correctly. The Timeline should interpolate from 0 to 1 (or -1 to 0, depending on direction), and this value should be multiplied by the delta when setting the actor's new location.

5. **Movement Over Time**: If the movement is meant to occur over a period of time, ensure that you're accumulating the delta over that time, rather than applying it all at once. This is especially important if the movement logic is in a Tick event or similar.

6. **Unintended Accumulation**: Be cautious of unintended accumulation of movement. If you're adding to the actor's position every frame or every tick, the total movement might be much larger than the initial delta calculated.

7. **Precision Issues**: Unreal Engine uses floating-point numbers for positions, which can sometimes lead to precision issues, especially if you're working with very large or very small numbers. This is less likely to be the problem, but it's worth keeping in mind.

8. **Debugging Tools**: Utilize Unreal's debugging tools, like the Visual Logger or Blueprint debugging, to visually inspect the actor's movement and the values being calculated. This can give you a better understanding of what's happening during runtime.

By systematically checking these aspects, you should be able to identify the mismatch in scale and correct the issue. Remember, debugging complex movement logic can sometimes be a process of trial and error, so patience and careful examination of each step in your logic are key.