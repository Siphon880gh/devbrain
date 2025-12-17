In Cursor, the regular editor chat and the Agent Editor use the **same underlying mechanism**: prompts as agents.

Any prompt you create in the normal editor's chat panel shows up as an "agent" when you switch to the Agent Editor. In other words, **the agent _is_ the prompt**.

Functionally, there's no difference:
Prompts in Cursor already access your terminal and files, making them effectively AI agents. They can access your GitHub repo (pulls, pushes, commits) because GitHub commands are part of their toolset. 

Whether you're using them from the normal editor chat or from the Agent Editor—their intelligence behaves identically.

In the Agent Editor, an agent's name is taken from the beginning of its prompt. You **cannot** give agents independent "internal" names and reference those agents by name inside other prompts/agents. Nor can you select from a dropdown what an agent specializes in (summary agent, QA agent, etc.). That is, as of Dec 2025.

Therefore, the rest of this series will help you think with the Agent editor (though you could do the same with the regular editor's chat panel). We'll use the prompting style typically associated with AI agents, without referencing other AI agents working simultaneously (since Cursor Agents are not aware of each other).

**In summary:** When you click New Agent, it's actually a new prompt. There's no traditional sense of agents like a summary agent or QA agent, and there's no identity coordination where Agent 2 waits for Agent 1 to finish or output something.

---

Toggle AI Agent panel:
![[Pasted image 20251214070744.png]]

---

AI Agent interface:
![[Pasted image 20251214064219.png]]

Clicking "New Agent" opens another chat interface without the horizontal tabs at the top:
![[Pasted image 20251214064251.png]]

If you don't open an Agent panel, regular chat interface has the same "Agents" as prompts at the tabs area:
![[Pasted image 20251214064355.png]]

A benefit of the AI Agents panel is you can see which prompts are still running (and whether concurrent prompts are running):
![[Pasted image 20251214070019.png]]