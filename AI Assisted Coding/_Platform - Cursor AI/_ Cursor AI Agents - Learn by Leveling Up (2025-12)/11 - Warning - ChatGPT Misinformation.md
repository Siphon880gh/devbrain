ChatGPT as of Dec 2025 will hallucinate when asked how to use Cursor AI Agents properly.

**It thinks there are specialized AI Agent roles when there aren't:**
![[Pasted image 20251214071121.png]]

**It thinks you can share agents in this file structure when you can't** (You can, however, share the `AGENTS.md` which can reference `prompt.md` files if you want):
![[Pasted image 20251214071311.png]]

Furthermore, if anything, Cursor reads `.cursor/` NOT `cursor/`, and it isn't for Agentic rules. Traditionally `.cursor/` was a place to add Cursor rules at the project level that affect prompt behavior. Now it's been superseded by `AGENTS.md`.

**Bottom line:** Don't trust ChatGPT's advice about Cursor AI agents. Verify information through official documentation or direct testing.

