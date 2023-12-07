The important node is "Set View Target with Blend". It's blending the Player Controller's view target with the Camera's view target, having the Camera's view target take over. 

To get the Player Controller, you use their "Get Player Controller" at the player index that's appropriate (0 if you're the only player).

![Screenshot](https://i.imgur.com/zk7Zint.png)