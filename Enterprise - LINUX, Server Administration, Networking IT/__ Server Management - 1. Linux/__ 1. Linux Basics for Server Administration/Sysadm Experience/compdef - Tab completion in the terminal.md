
TLDR:
When I type 'g' and press Tab in the terminal, I want it to expand to git.

Add this to .bash_profile or equivalent:
```
alias g='git'
compdef _git g
```

If this had never been used before, make sure your bash_profile or equivalent has it initiated
```
autoload -Uz compinit  
compinit
```

---

## What is `compdef`?

`compdef` is a **Zsh completion command**.

It tells Zsh:

> “When the user types this command and presses Tab, use this completion function.”

In plain English, `compdef` connects a command name to a completion script.

Example:

```zsh
compdef _git g
```

This means:

> When I type `g` and press Tab, use Git’s autocomplete rules.

So if `g` is your alias for `git`, Zsh can autocomplete it like normal Git.

---

## Why people use `compdef`

People use `compdef` because aliases, wrapper scripts, and custom commands do not always get autocomplete automatically.

For example, you may have this alias:

```zsh
alias g='git'
```

Now you can run:

```zsh
g status
g checkout main
```

But autocomplete may not behave like `git` autocomplete.

So you add:

```zsh
compdef _git g
```

Now `g` uses Git completion.

That means this can work:

```zsh
g <TAB>
g checkout <TAB>
g branch <TAB>
```

---

# The basic pattern

```zsh
compdef COMPLETION_FUNCTION COMMAND
```

Example:

```zsh
compdef _git g
```

Breakdown:

```zsh
compdef _git g
        │    │
        │    └── the command or alias you type
        └─────── the completion function to use
```

So this says:

> Use `_git` completion when the user types `g`.

---

# Common use: autocomplete for aliases

This is the most common reason people use `compdef`.

## Git alias example

```zsh
alias g='git'
compdef _git g
```

Now your alias `g` behaves like `git` for autocomplete.

Example:

```zsh
g checkout <TAB>
```

Zsh will complete Git branches, because `g` is now connected to Git completion.

---

## Docker alias example

```zsh
alias d='docker'
compdef _docker d
```

Now this works better:

```zsh
d ps
d compose <TAB>
```

---

## Kubernetes alias example

```zsh
alias k='kubectl'
compdef _kubectl k
```

Now this works:

```zsh
k get pods
k describe pod <TAB>
```

This is very common among DevOps engineers and Kubernetes users.

---

# Common use: wrapper commands

Sometimes you create a custom script that wraps another command.

Example:

```zsh
~/bin/mygit
```

Maybe `mygit` runs Git with extra logging or defaults.

You can tell Zsh to treat `mygit` like Git for autocomplete:

```zsh
compdef _git mygit
```

Now:

```zsh
mygit checkout <TAB>
```

uses Git autocomplete.

---

# Common use: custom command completion

You can also write your own completion function.

Example:

```zsh
_mytool() {
  _arguments \
    '1:command:(start stop restart status)' \
    '2:environment:(dev staging production)'
}

compdef _mytool mytool
```

Now this command:

```zsh
mytool <TAB>
```

can complete:

```zsh
start stop restart status
```

And:

```zsh
mytool start <TAB>
```

can complete:

```zsh
dev staging production
```

This is useful when you create internal CLI tools.

---

# Where to put `compdef`

Usually you put it in your Zsh config file:

```zsh
~/.zshrc
```

Example:

```zsh
alias g='git'
compdef _git g
```

Then reload your shell:

```zsh
source ~/.zshrc
```

Or open a new terminal.

---

# Important: completions must be initialized first

Before `compdef` works, Zsh completion should be loaded.

Most Zsh setups already do this, especially if you use Oh My Zsh, Prezto, Antigen, Zinit, or similar tools.

But in a plain `.zshrc`, you may need:

```zsh
autoload -Uz compinit
compinit
```

Then your aliases and `compdef` lines can come after it:

```zsh
autoload -Uz compinit
compinit

alias g='git'
compdef _git g
```

If `compdef` says “command not found,” it usually means `compinit` was not loaded yet.

---

# Common examples

```zsh
alias g='git'
compdef _git g
```

```zsh
alias d='docker'
compdef _docker d
```

```zsh
alias dc='docker compose'
compdef _docker dc
```

```zsh
alias k='kubectl'
compdef _kubectl k
```

```zsh
alias tf='terraform'
compdef _terraform tf
```

```zsh
alias py='python'
compdef _python py
```

```zsh
alias npmrun='npm run'
compdef _npm npmrun
```

---

# Common mistake: putting `compdef` before `compinit`

This may fail:

```zsh
alias g='git'
compdef _git g

autoload -Uz compinit
compinit
```

Better:

```zsh
autoload -Uz compinit
compinit

alias g='git'
compdef _git g
```

`compdef` depends on Zsh’s completion system being ready.

---

# Common mistake: assuming aliases autocomplete automatically

This alias:

```zsh
alias g='git'
```

does not always mean this will autocomplete like Git:

```zsh
g checkout <TAB>
```

You often need:

```zsh
compdef _git g
```

The alias controls what command runs.

`compdef` controls what autocomplete rules are used.

---

# Common mistake: using the wrong completion function

This will not work unless `_foo` exists:

```zsh
compdef _foo mycommand
```

Completion functions usually start with an underscore:

```zsh
_git
_docker
_kubectl
_terraform
_npm
```

You can check whether a completion function exists with:

```zsh
type _git
```

Or:

```zsh
whence -v _git
```

---

# How to test it

After editing `~/.zshrc`, run:

```zsh
source ~/.zshrc
```

Then try:

```zsh
g <TAB>
```

or:

```zsh
g checkout <TAB>
```

If it works, your alias now uses Git completion.

---

# Simple mental model

Think of it like this:

```zsh
alias g='git'
```

means:

> `g` runs Git.

```zsh
compdef _git g
```

means:

> `g` autocompletes like Git.

You usually need both.

---

# Practical example `.zshrc`

```zsh
autoload -Uz compinit
compinit

# Git shortcut
alias g='git'
compdef _git g

# Docker shortcut
alias d='docker'
compdef _docker d

# Kubernetes shortcut
alias k='kubectl'
compdef _kubectl k
```

After saving:

```zsh
source ~/.zshrc
```

Now your shortcuts still run the original commands, but they also get proper Tab completion.

---

# Summary

`compdef` is a Zsh command that connects a command, alias, or wrapper script to an autocomplete function.

Use it when you want a shortcut like:

```zsh
g
k
d
tf
```

to autocomplete like:

```zsh
git
kubectl
docker
terraform
```

The most common use is making aliases behave like the full command when pressing Tab.