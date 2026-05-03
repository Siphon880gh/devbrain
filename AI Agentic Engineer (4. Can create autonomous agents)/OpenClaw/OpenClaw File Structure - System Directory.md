It's usually located at `~/.openclaw`

If you have scripts that refer to that directory, make sure to have the exact absolute path rather than relying on the tilde `~` because it might not interpret

The directory generally looks like:
```
openclaw/
├── acpx/
│   └── codex-acp-wrapper.mjs
│
├── agents/
│   └── <agent-name>/
│       ├── agent/
│       │   ├── acp-auth/
│       │   ├── auth-profiles.json
│       │   ├── auth-state.json
│       │   └── models.json
│       │
│       └── sessions/
│           ├── <session-id>.jsonl
│           ├── <session-id>.trajectory-path.json
│           ├── <session-id>.trajectory.jsonl
│           └── sessions.json
│
├── canvas/
│   └── index.html
│
├── devices/
│   ├── paired.json
│   └── pending.json
│
├── extensions/
│   └── <extension-name>/
│       ├── index.ts
│       ├── openclaw.plugin.json
│       ├── package.json
│       └── README.md
│
├── identity/
│   ├── device-auth.json
│   └── device.json
│
├── logs/
│   ├── config-audit.jsonl
│   ├── config-health.json
│   ├── gateway.err.log
│   └── gateway.log
│
├── tasks/
│   ├── runs.sqlite
│   ├── runs.sqlite-shm
│   └── runs.sqlite-wal
│
├── workspace/
│   ├── AGENTS.md
│   ├── BOOTSTRAP.md
│   ├── HEARTBEAT.md
│   ├── IDENTITY.md
│   ├── SOUL.md
│   ├── TOOLS.md
│   ├── USER.md
│   └── state/
│
├── openclaw.json
├── openclaw.json.bak
├── openclaw.json.bak.<number>
├── openclaw.json.clobbered.<timestamp>
├── openclaw.json.last-good
└── update-check.json
```