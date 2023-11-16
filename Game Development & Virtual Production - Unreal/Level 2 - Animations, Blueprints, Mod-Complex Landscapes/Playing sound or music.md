
Just search for sound in Content Drawer (CTRL+Space)
Then drag and drop into level viewport. Placement relative to camera will affect where you hear the sound as a player (left, right, stereo mix)

Let’s say the sound starts immediately when playing. To have it stop after 3 seconds (for example, a character walking for 3 seconds while grunting sound):

Convert sound element to Blue Print

Edit in Blue Print → Go to Event Graphdelay

From BeginPlay, you add a Delay of 3 seconds. On completion of the delay, you stop audio targetting Audio Component (which is on the level)

![](https://i.imgur.com/cPBaFAI.png)

Weng’s tutorial (Go to last part):
https://youtu.be/YajlbmK-Wso?t=252
4:13

Challenge assignment: What if it’s a music background. How do you make it loop from start of the game till the user exits?