In Vim, you can turn line numbers on or off from normal mode using `:set`.

### Show line numbers

```vim
:set number
```

This displays line numbers on the left side of the editor.

### Hide line numbers

```vim
:set nonumber
```

This removes the line numbers.


---


## Shorthand Commands

Vim also supports shorter versions of the same commands.

### Show line numbers

```vim
:set nu
```

^ This is the shorthand for: `:set number`

### Hide line numbers

```vim
:set nonu
```

^ This is the shorthand for: `:set nonumber`

---
## Quick Reference

| Action            | Full Command    | Shorthand   |
| ----------------- | --------------- | ----------- |
| Show line numbers | `:set number`   | `:set nu`   |
| Hide line numbers | `:set nonumber` | `:set nonu` |