Profiles are separate files next to your user config, not tables inside it.

```
~/.codex/deep-review.config.toml
```

```toml
model = "gpt-6.1-sol"
model_reasoning_effort = "medium"
approval_policy = "on-request"
```

Use top-level keys in that file. Do not nest them under `[profiles.deep-review]`.

Load one:

```
codex --profile deep-review
codex exec --profile deep-review "review this change"
```

Codex loads `~/.codex/config.toml` first, then overlays the profile file. The profile only needs the values that differ from your base config. Project config and CLI flags still win over the profile.

Profile names can contain letters, numbers, hyphens, and underscores.

As of Codex 0.134.0, `--profile` no longer reads `[profiles.profile-name]` from `config.toml`, and `profile = "profile-name"` is no longer supported. Move old profile tables into `~/.codex/profile-name.config.toml`.
