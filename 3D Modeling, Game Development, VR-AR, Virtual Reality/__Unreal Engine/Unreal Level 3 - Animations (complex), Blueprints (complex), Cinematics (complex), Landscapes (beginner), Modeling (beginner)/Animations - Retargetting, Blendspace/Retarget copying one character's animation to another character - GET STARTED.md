
Learned retargetting from:
https://www.youtube.com/watch?v=N7WdyAeeDrw

## Use cases
- You want an animation to play copying from another character’s animation
- After you possess a character and you move it, you see it’s gliding along instead of using any walk forward or locomotion animation.

Solution - Retargetting:
- You can retarget one character’s animations to your new character’s animation. This is fine as long as they’re similar shapes. At the retargeting editor, you can adjust their bones and posture to match more closely.
- How: IK system is a kinetic chain where you match a chain of bones in one character to another character, and you match all the chains (Imagine spine to head, a shoulder to hand x2, a hip to feet x2). This is inspired from the principles of kinesiology where the human has posterior chain that helps them lift objects, etc

May consider needing more solutions - Retargetting, then Blendspace:
If you input a character to move and the character blends in animations from idled to walking, and the walking is blended with how fast the character moves, this is a blendspace, and you would need to do a blendspace solution after retargetting solution.
In this case, also refer to [[Content/Dev/curriculum/Game Development & Virtual Production - UNREAL ENGINE/Unreal Level 3 - Animations (complex), Blueprints (complex), Cinematics (complex), Landscapes (beginner), Modeling (beginner)/Animations - Retargetting, Blendspace/Blendspace - Idle to forward walking animation playing third-person character]]

---


## Assets

Character Requirements:
You have a source character whose associated animations you want to copy. For humanoid target characters, unreal has mannequin or quin that are good source. Make sure source character has bones/armature/skeleton
Make sure target character has bones/armature/skeleton

Three IK assets:
- IKRigFrom
- IKRigTo
- IKRig Retargeter (Looks at the same chain names then match them up!)

You right click content drawer → Animations → IKRig or IKRig Retargeter. 

You’ll make two IKRig, one for the source character (aka IKRigFrom), and the other for your target character (aka IKRigTo). You don’t have to name it exactly as such.

---

## Chaining

Firstly, go into either IKRigFrom or IKRigTo. Set your appropriate skeletal mesh (its associated animations would follow in if any)


Then you chain. Click Add New Chain.
![](https://i.imgur.com/9ge4J9k.png)

You chain at IKRigFrom and IKRigTo

Tips:

- Each IKRig you select the from character or the to character (that needs the animations)
- Set a root at each IKRigs *?
- In one IKRig, the first chain should be the same number of items away from the root as the other IKRig
- Same number of chains from both IKRigs. And the chains are named the same.
- Have Goal set to none
  
Example:
![](https://i.imgur.com/FhYT86k.png)


\* Setting root:
![](https://i.imgur.com/6RdSFZ3.png)

---

## Retargetting
Retargeter might look funky. Some possibilities - one model is intrinsically a lot larger than the other, or they’re not in the same pose (I pose vs A pose vs T pose). You can adjust here their preview. 

In this example, the unreal mannequin is our source and the beach guy model is the target because the beach guy model we would like to have the same animations (whether just playing standalone animation -or- blending animation while walking character) as the mannequin’s

![](https://i.imgur.com/b1EKHXA.png)

Have retargeter match the chains. If you had named the chains exactly the same between the two IKRigs, it’d be automatically done

![](https://i.imgur.com/LiEPdXF.png)

Start testing if the target character preview animates properly at the Asset Browser. Try out some animations.

![](https://i.imgur.com/durkcZB.png)

![](https://i.imgur.com/EZ9qrAL.png)

Decide on which animations to export (see “Export Selected Animations” in Asset Browser). If you’re blending animations when walking user, you need idled and walk forward.

---

## Summary. More solutions needed if..

You've dropped in a model into the viewport model. If you just need a character to animate when the game starts or blueprint triggers it, you now have animation assets to do so. You could set the animation asset in the character's Details panel, or you can select the animation in a blueprint.

But if your character is something the player controls and you expect the character to be running around with their arms and legs swinging: You need to add Blendspace animations.

Briefly, a blendspace animation allows your character to go from idled animation to walk forward slow animation or to walk forward fast animation. It does this by lerping between idled position and walk forward position based on your character speed as you control the character, blending two animation assets. And futhermore, the walk forward animation speeds up as your character's movement speeds up, lerping even further.

