
If you're using the free self-hosted **Botpress V12**, note that Autonomous Nodes aren't supported. V12 relies on traditional, manual workflows using **Standard Nodes** and conditional transitions.

However, you can:
- Use Autonomous Nodes in Cloud first to **prototype and test your flow**, taking advantage of the fact that Botpress Cloud has a generous amount of AI Spend ($5 every month). 
	- Recall that Autonomous Nodes in Botpress Cloud let you power entire multi-step conversations using a single AI-driven prompt 
- Later **break the logic into individual nodes** when migrating to V12.
- Call external AI models (like OpenAI or Claude) via API to simulate AI-like conversations.
- Parse structured responses (e.g., JSON) to set variables (`temp.purpose`, `session.brandColor`, etc.) for transitions.

---

### Final Note

While Botpress Cloud’s Autonomous Nodes simplify complex logic and are great for rapid prototyping, you’ll still need to test various user paths and edge cases. This ensures a smooth transition when converting to V12 or scaling beyond the **5,000-message Cloud limit** and/or $5 AI spend credit.