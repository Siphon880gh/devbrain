## Problem

FileZilla makes it easy to move files and folders by dragging and dropping them.

However, depending on your mouse or trackpad sensitivity, this can become a problem.

Look how easy it is to trigger a move action:

![[Pasted image 20260519070801.png]]

If your mouse is too sensitive, even clicking a folder to open it can accidentally turn into a small drag-and-drop action. This may happen when the click includes a slight scroll, pan, or movement before you release.

This is especially common on a Mac trackpad or Magic Mouse.

There has been developers complaining about this exact problem, inadvertently moving files and folders elsewhere while clicking folders inside Filezilla:
- https://trac.filezilla-project.org/ticket/2191#no1
- https://oscarg.ws/filezilla-causing-outages-drag-and-drop

---

## Quick Rescue

### If you know what was moved

Find where the accidentally moved folder ended up:

```bash
find . -type d -name "app1"
```

Find where the accidentally moved file ended up:

```bash
find . -type f -name "app1-README.md"
```

### If you do not know what was moved

Look at the **Last modified** column for which folder has recently been modified - that'll be where you accidentally moved a file or folder to. You may need to refresh the folder view first. You can do this by leaving and re-entering the folder, or by right-clicking an empty area in the folder pane and choosing **Refresh**.

Or if you have a backup, you can also compare the folder trees:
- Folders on the same drive:
	- As long as both folder copies are unarchived and available on the same server, use the command `diff -ru folderA folderB` referring to [[Tree diff on two folders]].
- Folders are not on the same drive
	- Run `tree -L 1` at both terminals (local pwd terminal and remote SSH terminal). if tree command not found, you can install with your OS package manager. Tree command outputs both the tree and the numbers of directories and files.
		- 1. Compare the number of directories and files at the bottom of output (below the tree)
		- 2. Copy output from both terminals to a diff checker like https://diffchecker.com. It will point to file/folder differences in the tree.
		- 3. Once you identified missing files or folders, find where they are accidentally moved to with:
			- find . -type d -name "app1"
			- find . -type f -name "app1-README.md"

---

## Permanent Fixes

- Lower your mouse or trackpad sensitivity to reduce the chance of accidental drag-and-drop moves.
    
- Disable drag and drop permanently in FileZilla. As of May 2026, FileZilla does not appear to have a normal settings option for this, but there may be a config-file workaround. Search Google for the latest instructions before editing the config file.
    
- Probably not worth it: increase the FileZilla font size so rows are larger and you are less likely to drag one file or folder onto another row. Unfortunately, FileZilla does not have a built-in font-size option as of May 2026. You may be able to make the text larger through your operating system’s global font settings, but that can negatively affect the rest of your apps.
    
- Not available: FileZilla does not have an option to show a confirmation dialog before moving a file or folder into another folder. This has been requested since the early 2010s. FileZilla’s official position has generally been that keeping the app cross-platform makes this difficult or technically impossible, though from a developer perspective, that explanation is debatable.

---
## Prevention Tips

Multi-select in this way: Select one file, then while holding shift, press on keyboard up or down. This is instead of holding Shift while clicking with your mouse to select files all inbetween.
- If you need to exclude a folder or file in the middle of the selected files, then just upload in two phases. First phase is the bottom half and the second phase is the top half.

Upload/download in this way: Right-click the selected file(s) then download or upload. This is instead of dragging to another pane.

Enter folder in this way (Because if you double click the folder, you might risk moving the folder elsewhere rather than entering the folder if the mouse is sensitive or glitchy causing a drag and release while Filezilla is sensitive to even small distance drag and releases):
- Do not double click a folder
- Instead, select the folder, then press Enter.
- If it's not quite the folder you selected, clicking another folder is ok especially if the folder is far away from what's already highlighted. You can also use up and down arrow to choose another folder. But remember you can rapidly type the first few characters of the folder's name you intend to select, and it'll select the closest match

When selecting a folder
- Click a folder might risk moving it if your mouse settings are bad
- If that's the case: You can use up and down arrow to choose a folder. But remember you can rapidly type the first few characters of the folder's name you intend to select, and it'll select the closest match