Another feature of Cursor AI agents is parallel prompts running on their own branches or working trees. They merge at the end. The idea is the base infrastructure is done and the parallel agents are working on different features that likely won't clash. Emphasize separation of concerns and MVC patterns.

This is pseudo having multiple AI agents working in tandem. There is no true awareness of other AI agents in Cursor as of Dec 2025.

Since it's just taking advantage of git branches being merged at the end, when using Working Tree mode for multiple AI Agents, make sure each agent (aka prompt) is working on a different feature that will likely affect different files. This is more feasible if the base code is built with good infrastructure like MVC, rather than being a long JavaScript file with thousands of lines of code.

Work tree mode:
![[Pasted image 20251214070652.png]]

