Prefer a dedicated flag when it exists:

```
codex --model gpt-6.1-sol
```

For any other key, use `-c` / `--config`. The value is TOML, not JSON:

```
codex --config model='"gpt-6.1-sol"'
codex --config sandbox_workspace_write.network_access=true
codex --config 'shell_environment_policy.include_only=["PATH","HOME"]'
codex --config mcp_servers.context7.enabled=false
```

Dot notation sets nested keys.

Quote the value so the shell does not split it. If Codex cannot parse the value as TOML, it treats it as a string.

CLI flags and `--config` beat project config, profiles, and `~/.codex/config.toml`. See [[_BASIC - Codex config.toml]].
