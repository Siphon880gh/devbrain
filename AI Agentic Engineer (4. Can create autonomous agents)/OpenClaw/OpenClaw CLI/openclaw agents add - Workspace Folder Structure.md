# `openclaw agents add` Workspace Structure

Run:

`openclaw agents add project-a`

Agent creation flow:
![[019dee05-585d-722b-b5c4-4fe6c9c5870e.png]]

Expected workspace structure:

```text
/Users/wengffung/.openclaw
└── workspace
    ├── AGENTS.md
    ├── BOOTSTRAP.md
    ├── HEARTBEAT.md
    ├── IDENTITY.md
    ├── project-a
    │   ├── AGENTS.md
    │   ├── BOOTSTRAP.md
    │   ├── HEARTBEAT.md
    │   ├── IDENTITY.md
    │   ├── SOUL.md
    │   ├── TOOLS.md
    │   └── USER.md
    ├── project-b
    │   ├── AGENTS.md
    │   ├── BOOTSTRAP.md
    │   ├── HEARTBEAT.md
    │   ├── IDENTITY.md
    │   ├── SOUL.md
    │   ├── TOOLS.md
    │   └── USER.md
    ├── SOUL.md
    ├── state
    ├── TOOLS.md
    └── USER.md
```

During setup, OpenClaw continues with prompts such as auth profile and model provider selection.

Provider selection example:
![[019dee08-d657-764f-b1f6-73468b337f5e.png]]
