  Opening terminal complaining about compdef not found and it seems related to openclaw based on the file path? Not even TUI. It’s when you open your terminal.

The terminal startup looks like this:
![[019dee4b-5c9d-71ee-b654-7d6efd4d92af.png]]

The openclaw/state/completions/openclaw.zsh file enables automatic tab-completion for Zsh users, providing native autocompletion for CLI commands, which is usually set up during installation. If you encounter a bad pattern error (often caused by ANSI color codes) or slow terminal startup (~4.6s)

```
# Openclaw tui compdef
autoload -Uz compinit  
compinit
```

to your zshell z_profile

Note this is only for zshell. It’s an autocompletion tool that comes bundled with zshell. It just initiated after openclaw instead, so you add it to the z_profile. It came included with openclaw because they recommend pressing tab to show all the subcommands

![[Pasted image 20260509084554.png]]

![[Pasted image 20260509084602.png]]