Persistent Codex settings live in:

```
~/.codex/config.toml
```

These two top-level keys are the useful global defaults:

```toml
sandbox_mode = "workspace-write"
approval_policy = "on-request"
```

- `sandbox_mode = "workspace-write"` lets Codex edit files in the workspace by default.
- `approval_policy = "on-request"` asks when Codex needs a new permission, instead of auto-denying or auto-approving everything.

If either key already exists, change its value. Do not add a second copy of the same key.

Do not add `approval_policy = "untrusted"`. That value is obsolete.

Leave model selection and provider configuration untouched. Those are separate from sandbox and approval.

After editing, parse the TOML without modifying the file. On Python 3.11+:

```
python3 -c "import tomllib, pathlib; tomllib.loads(pathlib.Path.home().joinpath('.codex/config.toml').read_bytes())"
```

If that prints nothing and exits 0, the file is valid TOML.
