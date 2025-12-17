Concurrent AI agents cannot run reliably in Cursor AI even with `AGENTS.md` as of Dec 2025. At first, concurrency worked for 3 simultaneous agents. Then it stopped working at later concurrent runs (quality of output dropped). I suspect Cursor secretly limits tokens for all AI agents combined if used too aggressively.

**Lower quality output means:**
- Prompt steps getting ignored
- Inputs getting ignored
- If you specify formatting or step sequences, only a fraction are followed correctly

I switched to 1 agent at a time. Worked for a while. Eventually the 1-agent approach started ending prematurely. Then eventually it stated "can't connect online" right off the bat. I suspect Anthropic or Cursor has strategies to throttle performance if used too aggressively to keep their business viable.

**Solution:** I backed off for an hour, came back to the 1-agent approach, and things worked fine again.

**Key takeaway:** Be mindful of usage intensity. If quality degrades or connections fail, take a break and resume later.

