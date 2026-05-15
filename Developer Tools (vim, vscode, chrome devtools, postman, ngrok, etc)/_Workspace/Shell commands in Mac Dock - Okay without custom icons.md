Sometimes you want an icon in the Mac's Dock that launches shell scripts. For example, you have a script to spin up n8n for local development. You don't want it running all the time in the background because of it affecting computer performance.

You are okay without it having a custom icon

---

Create Folder "Dir-Shortcuts" inside Applications/
![[Pasted image 20250617005608.png]]

Open that folder. Then open in terminal or copy the pathname by right-clicking on the breadcrumbs at the bottom status bar.
![[Pasted image 20250617005631.png]]

Using terminal, you can quickly: Create .sh file. Make sure to `chmod u+x`  on it.
![[Pasted image 20250617005703.png]]

Modify the .sh file content to your use case.

Test that double clicking the `run.sh` which will later be the equivalent of clicking the terminal icon inside of Dock - that it doesn't open XCode. If it does open XCode, you may want to choose Terminal as the default application:
![[Pasted image 20250617012013.png]]

Make alias (aka shortcut) of run.sh:
![[Pasted image 20250617010946.png]]

Rename shortcut:
![[Pasted image 20250617011001.png]]

Drag the shortcut from the finder into the Docker:
![[Pasted image 20250617010647.png]]

The final result is:
![[Pasted image 20250617010750.png]]

Tada!

---

Shortcuts will be obeyed in Finder folder but it will be ignored in Dock!

Google for then download the icon for your specific application and place into the same folder, eg. n8n:
![[Pasted image 20250617011043.png]]

Right-click shortcut → Get Info. Then click the icon of the file in the Info panel so that the icon is selected in the Info panel:
![[Pasted image 20250617011115.png]]

Copy that icon file to your clipboard (CMD+C):
![[Pasted image 20250617011043.png]]

Then paste into where the Info panel's icon is selected (CMD+V). It'll swap in your file into the icon:
![[Pasted image 20250617011219.png]]

As a result, the Finder will update the shortcut/alias' icon. And if you drag the newly minted shortcut to the Dock, it appears the new icon will be placed into the Dock:
![[Pasted image 20250617011309.png]]

But once you let go, the icon defaults back to:
![[Pasted image 20250617010750.png]]


---

How about dockutil to see if new icon sticks?

> Quick review: Dockutil is used to add shortcuts to the Dock using terminal. You have to have it installed first with `brew install dockutil`

Running either `sudo dockutil --add /Applications/Dir-Shortcuts/n8n` or `sudo dockutil --add /Applications/Dir-Shortcuts/n8n` produced the same defaulted terminal icon



