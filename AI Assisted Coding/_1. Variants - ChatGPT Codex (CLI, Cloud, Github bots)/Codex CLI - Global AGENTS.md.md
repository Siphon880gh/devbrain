Use a global `~/.codex/AGENTS.md` file. Codex CLI automatically loads it across projects at session startup, so you don’t need to repeat the instruction. This is the officially supported mechanism for persistent guidance.

```
~/.codex/AGENTS.md
```

`CODEX_HOME` can change that directory. If `~/.codex/AGENTS.override.md` exists and is non-empty, Codex uses that instead. Only one global file is used.

Project `AGENTS.md` files still load after the global file. Codex walks from the project root down to the current directory and concatenates them. Closer files appear later and override earlier guidance. See [[Codex CLI - AGENTS.md vs model_instructions_file]] and [[Codex CLI - Project root markers]].

Keep personal working agreements in the global file. Keep repository rules in the project's `AGENTS.md` so they travel with the repo. See [[Use AGENTS.md for Consistent AI Platform Handoffs]].

Do not put this in `config.toml`. The `instructions` key is reserved. `developer_instructions` is a local config string, not a portable file. `model_instructions_file` replaces the built-in instruction file, not this global guidance layer.
