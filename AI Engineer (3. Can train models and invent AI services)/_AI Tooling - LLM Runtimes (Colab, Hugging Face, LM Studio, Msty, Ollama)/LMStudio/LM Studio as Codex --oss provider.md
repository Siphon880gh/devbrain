Codex CLI can use a local LM Studio server:

```
codex --oss
```

Default it in `~/.codex/config.toml`:

```toml
oss_provider = "lmstudio"
```

If `oss_provider` is unset, interactive Codex asks Ollama vs LM Studio. `codex exec --oss` errors unless you also pass `--local-provider` or set `oss_provider`.

See [[Codex CLI - OSS local models with --oss]].
