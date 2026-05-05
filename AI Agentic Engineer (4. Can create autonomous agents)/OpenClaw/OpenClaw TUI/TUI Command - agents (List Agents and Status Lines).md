# TUI Command: `/agents` (Agent List and Status)

The `/agents` command shows subagent activity and current agent session state.

Subagent/agent list screen:
![[019d7785-bf70-7428-bc34-7334ecffdfd2.png]]

Example TUI status area:
![[019dee38-3055-76df-8e68-e9daa94ea19b.png]]

## What the lines mean

- `active subagents: (none)`  
  No worker/child agents are currently running.
- `recent subagents (last 30m): (none)`  
  No subagents have been started recently.
- `gateway connected | idle`  
  Gateway connection is healthy and currently idle.
- `agent main | session main (openclaw-tui)`  
  You are in the main agent and main TUI session.
- `ollama/qwen2.5:32b`  
  Active model for this session.
- `tokens 11k/131k (9%)`  
  Current context token usage.
