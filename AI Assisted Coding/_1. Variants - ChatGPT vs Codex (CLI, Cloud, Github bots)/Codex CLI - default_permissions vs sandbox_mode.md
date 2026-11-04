`default_permissions` is the newer named-profile way to set sandboxed tool access. Built-ins:

```toml
default_permissions = ":read-only"
default_permissions = ":workspace"
default_permissions = ":danger-full-access"
```

Custom names need a matching `[permissions.<name>]` table.

Do not combine `default_permissions` with `sandbox_mode` or `[sandbox_workspace_write]`. Pick one style.

A custom profile can extend a built-in, then tighten paths:

```toml
[permissions.review]
extends = ":read-only"
description = "Read the repo, deny env files"

[permissions.review.filesystem.":workspace_roots"]
"." = "read"
"**/*.env" = "deny"
```

`:danger-full-access` cannot be used as an `extends` parent. Cycles and missing parents are rejected.

Inspect or change the active profile in a session with `/permissions`. See [[Codex CLI - In-session slash commands]].
