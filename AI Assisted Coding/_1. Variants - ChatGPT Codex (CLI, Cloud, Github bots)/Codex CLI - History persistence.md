By default Codex saves session transcripts under `CODEX_HOME`, usually:

```
~/.codex/history.jsonl
```

Turn that off:

```toml
[history]
persistence = "none"
```

Cap the file. When it exceeds the cap, oldest entries drop:

```toml
[history]
max_bytes = 104857600
```

`save-all` is the other `persistence` value.

This is the on-disk history file. In-session transcript view is still CTRL+T. See [[Codex CLI - Transcripts]].
