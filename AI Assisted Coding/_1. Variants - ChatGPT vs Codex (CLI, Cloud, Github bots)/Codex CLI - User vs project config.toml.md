User-level config:

```
~/.codex/config.toml
```

Project-level overrides:

```
.codex/config.toml
```

Codex walks from the project root down to the current working directory and loads every `.codex/config.toml` it finds. Closest file wins.

It only loads those project files when the project is trusted. An untrusted project skips project-scoped `.codex/` layers, including project config, hooks, and rules. User and system config still load. See [[Codex CLI - Project trust_level]].

Relative paths in a project config (for example `model_instructions_file`) resolve from the `.codex/` folder that contains that `config.toml`.

Project config cannot override provider, auth, notifications, profile selection, or telemetry. Codex ignores these keys in a project-local file and prints a startup warning:

```
openai_base_url
chatgpt_base_url
apps_mcp_product_sku
model_provider
model_providers
notify
profile
profiles
experimental_realtime_ws_base_url
otel
```

Put those in `~/.codex/config.toml`. Select a profile with `--profile`, not from the project file.
