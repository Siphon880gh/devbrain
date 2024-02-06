Make sure you have the "Object: Bool Tool" plugin enabled under Edit->Preferences->Add-ons. If you check its shortcuts, keep in mind that Bool Difference is Ctrl + Shift + Numpad Minus. If you just installed now, you have to restart Blender even if it didn't ask you to (else the cutting by Boolean Difference shortcut won't work).

In **Object Mode**, select your **Plane + Model**
**Shift+CTRL+Numpad Minus**
This only works if you had the "Object: Bool Tool" plugin enabled under Edit->Preferences->Add-ons


![](https://i.imgur.com/K9yWfWb.png)

Overlap two shapes:

![](https://i.imgur.com/hQHx8zP.png)

Selected both:
![](https://i.imgur.com/zv87ubw.png)

After shift+ctrl+numpad minus:
![](https://i.imgur.com/pcDgLJt.png)

![](https://i.imgur.com/vegylTt.png)


---

Use case:
Basic bowl in the form of a half opened sphere.

Hint: Create UV sphere. Create cube. Overlay at center 0,0. Negative boolean. Select face of inner face. X to delete face. R->Y to rotate into upright position bowl.

![](https://i.imgur.com/um7jGqh.png)

You can go further:
![](https://i.imgur.com/otMs2at.png)
