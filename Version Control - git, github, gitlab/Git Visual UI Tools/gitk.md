`gitk` is a graphical tool for browsing Git history. It gives you a visual way to inspect commits, branches, merges, and file history instead of reading everything in the terminal.

It can easily be invoked from your current working directory with the command `gitk`, and then it opens the ui app:
![[Pasted image 20260409073451.png]]

**Why is it called `gitk`?**  
The `k` comes from **Tk**, the GUI toolkit used to build it. Tk is part of the older **Tcl/Tk** framework, so `gitk` basically means a Git viewer built with Tk.

Do not confuse it with **GitKraken**, which is a separate Git GUI application. GitKraken has its own interface and tooling. It is not the same as `gitk`. It's called with the command `gk` instead.

**Install on Mac**

```bash
brew update
brew install git-gui
```

**Common commands**

```bash
gitk
```

Open the current repository’s commit history in the GUI.

```bash
gitk --all
```

Show commits from all branches, not just the current one.

```bash
gitk --since="2 weeks ago"
```

Show only commits from the last two weeks.