Codex finds `.codex/` and `AGENTS.md` by walking up from the working directory until it hits a project root.

Default marker is `.git`.

```toml
project_root_markers = [".git", ".hg", ".sl"]
```

Empty list means do not search parents. The current working directory is the project root:

```toml
project_root_markers = []
```
