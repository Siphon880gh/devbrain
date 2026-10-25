`approval_policy` controls when Codex pauses before running commands.

Supported values:

```toml
approval_policy = "on-request"
```

```toml
approval_policy = "never"
```

```toml
approval_policy = { granular = {
  sandbox_approval = true,
  rules = true,
  mcp_elicitations = true,
  request_permissions = false,
  skill_approval = false
} }
```

- `on-request` — interactive. Ask when a new permission is needed.
- `never` — non-interactive. Same idea as `codex -a never`. See [[Codex CLI - Never ask]].
- `granular` — let some prompt categories surface, auto-reject the rest.

`untrusted` is unsupported. Remove it. `on-failure` is deprecated; use `on-request` or `never`.

`trust_level = "untrusted"` on a project is a different setting. That still works. See [[Codex CLI - Project trust_level]].

Who reviews the prompt:

```toml
approvals_reviewer = "user"
```

`auto_review` sends eligible prompts to the reviewer subagent. That changes the reviewer, not the sandbox.
