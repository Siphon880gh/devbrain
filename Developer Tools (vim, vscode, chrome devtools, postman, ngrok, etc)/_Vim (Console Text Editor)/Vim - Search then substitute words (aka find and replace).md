In Vim, find and replace **all matches in the whole file**:

```vim
:%s/old/new/g
```

Example:

```vim
:%s/foo/bar/g
```

Meaning:

```text
%   = every line in the file
s   = substitute
old = text to find
new = replacement text
g   = replace every match on each line
```

Without `g`, Vim only replaces the **first match on each line**:

```vim
:%s/foo/bar/
```

To confirm each replacement one by one:

```vim
:%s/foo/bar/gc
```

Then Vim will ask you:

```text
replace with bar (y/n/a/q/l/^E/^Y)?
```

Common answers:

```text
y = yes
n = no
a = all remaining
q = quit
```

To replace only between specific lines:

```vim
:10,20s/foo/bar/g
```

To replace the word only, not parts of longer words:

```vim
:%s/\<foo\>/bar/g
```