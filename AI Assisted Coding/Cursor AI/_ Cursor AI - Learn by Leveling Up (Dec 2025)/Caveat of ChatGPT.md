ChatGPT as of Dec 2025 will hallucinate when asking on how to use Cursor AI Agents properly.

It thinks there are specialized AI Agent roles when there aren't:
![[Pasted image 20251214071121.png]]

It thinks you can share agents in this file structure when you can't (You can, however, share the Agents.md which can reference prompt.md files if you want):
![[Pasted image 20251214071311.png]]
Furthermore, if anything, Cursor reads for a `.cursor/` NOT `cursor/`, and it isn't for Agentic rules. Traditionally `.cursor/` is a place to add Cursor rules at the project level that affect prompt behavior. Now it's been supersede by AGENTS.md