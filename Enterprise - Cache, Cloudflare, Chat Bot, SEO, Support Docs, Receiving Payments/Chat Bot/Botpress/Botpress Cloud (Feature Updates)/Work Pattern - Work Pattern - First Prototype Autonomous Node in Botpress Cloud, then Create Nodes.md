
- Use Autonomous Nodes in Cloud first to **prototype and test your flow**, taking advantage of the fact that Botpress Cloud has a generous amount of AI Spend ($5 every month). 
	- Recall that Autonomous Nodes in Botpress Cloud let you power entire multi-step conversations using a single AI-driven prompt 
- Later **break the logic into individual nodes** on the same workflow

Take advantage that you can disengage and engage with different flows:

![[Pasted image 20250518033745.png]]

![[Pasted image 20250518033723.png]]

All the alternate flows (Autonomous Node or hard wired flow) can connect to End node without problem.

The goal is to switch completely to standard nodes to limit your use of AI credit spend using Autonomous Node. You'll have to test for all kinds of possible user questions/answers.


---

### Final Note

While Botpress Cloud’s Autonomous Nodes simplify complex logic and are great for rapid prototyping, you’ll still need to test various user paths and edge cases. This ensures being limited to only the **5,000-message Cloud limit** and limiting use of the $5 AI spend credit (on free tier).

Note that while the message count is not used against you in the Emulator Chat, the AI spend credit **is used** when in at the Emulator Chat