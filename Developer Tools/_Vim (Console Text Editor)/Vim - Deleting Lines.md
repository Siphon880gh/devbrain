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