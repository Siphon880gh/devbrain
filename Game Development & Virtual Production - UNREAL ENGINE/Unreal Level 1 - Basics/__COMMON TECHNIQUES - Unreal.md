

Editor common techniques:
- Convert any object into blueprint so you can access their Blueprint Viewport or Event Graph
- Differentiate between blueprint viewport vs blueprint event graph
	Refer to [[Convert object into Blueprint - FUNDAMENTAL]]
- Context Sensitive - if can't find the node, ticked off "Context Sensitive":
![](https://i.imgur.com/leXb5Hn.png)

- Move mouse over if more than one node choice with the same name, so you can choose the correct node that you expect to have certain input/output types
![](https://i.imgur.com/BR1YCTQ.png)

- PlayStart's spawned pawn referenced in Blueprint
Refer to: [[Get player's spawned character (PlayerStart)]]
- Get actor for any class name
Refer to: Get actor from class name
- Level Blueprint, Know how to open Level Blueprint for more game level logic (makes sense to put there than other objects' blueprints)
Refer to: [[Open Level Blueprint]]


Object manipulation common techniques:
- Duplicate object in viewport:
	  Refer to [[Duplicate object in viewport - Fundamental]]
- Duplicated object in viewport. Edit a blueprint without editing both blueprints simultaneously:
	Refer to [[Duplicated object in viewport - Edit a blueprint without editing both blueprints simultaneously - GOTCHA]]
- Invisible object - make object invisible or translucent
	Refer to [[Make an object invisible]]
- Placing two objects close to each other:
When you want to move two objects to be close to each other (maybe even overlapping or at least adjacent to each other). You can put them in the same location, size, rotation by copying and pasting, then you adjust the coordinates.
![](https://i.imgur.com/Rv67lr3.png)


	
- Components - How to have an object moved along with an actor component in the blueprint viewport, aka component (aka anchoring aka fixing)
	Refer to Level 2's Component* folder
