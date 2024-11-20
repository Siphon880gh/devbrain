When you run `git commit` or `git rebase -i HEAD~10` etc, the terminal kicks you into an in-terminal text editor, and usually it's nano or vi/vim, so you make the changes on a multiline way, then git applies your settings.

If you have a preferred editor, you can set it.

Eg. Say we like vi:
```
git config core.editor "vi"  
```
  
Then to confirm, at any git repo on the server, run this command to see if it kicks you into the preferred editor:
```
git rebase -i HEAD~2
```
