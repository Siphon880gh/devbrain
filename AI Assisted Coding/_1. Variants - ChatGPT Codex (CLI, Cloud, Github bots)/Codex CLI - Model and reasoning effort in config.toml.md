Set the default model in `~/.codex/config.toml`:

```toml
model = "gpt-6.1-sol"
```

Use a model available to the signed-in account or workspace. The TUI can still switch models for one session. See [[Codex CLI - Switch Models]].

Reasoning effort depends on the model:

```toml
model_reasoning_effort = "medium"
```

Common levels: `low`, `medium`, `high`, `xhigh`, `max`, `ultra`.

Related knobs:

```toml
model_reasoning_summary = "none"
model_verbosity = "low"
model_context_window = 128000
plan_mode_reasoning_effort = "high"
```

`model_verbosity` only applies to the Responses API.

For one run, prefer `--model` or a profile. See [[Codex CLI - One-off --config overrides]] and [[Codex CLI - Config profiles]].
