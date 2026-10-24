When you edit a persistent config file such as `~/.zshrc` or `~/.codex/config.toml`, inspect it first, then make a timestamped backup beside it before changing anything.

```
cp ~/.zshrc ~/.zshrc.backup-$(date +%Y%m%d-%H%M%S)
```

Same pattern for any existing file:

```
cp ~/.codex/config.toml ~/.codex/config.toml.backup-$(date +%Y%m%d-%H%M%S)
```

That gives you:

```
~/.zshrc.backup-YYYYMMDD-HHMMSS
~/.codex/config.toml.backup-YYYYMMDD-HHMMSS
```

Preserve everything already in the file. Make the smallest change that can be run again without duplicating aliases, functions, or keys.

Do not create a backup of a file that does not exist yet. Only back up files that are already there.
