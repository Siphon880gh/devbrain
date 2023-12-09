
SETUP: Know how to add graphics to the screen. Refer to [[Adding temporary stats to screen]]

^ If setup correctly, so far you have:
![](https://i.imgur.com/enisYu5.png)

---

Sneak peak:

I. The next steps are to show the mouse, then switch the player's controlling ability from the game to the widget (game over screen). If you skipped switching the player's controlling ability, your mouse will be present but it will move the game perspective as if you're still playing, and you won't be able to interact with the widget.

II. Then you make the button interactive, causing it to restart the game onClicked.

---
I. Show the mouse cursor and switch player control onto the widget:

![](https://i.imgur.com/3phmu6M.png)

Set Show Mouse Cursor -> Set Input Mode UI Only
- 1. Tick on: Set show mouse cursor
- 1. Input: Target is Player Controller (You might want a precedent "Get Player Controller"
  
- 2. Input: Player Controller (You might want the same precedent "Get Player Controller")
- 2. Input: "In Widget to Focus" connected to "Return Value" output of past node "Create New Widget Blueprint Widget"
- 2. Select for "In Mouse Lock Mode": "Lock on Full Screen"
 
---

II. Then you make the button interactive, causing it to restart the game onClicked.

Back at the widget designer, have the button selected, then look for "On Clicked" event at the Details panel
![](https://i.imgur.com/yTb8Ndx.png)

![](https://i.imgur.com/SHs1WfR.png)

That opens another Event Graph specific to that part of the widget. You'll create a restart and change control back to user:

![](https://i.imgur.com/98wUlh3.png)

^For Open Level, make sure the Level Name exactly matches the filename of the level. Look at the tab of your level editor or the root level of Outliner:
![](https://i.imgur.com/Izvw2Sn.png)

You'll want to hide the cursor and give player control back to the game  ("Set Input Mode Game Only" node). Since you reopened the level, the widget disappears. But reopening the level does not reset Player Controller settings, so you must give player control back to the game; otherwise, your pawn will appear frozen and you can't control the game navigation. You can copy and paste nodes from when you made the widget appeared, then just reverse the settings.