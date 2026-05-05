## Why You See `ll` in So Many Linux Tutorials

You may see the `ll` command in a lot of Linux, sysadmin, and cloud tutorials. But be careful: **`ll` may not be available by default on your Linux distro or macOS terminal**.

That is because `ll` is usually **not a real standalone command**. It is usually a shell alias, commonly pointing to something like:

```bash
ls -l
```

or:

```bash
ls -la
```

You may see `ll` in AWS, cloud, hosting, or DevOps tutorials, but it did **not** originate from those companies. It became popular because many sysadmins like using short aliases for commands they type often.

## What `ll` Usually Does

Most of the time, `ll` is a shortcut for a longer `ls` command.

For example:

```bash
ls
```

shows normal filenames.

But:

```bash
ls -l
```

shows more detail, including:

- file and folder permissions
    
- ownership
    
- group ownership
    
- file size
    
- modification date
    
- filename
    

That is why sysadmins often prefer the long listing view when checking files on a server.

## Important: Hidden Dot Files

If `ll` is only aliased to:

```bash
ls -l
```

then it **does not show hidden dot files**, such as:

```bash
.env
.htaccess
.gitignore
```

To show hidden files, you still need:

```bash
ll -a
```

or use the full command:

```bash
ls -la
```

Some systems already define `ll` as `ls -la`, but others do not. That is why `ll` can behave differently across machines.

## How to Check What `ll` Means

Run:

```bash
type ll
```

If it exists, you may see something like:

```bash
ll is aliased to `ls -l'
```

If it does not exist, you may see:

```bash
ll: not found
```

---
## How to Alias `ll` to `ls -la`

It is usually better to add the alias to your shell’s **rc file**, such as `~/.bashrc` or `~/.zshrc`, instead of only adding it to a profile file. This matters because another sysadmin may later write a shell script, that uses `ll` to check files, permissions, ownership, or dates. They may forget that `ll` is a custom alias and not a standard command because of how common that custom alias is mentioned in tutorials.
### For Debian/Linux Using Bash

Open your Bash config file:

```
nano ~/.bashrc
```

Add this line:

```
alias ll='ls -la'
```

Save the file, then reload it:

```
source ~/.bashrc
```

Now you can run:

```
ll
```

and it should behave like:

```
ls -la
```

### For macOS Using Zsh

Open your Zsh config file:

```
vi ~/.zshrc
```

Add this line:

```
alias ll='ls -la'
```

Save the file, then reload it:

```
source ~/.zshrc
```

Now `ll` should work in new terminal sessions too.