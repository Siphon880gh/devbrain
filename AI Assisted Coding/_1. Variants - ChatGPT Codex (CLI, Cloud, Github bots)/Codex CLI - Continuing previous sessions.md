
## Finding Session ID

At the end of some response may be something like this:
```
To continue this session, run codex resume 01a0311b-35f5-7b23-8c93-c8c63de19273
```

Or you can run `/status` to get the session ID:
![[Pasted image 20260824210614.png]]

However if you had already closed the chat, you can view a list of previous sessions when starting codex:
```
codex resume
```

## Resuming from Session ID

You run something like:
```
codex resume 01a0311b-35f5-7b23-8c93-c8c63de19273
```


## Do not resume multiple tabs

If you have the session opened on one tab, it'll fail on the new tab on resuming:
```
**›** Error: Failed to resume session from /Users/wengffung/.codex/sessions/2026/08/24/rollout-2026-08-24T20-51-57-01a0370b-d6d6-7131-b677-3b1af510ac1b.jsonl: thread/resume failed during TUI bootstrap: thread/resume failed: thread 01a0370b-d6d6-7131-b677-3b1af510ac1b already has an active writer (code -32600)
```