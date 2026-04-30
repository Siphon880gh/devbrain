## Goal:
Learn when and how to use:
- type
- file

## Example:
Imagine you joined a new team that already has Linux servers set up.

You know the `view` command opens files in a terminal text editor, but you do not know which editor this server is using. On one system, `view` may point to Vim. On another system, a sysadmin may have configured it differently based on the team’s preferred terminal editor.

This is where two helpful commands come in:

* `type`
* `file`

The `type` command tells you what the shell understands a command to be. It can tell you whether something is a real executable file, a shell builtin, an alias, or a function.

Start with:

```bash
type view
```

Example output:

```bash
view is /usr/bin/view
```

This tells you that when you type `view`, the shell is running `/usr/bin/view`.

Next, use the `file` command to inspect what `/usr/bin/view` actually is:

```bash
file /usr/bin/view
```

Example output:

```bash
/usr/bin/view: symbolic link to /etc/alternatives/view
```

This shows that `/usr/bin/view` is not the final program. It is a symbolic link pointing to another path.

Now inspect that next path:

```bash
file /etc/alternatives/view
```

Example output:

```bash
/etc/alternatives/view: symbolic link to /usr/bin/vim.basic
```

Now you can see the full chain:

```text
view
→ /usr/bin/view
→ /etc/alternatives/view
→ /usr/bin/vim.basic
```

So in this example, `view` ultimately opens files using `vim.basic`.

This also tells you something important about the system. On this Ubuntu-based server, `view` is being managed through `/etc/alternatives`, which usually means it can be changed with:

```bash
sudo update-alternatives --config view
```

However, do not assume every Linux system uses `update-alternatives`. The better habit is to trace the command first:

```bash
type view
file /usr/bin/view
file /etc/alternatives/view
```

Then decide how that specific system manages the command. This makes it easier to work on unfamiliar servers without guessing which editor is actually being used.

---

## `file` Command - Comprehensive Review


Yes. `file` can show when something is a symbolic link, but it does more than that.

The `file` command inspects a file and tells you what kind of file it appears to be.

It can identify many other file types, such as:

```bash
file /usr/bin/vim.basic
```

Example output may look like:

```bash
/usr/bin/vim.basic: ELF 64-bit LSB pie executable, x86-64
```

That means the file is a Linux executable program.

It can also identify text files:

```bash
file /etc/nginx/nginx.conf
```

Example output:

```bash
/etc/nginx/nginx.conf: ASCII text
```

Or compressed files:

```bash
file backup.tar.gz
```

Example output:

```bash
backup.tar.gz: gzip compressed data
```

So in this `view` example, we are using `file` to follow symbolic links. But more generally, `file` helps you answer:

```text
What kind of file is this?
```

That makes it useful when you are inspecting unfamiliar systems, commands, scripts, binaries, config files, or downloaded files.