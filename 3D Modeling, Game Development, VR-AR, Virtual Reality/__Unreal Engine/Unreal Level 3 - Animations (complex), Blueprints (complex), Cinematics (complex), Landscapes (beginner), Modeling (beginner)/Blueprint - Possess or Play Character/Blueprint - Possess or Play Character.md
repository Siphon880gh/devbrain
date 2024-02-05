
Problem: You imported a model, dropped it into Unreal Editor, but you want to control that as a playable character. 

Solution: 
- First make sure it has bones/rigged/skeleton. If not, you have to add the rig at Blender (Use Rigify, then Automatic Weights) and refer to Blender tutorial on rigging.
- Secondly, make sure there's no PlayerStart and the game mode default class is set to DefaultPawn. The settings will be covered in a later section.


## 1. Place character

Place character

Yes, it’s character, not pawn or actor. Refer to [[Theory - Actor extends to Pawn extends to Character]]

![](https://i.imgur.com/D0fk4h6.png)

  
Change its Static Mesh to your preferred model mesh

Convert to Blueprint. You may want a particular Blueprint that has a boom camera if you want third person:

![](https://i.imgur.com/jsSXd5t.png)


Adjust the boom and camera settings and character orientation so that the camera view will show the character

The result is:
![](https://i.imgur.com/7stLpjV.png)

In addition, you want to check that Mesh and Character_Blueprint overlaps each other:
![](https://i.imgur.com/gN10WAB.png)

..by making sure the axis are in the same spot regardless of clicking Character_Blueprint or Mesh

![](https://i.imgur.com/BKdMykg.png)
Otherwise, your location or overlap triggers won’t work as expected (it wouldn’t necessarily be your character mesh triggering it, it would be the blueprint coordinate themselves)

---

## 2. Settings
  
No PlayerStart. Go to World Settings → Selected GameMode → Default Pawn Class: Default Pawn

In Character Blueprint’s options, make sure “Auto Possess Player” is disabled:

![](https://i.imgur.com/tu2tvdF.png)

---

## 3. Possess the character

  
Open Level Blueprint

When level starts, the player will possess the character

In other words: At BeginPlay, the target Player 0 will possess input pawn

Nodes:
- Begin Play
- Possess   
    INPUT Target: Get Player Controller at 0  
    INPUT In Pawn: Character Blueprint

You drag and drop the character blueprint from Outliner into the Blueprint Event Graph to produce “Character_Blueprint” example here:

![](https://i.imgur.com/1odIm7b.png)

Above all learned from:

[https://forums.unrealengine.com/t/how-do-i-use-a-character-pawn-in-place-of-the-player-start/480991/3](https://forums.unrealengine.com/t/how-do-i-use-a-character-pawn-in-place-of-the-player-start/480991/3)

---

## 4. Testing and considerations for more steps

Press Play and walk around

If you need your character to perform locomotion animation with its arms and legs, then there are more steps involved. If your character is appropriate to be gliding as you move, then you are fine.

If you need your character to have locomotion animation, then you’ll need to add a blend space that combines idled animation with walk forward animation and also interpolates your movement speed to the two animations. Refer to [[Blendspace - Idle to forward walking animation playing third-person character]]


---

Reworded:
Third person character you control
Involves Player Controller and Pawn and Possess
https://www.youtube.com/watch?v=UXFl_yWQjLs

Btw character objects are a subclass of Pawn already, so they can be possessed.