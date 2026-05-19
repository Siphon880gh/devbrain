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

Or if you have a backup, you can also compare the folder trees, as long as both copies are unarchived and available on the same server. Refer to [[Tree diff on two folders]].

---

## Permanent Fixes

- Lower your mouse or trackpad sensitivity to reduce the chance of accidental drag-and-drop moves.
    
- Disable drag and drop permanently in FileZilla. As of May 2026, FileZilla does not appear to have a normal settings option for this, but there may be a config-file workaround. Search Google for the latest instructions before editing the config file.
    
- Probably not worth it: increase the FileZilla font size so rows are larger and you are less likely to drag one file or folder onto another row. Unfortunately, FileZilla does not have a built-in font-size option as of May 2026. You may be able to make the text larger through your operating system’s global font settings, but that can negatively affect the rest of your apps.
    
- Not available: FileZilla does not have an option to show a confirmation dialog before moving a file or folder into another folder. This has been requested since the early 2010s. FileZilla’s official position has generally been that keeping the app cross-platform makes this difficult or technically impossible, though from a developer perspective, that explanation is debatable.