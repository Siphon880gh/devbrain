
When you are learning Linux commands from a class, tutorial, or beginner course, one of the first lookup commands you may see is:

```bash
which
```

After that, you may be exposed to:

```bash
whereis
```

Much later, you may finally learn:

```bash
type
```

This order is common because `which` is simple and easy to explain, `whereis` feels like a more advanced file-location command, and `type` is more shell-specific.

However, all three commands help you understand something about a command name. They just answer **different questions**.

You may need these commands when you are trying to figure out:

- what command actually runs when you type something
    
- whether a command is an alias, shell builtin, function, or real file
    
- where the executable file is located
    
- where the manual page or related files are stored
    
- why a command is not behaving the way you expected
    

---

# The Simple Difference

Use `which` when you want to know:

> “Which executable file will run from my `PATH`?”

Use `whereis` when you want to know:

> “Where are this command’s related files, such as the binary, manual page, or source files?”

Use `type` when you want to know:

> “What is this command, and how will my shell run it?”

---

# Key Differences at a Glance

|Command|Main Question It Answers|Best For|Can See Aliases / Builtins?|Searches|
|---|---|---|---|---|
|`which`|Where is the executable?|Finding the program file that runs from `PATH`|Usually no|Your `$PATH`|
|`whereis`|Where are related files?|Finding binaries, manuals, and source files|No|Standard system locations|
|`type`|What is this command?|Understanding what your shell will actually run|Yes|Your shell’s command rules|

---

# 1. `which`

Use `which` when you want to know the path of the executable that would run from your `PATH`.

Example:

```bash
which python
```

Possible output:

```bash
/usr/bin/python
```

This means that when your shell searches your `PATH`, it finds `python` at:

```bash
/usr/bin/python
```

This is useful when you have more than one version of a tool installed.

Example:

```bash
which node
```

Possible output:

```bash
/home/user/.nvm/versions/node/v20.11.0/bin/node
```

That tells you Node.js is coming from `nvm`, not from the system package manager.

However, `which` has a limitation: it usually only looks for executable files in your `PATH`. It may not properly explain aliases, shell functions, or shell builtins.

That is why `type` is often better for debugging what your shell is actually doing.

---

# 2. `whereis`

Use `whereis` when you want to find files related to a command.

Example:

```bash
whereis nginx
```

Possible output:

```bash
nginx: /usr/sbin/nginx /usr/share/nginx /usr/share/man/man8/nginx.8.gz
```

This can show:

- the binary/executable
    
- manual pages
    
- source files, if available
    
- related system directories
    

This is useful for system administration because it helps you find more than just the command that runs.

For example, if you want only the binary:

```bash
whereis -b nginx
```

If you want only the manual page:

```bash
whereis -m nginx
```

If you want only source files:

```bash
whereis -s nginx
```

`whereis` does **not** care about your aliases or shell functions. It searches common system locations instead.

---

# 3. `type`

Use `type` when you want to know exactly how your shell understands a command.

This is usually the most helpful command when debugging because it can tell you whether something is:

- an alias
    
- a shell function
    
- a shell builtin
    
- an external executable file
    

Example:

```bash
type cd
```

Possible output:

```bash
cd is a shell builtin
```

That matters because `cd` is not a normal program file like `/usr/bin/cd`. It is built into the shell because changing directories has to affect your current shell session.

Another example:

```bash
type ls
```

Possible output:

```bash
ls is aliased to `ls --color=auto`
```

This tells you that when you type `ls`, your shell may actually be running an alias.

You can also use:

```bash
type python
```

Possible output:

```bash
python is /usr/bin/python
```

Or:

```bash
type -a python
```

Possible output:

```bash
python is /usr/bin/python
python is /bin/python
```

The `-a` option shows all matching places your shell knows about.

---

# Common Beginner Confusion

A beginner might run:

```bash
whereis cd
```

And get little or no useful result.

That is because `cd` is usually a shell builtin, not a regular executable file.

A better command would be:

```bash
type cd
```

Output:

```bash
cd is a shell builtin
```

That explains the situation much better.

---

# Practical Recommendation

Even though you may learn them in this order:

```bash
which
whereis
type
```

For real troubleshooting, use this order:

## 1. Start with `type`

```bash
type command_name
```

This tells you what the shell thinks the command is.

Example:

```bash
type python
```

## 2. Use `which` to find the executable path

```bash
which command_name
```

Example:

```bash
which python
```

This is helpful when checking which installed version is being used.

## 3. Use `whereis` to find related files

```bash
whereis command_name
```

Example:

```bash
whereis nginx
```

This is helpful when looking for binaries, manuals, or source-related files.

---

# Easy Way to Remember

Use:

```bash
which
```

to ask:

> “Which executable will run?”

Use:

```bash
whereis
```

to ask:

> “Where are this command’s related files?”

Use:

```bash
type
```

to ask:

> “What is this command?”

---

# Final Summary

When learning Linux from a tutorial or class, you will probably be exposed to `which` first, then `whereis`, and later `type`.

That learning order makes sense, but for troubleshooting, `type` is often the most useful because it shows how your shell understands the command. `which` shows the executable found through your `PATH`, while `whereis` finds related system files such as binaries, manual pages, and source files.