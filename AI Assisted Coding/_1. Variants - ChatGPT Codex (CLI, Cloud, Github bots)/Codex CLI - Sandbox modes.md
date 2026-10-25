`sandbox_mode` is filesystem and network access for commands, not the approval prompt.

```toml
sandbox_mode = "read-only"
sandbox_mode = "workspace-write"
sandbox_mode = "danger-full-access"
```

- `read-only` — inspect the repo, do not edit through the sandbox. Good for reviews. Pair with `cxr`. See [[Codex CLI - Shell shortcuts cx, cxr, cxw]].
- `workspace-write` — edit files in the workspace. The usual default. See [[Codex CLI - Global config.toml defaults]].
- `danger-full-access` — no sandbox. Same danger class as `codex --yolo`. See [[Codex CLI - Never ask]].

Optional extras only apply when `sandbox_mode = "workspace-write"`:

```toml
[sandbox_workspace_write]
writable_roots = ["/Users/YOU/.pyenv/shims"]
network_access = false
exclude_tmpdir_env_var = false
exclude_slash_tmp = false
```

`.git/`, `.agents/`, `.codex/`, and `.aws/` can stay read-only even in workspace-write. That is why `git commit` may still need approval outside the sandbox.

Do not combine `sandbox_mode` or `[sandbox_workspace_write]` with `default_permissions`. See [[Codex CLI - default_permissions vs sandbox_mode]].
