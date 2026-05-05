# The `view` Command: Open Files Without Picking an Editor

The `view` command is useful because it gives sysadmins a simple, generic way to open a file from the terminal without needing to remember whether the system prefers `vi`, `vim`, `nano`, or another editor.

Many Linux distributions include the `view` command. macOS Terminal often has it too.

In many cases, `view` is linked to the system’s default terminal text editor, often Vim. However, the sysadmin or operating system can point it to a different terminal editor.

To open a file, run:

```bash
view FILE
```

For example:

```bash
view /etc/nginx/nginx.conf
```

On many systems, this may behave similarly to:

```bash
vim FILE
```

However, the exact editor depends on how the system is configured.

---

## How to Set `view` to Another Editor using update-alternatives

On Ubuntu-based systems, `view` is often managed through the `update-alternatives` system.

You can choose which program should run when you type `view` by running:

```bash
sudo update-alternatives --config view
```

You may see something like this:

```bash
There are 2 choices for the alternative view (providing /usr/bin/view).

  Selection    Path                Priority   Status
------------------------------------------------------------
* 0            /usr/bin/vim.basic   30        auto mode
  1            /usr/bin/vim.basic   30        manual mode
  2            /usr/bin/vim.tiny    10        manual mode

Press <enter> to keep the current choice[*], or type selection number:
```

Type the number for the editor you want, then press **Enter**.

---

## How to Reverse-Engineer What `view` Is Using So You Can Set `view` on Any System

These commands help you trace where `view` comes from on the current system. This is useful when you need to understand which terminal editor `view` is actually using, especially on a new server or a system that may not use `update-alternatives`.

Start with:

```bash
type view
```

Example output:

```bash
view is /usr/bin/view
```

Now inspect that file:

```bash
file /usr/bin/view
```

Example output:

```bash
/usr/bin/view: symbolic link to /etc/alternatives/view
```

Then inspect the next link:

```bash
file /etc/alternatives/view
```

Example output:

```bash
/etc/alternatives/view: symbolic link to /usr/bin/vim.basic
```

So, on this Ubuntu-based system, the path resolves like this:

```text
view
→ /usr/bin/view
→ /etc/alternatives/view
→ /usr/bin/vim.basic
```

That means `view` is ultimately pointing to Vim Basic through the `update-alternatives` system.
