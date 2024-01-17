A simpler form of the "You Win" screen (no button interaction, no restarting game):
[https://youtu.be/ZpQmL_TzSPo?si=d9EvSsvST-ZbYs9S](https://youtu.be/ZpQmL_TzSPo?si=d9EvSsvST-ZbYs9S)  
Great for health stats, etc on the screen

---
 
1. Create a widget:
Content Drawer → New → User Interface → Widget Blueprint

2. Make your screen widget designable:
REQUIREMENT: Add a canvas first otherwise it wont allow you to combine image (as a background) and text
Adding canvas: 0:30 Same Video https://youtu.be/ZpQmL_TzSPo?t=30

3. Design your screen widget: Go under Common on the left sidebar

Add image: 0:45 Same video

Add background color
You just add an image that isn’t linked to an actual image, and then you set its background color
0:45 Same video

Add text
1:23 Same video

Add button 
3:13 Same video

Add button with text/label
Button inherently doesn't have text/label. You have to add another text element over it

4. Trigger the screen with blueprint
Suggestions: Can have it show on start. Can be a you walk into an area, then it triggers the new screen elements (In which case, refer to [[Overlap Collision triggers - aka Location triggers]] - EventActorBeginOverlap)


The process of showing the designed widget on the screen is as follows:
![](https://i.imgur.com/CsGHDLK.png)

^ You are creating a new widget in the game from memory, so you have to select the class. You're gonna search for the exact class as the widget you created from Content Drawer
^ Then you will pipe the created widget to the "Add to Viewport" which will add the widget in addition to the screen you're seeing. So this is NOT a "Set the Viewport with Blend"
