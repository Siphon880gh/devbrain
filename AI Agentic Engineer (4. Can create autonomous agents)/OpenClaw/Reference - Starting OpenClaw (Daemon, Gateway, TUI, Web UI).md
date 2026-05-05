# OpenClaw Startup Reference (Daemon, Gateway, TUI, Web UI)

## Quick Start Checklist

Start the core services:

```bash
openclaw daemon start
openclaw gateway start
```

Then start one client:

```bash
openclaw tui
```

Or:

```bash
openclaw dashboard --no-open
```

---

## What Each Service Does

### Daemon
The daemon is the core runtime.

It handles:
- Agent lifecycle
- Session state
- Task execution
- Model calls (Ollama, OpenAI, etc.)

### Gateway
The gateway is the API/interface bridge.

It exposes:
- HTTP API
- WebSocket streaming

Clients that use it:
- `openclaw tui`
- Web dashboard
- External tools/scripts

---

## Key Differences

| Command | Role | Required? | What breaks if missing |
|---|---|---|---|
| `openclaw daemon start` | Core runtime | Yes | No tasks or agent execution |
| `openclaw gateway start` | API bridge | Usually | TUI/dashboard/API cannot connect |

---

## Reference Commands

### Service control

```bash
openclaw daemon start
openclaw daemon stop
openclaw gateway start
openclaw gateway stop
```

### Restart flow (safe default)

```bash
openclaw gateway stop
openclaw daemon stop
openclaw daemon start
openclaw gateway start
```

### Launch clients

```bash
openclaw tui
openclaw dashboard --no-open
```

---

## Health + Connectivity Checks

Use these when UI/TUI is not connecting:

```bash
openclaw gateway status
openclaw daemon status
```

If available in your install:

```bash
openclaw gateway logs
openclaw daemon logs
```

---

## Common Failure Pattern

If daemon/gateway are not running, TUI may show:

```text
gateway disconnected: closed | idle
agent main | session main | unknown | tokens ?
```

And commands like `/status` may show:

```text
not connected to gateway - message not sent
gateway disconnected: closed | idle
agent main | session main | unknown | tokens ?
```

Fix:
1. Start daemon
2. Start gateway
3. Re-open TUI or dashboard

---

## Web UI Notes

Dashboard URL:
- [http://127.0.0.1:18789](http://127.0.0.1:18789)

The login accepts a token in either:
- Input field
- URL parameter

Start dashboard without auto-opening browser:

```bash
openclaw dashboard --no-open
```

### Screenshots
Login screen:
![[Pasted image 20260505050546.png]]

Dashboard screen:
![](http://localhost:9425/images/019d7c64-7c0b-7438-a4f0-97d36d6cca39.png)
