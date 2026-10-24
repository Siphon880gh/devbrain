After editing `~/.zshrc`, check syntax without running it:

```
zsh -n ~/.zshrc
```

If that exits 0, the file parses.

Then confirm aliases and functions actually resolve by starting a non-interactive zsh that sources `~/.zshrc`:

```
zsh -i -c 'source ~/.zshrc; type cx; type cxr; type cxw; type cxhelp'
```

`type` should show:

- `cx` as an alias to `codex`
- `cxr` as an alias that expands to `command codex --sandbox read-only`
- `cxw` as an alias that expands to `command codex --sandbox workspace-write`
- `cxhelp` as a shell function

Do not launch the aliased program itself just to prove the shortcut exists. Checking `type` is enough.

Interactive terminals source `.zshrc` automatically. Non-interactive zsh does not, so the explicit `source` is required in that check.
