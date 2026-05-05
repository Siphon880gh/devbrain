# Multi-Agent Setup: One Gateway vs Two Gateways

There are two setup patterns, depending on how isolated you want each agent.

## Option A: One gateway, multiple agents (recommended)

Create agents inside one gateway:

- `openclaw agents add project-a`
- `openclaw agents add project-b`

Each agent gets its own:

- workspace directory
- `SOUL.md` and `AGENTS.md`
- session store
- skills directory

Use bindings to route inbound messages to the correct agent, then inspect with:

`openclaw agents list --bindings`

This provides clear context isolation per agent (no shared conversation history or memory).

## Option B: Separate gateways on different ports

This also works, but requires:

- more processes
- more config files
- more operational overhead

For most setups, one gateway with multiple agents is cleaner.
