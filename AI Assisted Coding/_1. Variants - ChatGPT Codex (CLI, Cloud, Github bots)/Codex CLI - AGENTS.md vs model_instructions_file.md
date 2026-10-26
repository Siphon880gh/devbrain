Prefer `AGENTS.md` for project instructions. The `instructions` key in `config.toml` is reserved; do not use it.

To replace the built-in instruction file instead of `AGENTS.md`:

```toml
model_instructions_file = "/path/to/instructions.md"
```

In a project `.codex/config.toml`, a relative path resolves from that `.codex/` folder.

How much of `AGENTS.md` gets read:

```toml
project_doc_max_bytes = 32768
project_doc_fallback_filenames = ["AGENT.md", "CLAUDE.md"]
```

`developer_instructions` is an optional extra string injected into the session. That is local config, not a portable repo file.

For portable cross-platform rules, keep them in `AGENTS.md`. See [[Use AGENTS.md for Consistent AI Platform Handoffs]]. `/init` can create or update project instructions. See [[Codex CLI - In-session slash commands]].
