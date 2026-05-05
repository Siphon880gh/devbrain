The `history` command is a simple but powerful way to see the commands you recently ran in your shell as well as to run any previous command it listed. 

When you type `history`, the terminal shows a numbered list of past commands. Each command has an ID, which makes it easy to rerun something without typing it again.

For example:

```bash
% history
  997  cd app
  998  git branch
  999  git status
 1000  gitc "Updated context"
 1001  cd ..
```

In this example, each number on the left is the command’s history ID. You can rerun a specific command by typing an exclamation mark followed by that ID. For example, `!999` runs `git status` again.

If you want to rerun the most recent command, you can use `!!`. Another common shortcut is pressing the Up Arrow key to scroll to the previous command, then pressing Enter to run it again.

These shortcuts are useful for speeding up terminal work, especially when repeating long commands or revisiting something you just ran.