Make aliases expand when you press Tab. If zsh does not find an exact alias match, it falls back to normal completion, which means it tries to complete commands, files, folders, options, subcommands, and other context-aware suggestions.

Add this to your `~/.zshrc`:

```zsh
autoload -Uz compinit
compinit

zstyle ':completion:*' completer _expand_alias _complete
```

^ `_expand_alias` → expand exact alias matches  
^ `_complete` → normal context-aware completion

Then define your aliases:

```zsh
alias ze='zebra'
alias zeb='zebra'
```

Reload your shell:

```zsh
source ~/.zshrc
```

Now:

```zsh
ze<Tab>
```

expands to:

```zsh
zebra
```

And if you also have:

```zsh
alias zeb='zebra'
```

then:

```zsh
zeb<Tab>
```

also expands to:

```zsh
zebra
```

## Mental model

Aliases are **exact-match shortcuts**.

```text
ze<Tab>   expands only if "ze" is an alias
zeb<Tab>  expands only if "zeb" is an alias
```

Aliases are not fuzzy prefixes. So if only this exists:

```zsh
alias ze='zebra'
```

then typing:

```zsh
zeb<Tab>
```

does **not** expand `ze`. It treats `zeb` as a command-completion attempt.

## Are these lines needed?

```zsh
autoload -Uz compinit
compinit
```

Yes, if you want zsh’s programmable completion system to work reliably.

And this line is the important one for alias expansion:

```zsh
zstyle ':completion:*' completer _expand_alias _complete
```

It means:

```text
First try expanding an alias.
If that does not apply, do normal completion.
```