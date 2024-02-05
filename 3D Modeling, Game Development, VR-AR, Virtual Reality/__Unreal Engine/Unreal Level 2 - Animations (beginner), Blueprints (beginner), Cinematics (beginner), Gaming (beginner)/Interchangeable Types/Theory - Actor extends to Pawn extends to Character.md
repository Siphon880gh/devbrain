
You may need to know these technicalities for possessing character, changing inputs, etc:
![](https://i.imgur.com/l4eZHVd.png)


An Actor is an object that can be placed or spawned in the world

A Pawn is an actor that can be possessed and receive input from a player controller

A Character is a type of pawn that includes the ability to walk around

With each extension or inheritance, it carries over the attributes of its parent.

---

Mnemonic: APC
Asian Pacific Community

---

Who has rigs/bones/skeletons

In Unreal Engine, Pawns are one of the base classes used for controlling actors within the game world, particularly those that can be controlled by players or AI. They are part of Unreal Engine's Gameplay Framework, which provides a way to manage game characters and their interactions.

Pawns themselves do not inherently have a rig or skeleton because they are not specifically designed to represent complex animated characters. Instead, a Pawn can be thought of as a basic game entity that can be possessed and controlled. The actual visual representation of a Pawn, including any rigs or skeletons for animation, would be part of a Mesh Component (such as a Skeletal Mesh Component) that is attached to the Pawn.

For animated characters, you would typically use a Character class, which is a subclass of Pawn specifically designed to work with skeletal animations. Characters come with additional functionality for animation and movement, including a built-in Skeletal Mesh Component and support for animations through the use of Animation Blueprints. This allows you to define the visual appearance of your character, complete with a rigged skeleton for animation.

In summary, while Pawns themselves don't have rigs, you can attach a Skeletal Mesh Component to a Pawn to provide it with a visual representation that includes a rig. For characters that require animation, it's more common to use the Character class, which is designed to support rigged and animated models out of the box.

---

Mnemonic for pawn not having bones/skeleton/rigs

Think of making a chess game. You can possess one of the chess pawns to move them across the level (chess board in this case). And so can AI for their pawns, bishops, etc. 
However the pawns don't need complex animations (outside of rotating and translating which are done in blueprint set location and set rotation). Therefore, you can remember it has no bones/rigs.