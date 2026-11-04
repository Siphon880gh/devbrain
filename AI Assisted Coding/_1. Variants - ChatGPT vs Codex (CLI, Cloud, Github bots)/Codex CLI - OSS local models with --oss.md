Codex can talk to a local Ollama or LM Studio server:

```
codex --oss
```

Default provider in `~/.codex/config.toml`:

```toml
oss_provider = "ollama"
```

or

```toml
oss_provider = "lmstudio"
```

For one run, pass `--local-provider` instead.

If neither is set, the interactive CLI asks which one. `codex exec` exits with an error.

Built-in provider IDs `openai`, `ollama`, and `lmstudio` are reserved. Do not create `[model_providers.ollama]` or `[model_providers.lmstudio]` to override them.

See [[__Ollama PRIMER]] and [[_LMStudio - PRIMER (Brief)]].
