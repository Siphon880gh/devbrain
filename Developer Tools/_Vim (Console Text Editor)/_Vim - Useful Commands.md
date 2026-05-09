
`vi` / `vim` is a useful CLI text editor for quickly editing, creating, and reading text files directly from the terminal.

It is also useful when working with more advanced Git CLI commands. For example, Git may open a temporary text file in Vim so you can edit a commit message, rewrite commit history, or adjust an interactive rebase list.

---

# Vim Has Modes

Vim works differently from normal text editors because it has different modes.

The two main modes beginners need to know are:

- **Insert Mode** — for typing and editing text
- **Command Mode** — for running Vim commands and shortcuts

---

# Switching Between Modes

## Go from Insert Mode to Command Mode

Press:

```vim
Esc
```

This exits Insert Mode and brings you back to Command Mode.

## Go from Command Mode to Insert Mode

Press:

```vim
i
```

or:

```vim
a
```

Difference:

- `i` = insert text **before** the cursor
    
- `a` = append text **after** the cursor
    

Think of `a` as **append**.

---

# Insert Mode

When you are in **Insert Mode**, Vim acts more like a normal text editor.

You can:
- Type text
- Edit text
- Move the cursor with arrow keys
- Use copy/paste shortcuts, depending on your terminal or shell

For example, `Cmd+C`, `Cmd+V`, `Ctrl+Shift+V`, or right-click paste may work depending on your terminal.

Important note: Vim’s internal copy/paste commands, like `yy` and `p`, are not always the same as your system clipboard copy/paste, like `Cmd+C` and `Cmd+V`.

---

# Command Mode

When you are in **Command Mode**, you can run commands in two ways:
1. Type commands at the bottom of the screen
2. Press shortcut keys directly


---

# Typing Commands with `:`

In Command Mode, press:

```vim
:
```

This lets you type a command at the bottom of the CLI screen.

After typing the command, press:

```vim
Enter
```

to run it.

Common commands:

```vim
:wq
```

Writes/saves the file and quits Vim.

```vim
:q!
```

Quits Vim without saving.

To cancel out of the command line, press:

```vim
Esc
```

or leave it blank and press `Enter`.

---

# Deleting Lines with `:`

You can delete lines by typing delete commands at the bottom of the screen.

## Delete all lines

```vim
:%d
```

This deletes every line in the file.

The `%` means “the whole file.”

## Delete a range of lines

```vim
:1,4d
```

This deletes lines 1 through 4.

Pattern:

```vim
:start_line,end_line d
```

Examples:

```vim
:10,20d
```

Deletes lines 10 through 20.

## Delete current line:

```
:d
```

^Or instead of typing double-colon commands, press commands with: `dd`
## Delete a specific line

```vim
:5d
```

Deletes line 5.

## Advanced: Delete from this line to the end of the file:

**From Current Line to End:** `:.,$d` (the dot `.` represents the current line and `$` represents the end of the file).

---

# Pressed Commands: Manipulate Lines with Delete/Move, Yank/Copy, and Change Line

In Command Mode, you can press shortcut commands directly.

Vim has a pattern:

```vim
action + target
```

For example:
- `d` = delete, which could also move if you paste to another line. Does not affect OS clipboard.
- `y` = yank, which means copy. Does not affect OS clipboard.
- `c` = change
- More details below

The target can be a line, word, character, paragraph, and so on.

---

# Line Commands

## Delete/move a line

```vim
dd
```

Deletes the current line.

This means: delete the whole line.


Optional: Then you can paste it at another line (press up/down on keyboard to select different line) with:

```vim
p
```

to paste below the current line, or:

```vim
P
```

to paste above the current line.


## Yank/copy a line

```vim
yy
```

Copies the current line into Vim’s internal clipboard/register.

Then usually you want to paste it at another line (press up/down on keyboard to select different line) with:

```vim
p
```

to paste below the current line, or:

```vim
P
```

to paste above the current line.

## Change a line

```vim
cc
```

Deletes the current line and puts you into Insert Mode so you can immediately replace it by typing text.

This means: change the whole line.


---

# Word Commands

The same idea works with words.

## Delete a word

```vim
dw
```

Deletes from the cursor forward to the next word boundary.

## Change a word

```vim
cw
```

Deletes from the cursor forward to the next word boundary, then puts you into Insert Mode so you can replace it.

## Yank/copy a word

```vim
yw
```

Copies from the cursor forward to the next word boundary.

Then you can paste it with:

```vim
p
```

or:

```vim
P
```

---

# Mnemonic

To remember these:

- `d` = delete
    
- `c` = change
    
- `y` = yank/copy
    
- `w` = word
    

So:

```vim
dw
```

means delete word.

```vim
cw
```

means change word.

```vim
yw
```

means yank word.

When the command is doubled, it usually applies to the whole line:

```vim
dd
cc
yy
```

That means:
- `dd` = delete line
- `cc` = change line
- `yy` = yank/copy line

---

# Jumping Around by Pressing Commands

These are movement shortcuts you can press in Command Mode.

```vim
w
```

Jumps forward one word.

```vim
b
```

Jumps backward one word.

```vim
$
```

Jumps to the end of the current line.

This is easy to remember if you know Regular Expressions, where `$` means the end of a line.

```vim
^
```

Jumps to the start of the current line.

This is also similar to Regular Expressions, where `^` means the start of a line.

---

# Searching in Command Mode

Searching is a mix of typing a command and pressing shortcut keys.

In Command Mode, press:

```vim
/
```

Then type what you want to search for.

Example:

```vim
/token
```

Press:

```vim
Enter
```

to search.

Then use:

```vim
n
```

to go to the next match.

Use:

```vim
N
```

or `Shift + n` to go to the previous match.