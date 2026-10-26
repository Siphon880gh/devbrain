Trust is per project path in user-level config, not an approval policy.

```toml
[projects."/Users/YOU/code/my-app"]
trust_level = "trusted"
```

```toml
[projects."/Users/YOU/code/untrusted-clone"]
trust_level = "untrusted"
```

Untrusted projects skip project-scoped `.codex/` layers: project `config.toml`, project hooks, and project rules. User and system config still load.

This is not the retired `approval_policy = "untrusted"`. That approval value is unsupported. Project `trust_level = "untrusted"` remains supported. See [[Codex CLI - Approval policy values]] and [[Codex CLI - User vs project config.toml]].
