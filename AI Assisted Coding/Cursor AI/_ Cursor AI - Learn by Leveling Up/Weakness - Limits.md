
Can't run concurrent AI agents reliably in Cursor AI even with Agents.md as of Dec 2025. At first, concurrency worked for 3 simultaneous agents. And then it stopped working at later concurrent runs (quality of output dropped). I think Cursor secretly limits tokens for all ai agents combined if used too aggressively.  What I meant by lower quality of output is:
- Prompt steps getting ignored
- Inputs getting ignored
- If you tell it to format or follow a sequences of steps, it gets only a fraction of those correct.

So I switch to 1 agent at a time. Worked for a while. Eventually the 1 agent approach starts ending prematurely. And then eventually it just states can't connect online right off the bat. I suspect Anthropic or Cursor has strategies to dumb things down if used too aggressively in order to keep their business viable. I backed off for an hour to come back to the 1 agent approach and things went fine.