tmux prefix is `Ctrl-b`. Press `Ctrl-b`, let go, then the next key.

```
Ctrl-b d    detach (session keeps running)
Ctrl-b c    new window
Ctrl-b %    split pane left/right
```

Also useful:

```
Ctrl-b "    split pane up/down
Ctrl-b n    next window
Ctrl-b p    previous window
Ctrl-b o    jump to the other pane
```

Detach is the one that matters on a remote server: you can close SSH and the session stays. Reattach with:

```bash
tmux attach
```

or `tmux ls` then `tmux attach -t SESSION`.
