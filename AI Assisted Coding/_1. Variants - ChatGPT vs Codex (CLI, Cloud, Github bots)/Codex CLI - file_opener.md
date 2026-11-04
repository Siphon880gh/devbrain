Citations in Codex output can be clickable. `file_opener` picks the URI scheme:

```toml
file_opener = "cursor"
```

Other values: `vscode` (default), `vscode-insiders`, `windsurf`, `none`.

A citation like `/home/user/project/main.py:42` becomes a `cursor://file/...:42` (or `vscode://file/...:42`) link.

Set this in `~/.codex/config.toml`.
