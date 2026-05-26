## Web Version vs TUI Version

OpenClaw can be used through different interfaces. These are not separate “brains.” They are different ways to talk to OpenClaw agents and the Gateway.

### Web Version

The web version is the browser-based Control UI. It lets you use OpenClaw through a browser dashboard. The official docs describe the Gateway dashboard as the browser Control UI served at `/` by default. The local dashboard is commonly available at:

```text
http://127.0.0.1:18789/
```

or:

```text
http://localhost:18789/
```

You can reopen it with:

```bash
openclaw dashboard
```

The dashboard is an admin surface. It can involve chat, config, and execution approvals, so the docs warn not to expose it publicly. Prefer localhost, Tailscale, or an SSH tunnel for remote access. ([OpenClaw](https://docs.openclaw.ai/web/dashboard "Dashboard - OpenClaw"))

Use the web version when you want:

- A visual dashboard
    
- Browser-based chat
    
- Session visibility
    
- Configuration access
    
- Control UI access
    
- Easier non-terminal operation
    
