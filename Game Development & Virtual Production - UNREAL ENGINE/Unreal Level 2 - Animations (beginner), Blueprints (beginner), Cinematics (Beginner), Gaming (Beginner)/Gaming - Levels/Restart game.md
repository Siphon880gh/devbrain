Are you restarting after a game over screen? Then refer to: [[Add Game Over Screen]]

---

You'll create a restart and if needed, give control back to user:

![](https://i.imgur.com/98wUlh3.png)

^For Open Level, make sure the Level Name exactly matches the filename of the level. Look at the tab of your level editor or the root level of Outliner:
![](https://i.imgur.com/Izvw2Sn.png)

---

The hiding the mouse cursor and giving control back over the game was optional unless you came from an ui screen that you had to point and click with your mouse.

If thats the case, you'll want to hide the cursor and give player control back to the game  ("Set Input Mode Game Only" node). Since you reopened the level, the widget disappears. But reopening the level does not reset Player Controller settings, so you must give player control back to the game; otherwise, your pawn will appear frozen and you can't control the game navigation. You can copy and paste nodes from when you made the widget appeared, then just reverse the settings.