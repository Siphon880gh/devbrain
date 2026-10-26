Inside a Codex CLI session, these slash commands inspect or change how the session is running:

```
/status       inspect active model/configuration
/permissions  inspect or change the active permission profile
/init         create or update project instructions
```

`/status` is also how you can grab a session ID after the chat is already open. See [[Codex CLI - Continuing previous sessions]].

`/diff` is separate: just type `/diff`. See [[Codex CLI - Show diff]].

`/init` writes or updates project instructions in the repo. For portable cross-platform rules, keep those in `AGENTS.md`. See [[Use AGENTS.md for Consistent AI Platform Handoffs]].
