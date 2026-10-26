MCP servers are declared under `[mcp_servers.<name>]` in `config.toml`.

Stdio server:

```toml
[mcp_servers.context7]
command = "npx"
args = ["-y", "@upstash/context7-mcp"]
enabled = true
```

HTTP server:

```toml
[mcp_servers.docs]
url = "https://example.com/mcp"
auth = "oauth"
```

Useful knobs:

- `enabled = false` — disable without deleting the block
- `required = true` — fail startup or resume if this enabled server cannot initialize
- `enabled_tools` / `disabled_tools` — allow list, then deny list
- `startup_timeout_sec` — default 10s
- `tool_timeout_sec` — default 60s

Optional servers share a startup grace window (`mcp_optional_startup_grace_ms`, default 1000). Set `0` to wait the full `startup_timeout_sec` for each one.

If startup shows a login command, that is OAuth for that MCP server. See [[Codex CLI - Startup shows MCP connection attempts]].
