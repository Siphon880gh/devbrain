In Vim, you can find and replace text using the substitute command:

```vim
:s/old/new/
```

This replaces `old` with `new` on the **current line only**.

Example:

```vim
:s/foo/bar/
```

This replaces the first `foo` on the current line with `bar`.

---

# Replace All Matches in the Whole File

To find and replace **all matches in the whole file**, use:

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

---

# Confirm Each Replacement

To confirm each replacement one by one:

```vim
:%s/foo/bar/gc
```

Then Vim will ask:

```text
replace with bar (y/n/a/q/l/^E/^Y)?
```

Common answers:

```text
y = yes
n = no
a = all remaining
q = quit
l = replace this one, then quit
```

---

# Replace Only Between Specific Lines

To replace text only between certain line numbers:

```vim
:10,20s/foo/bar/g
```

This replaces every `foo` with `bar` from line `10` through line `20`.

---

# Replace Only Whole Words

To replace a word only, not parts of longer words:

```vim
:%s/\<foo\>/bar/g
```

This replaces:

```text
foo
```

But it does **not** replace `foo` inside longer words like:

```text
foobar
myfoo
food
```

Meaning:

```text
\< = start of word
\> = end of word
```

---

# Use `#` Instead of `/`

Vim substitution usually uses `/`:

```vim
:%s/old/new/g
```

But you can also use `#` as the separator:

```vim
:%s#old#new#g
```

This is useful when the text contains `/`, such as file paths or URLs.

Example:

```vim
:%s#/images/logo.png#/assets/logo.png#g
```

This is easier than escaping every slash:

```vim
:%s/\/images\/logo.png/\/assets\/logo.png/g
```

Both commands do the same thing, but the `#` version is much easier to read.

---

# Case-Insensitive Replace

To ignore uppercase and lowercase differences, use `i`:

```vim
:%s/foo/bar/gi
```

This replaces:

```text
foo
Foo
FOO
```

with:

```text
bar
bar
bar
```

Meaning:

```text
i = ignore case
```

---

# Count Matches Without Replacing

To preview how many matches would be replaced, use `n`:

```vim
:%s/foo/bar/gn
```

Meaning:

```text
n = count matches only, do not replace
```

This is useful before doing a large replacement.

---

# Replace in Selected Lines

You can also replace text only in visually selected lines.

1. Press `V` to enter Visual Line Mode.
2. Select the lines.
3. Type:

```vim
:s/foo/bar/g
```

Vim will automatically turn it into something like:

```vim
:'<,'>s/foo/bar/g
```

Meaning:

```text
'< = start of visual selection
'> = end of visual selection
```

---

# Common Vim Replace Commands

```vim
:s/foo/bar/
```

Replace first `foo` with `bar` on the current line.

```vim
:s/foo/bar/g
```

Replace all `foo` with `bar` on the current line.

```vim
:%s/foo/bar/g
```

Replace all `foo` with `bar` in the whole file.

```vim
:%s/foo/bar/gc
```

Replace all `foo` with `bar` in the whole file, but confirm each one.

```vim
:10,20s/foo/bar/g
```

Replace all `foo` with `bar` from line 10 to line 20.

```vim
:%s/\<foo\>/bar/g
```

Replace only the whole word `foo`.

```vim
:%s#old/path#new/path#g
```

Use `#` instead of `/` when replacing paths or URLs.

```vim
:%s/foo/bar/gi
```

Replace all matches, ignoring case.

```vim
:%s/foo/bar/gn
```

Count matches without replacing them.