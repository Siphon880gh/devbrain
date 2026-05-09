## Yanking, Cutting, and Pasting Lines in Vim

In Vim, **yanking** means copying text. You can quickly copy a line, move somewhere else, and paste it.

## Yank / Copy One Line

To copy the current line:

```vim
yy
```

You can place your cursor anywhere on the line before typing `yy`.

Then move your cursor to where you want to paste the copied line.

To paste the copied line **below** the current line:

```vim
p
```

To paste the copied line **above** the current line:

```vim
P
```

Example:

```vim
yy
p
```

This copies the current line and pastes it below your cursor.

---

## Cut / Delete Text

In Vim, deleting text also works like cutting text because the deleted text can be pasted afterward.

To cut/delete the current line:

```vim
dd
```

Or:

```vim
:d
```

To cut/delete multiple lines:

```vim
Ndd
```

^Replace `N` with the number of lines you want to delete.

Example:

```vim
5dd
```

This deletes 5 lines.

---

## Paste Text

To paste the last yanked or deleted text **below** the current line:

Lower case p -
```vim
p
```

To paste it **above** the current line:
Upper case P -
```vim
P
```


---

## Important: Vim `p` Is Not the Same as OS Clipboard Paste

Vim’s `p` command pastes from Vim’s internal register, which is like Vim’s own clipboard.

This is **not always the same clipboard** used by your computer when you press:

```text
Cmd + C
```

or the usual macOS paste shortcut:

```text
Cmd + V
```

So when you type:

```vim
yy
p
```

Vim is copying and pasting **inside Vim**, not necessarily copying to your Mac’s system clipboard.

Think of it like this:

```text
yy = copy into Vim's clipboard/register
p  = paste from Vim's clipboard/register
```

Whereas:

```text
Cmd + C = copy into your computer/system clipboard
Cmd + V = paste from your computer/system clipboard
```

This matters when copying text from Vim into another app, such as Obsidian. In many Vim setups, `yy` does **not** automatically make the text available to paste into Obsidian with `Cmd + V`.


---

## Mnemonic

To remember `yy` and `dd`, think of the first letter as the action:

```vim
yy
```

`y` means **yank**, which means **copy** in Vim.

```vim
dd
```

`d` means **delete**, which works like **cut** because the deleted line can be pasted somewhere else.

The reason you press the key twice is because Vim uses an **action + motion** pattern.

For example:

```vim
yy
```

means:

```text
yank this whole line
```

And:

```vim
dd
```

means:

```text
delete this whole line
```

So the repeated key tells Vim to apply that action to the **current line**.

Whereas:
```
dw
```

Means
```
delete this word
```