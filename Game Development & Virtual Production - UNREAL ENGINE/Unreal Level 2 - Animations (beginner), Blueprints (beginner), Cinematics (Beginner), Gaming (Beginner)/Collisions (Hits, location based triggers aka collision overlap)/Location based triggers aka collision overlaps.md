
## Overview

Briefly:
Think of them as collision overlap event between two objects and at least one object allows overlap. For instance, you have your pawn that can bump into objects. Your pawn walks into a cube that can be walked through (aka allows overlap). In this intersection, an event called Overlap gets triggered in the Blueprint, then you can run nodes off that. 

There are a few overlap events:
- ActorBeginOverlap
- ActorEndOverlap
- Event Tick but you check "Is Overlapping Actor" which checks if two actors are overlapping

Which Blueprint you implement nodes from:
- Level Blueprint
- The overlappable area/cube

Keypoints:
- The area must be set to generate overlap events (in their details) and likely as Overlap All.


---

## Setup Overlappable Cube

Create a cube where the user will walkthrough. If it's short and only the feet passes through, that's fine as well.

Collision presets -> Overlap all. This makes the shape walkthroughable.

Tick "Generate overlap events" in details. Otherwise it won't be able to be caught as an event in the Blueprint

Untick "Can Character Step Up On".

You should also make this shape invisible. Change material to.. typing for Invisible of Translucent.

---

## Know how to get your player in the Blueprint
If your pawn is generated on game start, you can't select it in outliner to edit the settings but you can try "Get Player Pawn" or "Get Actor of Class" which requires you to know the class name of the spawned pawn. If you need help finding the spawned pawn's class to search for on Content Browser, look into the World settings for what pawn class is generated from (Window->World Settings->Selected game mode -> Default pawn class). 

For more details, refer to: [[Get player's spawned character (PlayerStart)]]


----

## Make sure types are correct

Both the cube and the character are actor blueprints. If you have a character from a spawn like Player Start, that one already is. 

You can check if your cube is an actor at Outliner under Type (Should be called StaticMeshActor or StaticMeshActorBlueprint).

Make sure to convert to Blueprint. Refer to [[Fundamental - Convert object to Blueprint]]


---

## Implement based on desired behavior

### Run on every entry regardless of player pawn or actor
If you want to run once everytime your character walks into the cube overlap area:
From the cube's blueprint:
![](https://i.imgur.com/N89oA75.png)

That will allow overlap with any other actor to trigger the string. But if you need to be specific about which actor especially if it's multiplayer and only one player can trigger the area based script:

### Run on every entry for specific actor
For running only once per entry into the area from a specific actor.
From the walkthroughable cube's blueprint:
![](https://i.imgur.com/q9ykyMQ.png)

You want to check that the Other Actor that overlaps is equal to (Search for Equal node) the actor from your typed class name. And if they are equal, then we trigger the script.

### Run on exit of overlapped area
You follow instructions on "Run on every entry", the appropriate section based on whether you need it to be a specific actor or any actor. The Event node would be: "Event ActorEndOverlap" instead of "ActorBeginOverlap"

### Continuously run as long as inside the overlap area
It makes more semantic sense to use the Level Blueprint

![](https://i.imgur.com/bc0pdJa.png)

Every tick seconds, it'll look at whether two actors are overlapping each other (which requires one actor to be overlappable/walkthroughable - which in our case is the cube). No need for further explanation because this is an implementation of what was learned up to this point.

----

## Case study

This is a demo where you can walk up to a shoe. There is an invisible cube on top of the white platform of the second shoe. You walked in for a few seconds then ran back out towards the camera. Here is the blueprint of that invisible cube:
![](https://i.imgur.com/litkSlB.png)

This is what's printed on screen:
![](https://i.imgur.com/UVXeKuU.png)
