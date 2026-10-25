Codex reads config from more than one file. Your personal defaults live in:

```
~/.codex/config.toml
```

A trusted repo can add project overrides in `.codex/config.toml`. The CLI and the Codex IDE extension share these layers.

Highest wins:

1. CLI flags and `-c` / `--config`
2. Project `.codex/config.toml` (closest to the working directory wins; trusted projects only)
3. Profile file selected with `--profile name` (`~/.codex/name.config.toml`)
4. User `~/.codex/config.toml`
5. Cloud-managed defaults, if the signed-in workspace delivers them
6. System `/etc/codex/config.toml` on Unix
7. Built-in defaults

Related notes:

- [[Codex CLI - User vs project config.toml]]
- [[Codex CLI - Config profiles]]
- [[Codex CLI - One-off --config overrides]]
- [[Codex CLI - Global config.toml defaults]]
- [[Codex CLI - Approval policy values]]
- [[Codex CLI - Sandbox modes]]

Full key list: https://learn.chatgpt.com/docs/config-file/config-reference
