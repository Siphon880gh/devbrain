
Required knowledge:
- Know how to create variables. Refer to [[Create object variables in Unreal]]
- Know how to animate character or object movement. Refer to [[Movement or rotation x1 vs looping]]
- Know how to convert an object into Blueprint. Refer to [[Fundamental - Convert object to Blueprint]]


Setup:
- Make sure to set the player's viewport into the custom cinecamera actor below, so you wont be seeing by default from PlayerStart or behind the character (if third person map). Refer to: [[Camera that starts with the level]]

You'll create a cinecamera actor (Placed Actors panel) into the level. You'll convert it into a Blueprint from the Outliner/Details panels

You'll animate the path using similar nodes to [[Movement or rotation x1 vs looping]]

![](https://i.imgur.com/pNn2MLi.png)

Except, when linking the vector track outlet and primary outlet from Timeline node into the next node, you'll be linking to Set Actor Location. This is because the camera object is a special classification Actor

*Optional Reading:*
For deep dive theory on why Set Actor Location for Actor Objects, why there are actor objects, versus non-actor objects which use Set Relative Position, refer to [[Deep Theory - Actor vs Non Actor and Their Location Nodes]]

----
