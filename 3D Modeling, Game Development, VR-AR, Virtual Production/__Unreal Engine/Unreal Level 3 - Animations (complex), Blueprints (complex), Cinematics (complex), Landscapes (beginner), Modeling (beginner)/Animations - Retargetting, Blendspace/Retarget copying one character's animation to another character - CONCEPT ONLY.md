

**CONCEPT ONLY**


You can easily share over animation, poses, and movement patterns (when controlling character as pawn) from one character to another character. This is useful when you have a model imported in that needs animations (you can copy off mannequin or quin’s animations)

The problem is the bone/skeleton might not match exactly between the two character. Unreal Engine has a retargeting system that allows you to conform some bones/joints of one character to the other character even if they’re in different proportions or different poses (I pose vs T pose vs A pose)

Reworded: You have two characters that are not exactly the same. One character is taller than the other. Or the pose is inconsistent causing both’s rigs to differ at the arms (T pose vs A pose, for example). But you want the second character to use the first character’s animation without distortion.

Requirement: Both models must have bones. If your imported model does not have bones, you have to add bones/armature in Blender, aka Rigging. If you need to do so, refer to Blender tutorial on rigging.

---

**FK vs IK**

Background because you may see the words FK or IK in Unreal

FK system is superseded by the new IK system.

In Unreal Engine, "IK" in "IK Rig" stands for "Inverse Kinematics." Inverse Kinematics is a technique in animation and robotics used to determine joint movements and rotations needed to place the end of a limb or chain of joints in a desired position. This contrasts with the older Forward Kinematics (FK), where the movement of each joint is set individually, and the final position of the limb is the result of these joint movements. IK is particularly useful in real-time applications like games, where it allows for more dynamic and adaptive animations.


UE4 FK system (forward kinetics):  
[https://youtu.be/zWCFcyDe1Tg](https://youtu.be/zWCFcyDe1Tg)  
  
UE5 IK system (inverse kine):  
[https://www.youtube.com/watch?v=N7WdyAeeDrw](https://www.youtube.com/watch?v=N7WdyAeeDrw)  
[https://www.youtube.com/watch?v=GYbUmI_KPVs](https://www.youtube.com/watch?v=GYbUmI_KPVs)  
Is more tedious because you have to set the target root (make sure makes sense between both IK Rigs, and you have to set chain between parent and child bones. The same chains between the two characters will make sure animation is similar when retargetting is done. This mimics how in real life human body has posterior chain for lifting objects, etc.  
The process is more accurate and fluid but is more tedious. UE said they will improve workflow