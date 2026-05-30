Cursor AI agents can be run in parallel by using separate Git branches or working trees (“worktrees”). Each agent works in an isolated copy of the repo so it can edit code (and even build/test) without stepping on your main working directory. ([Cursor](https://cursor.com/docs/configuration/worktrees?utm_source=chatgpt.com "Parallel Agents | Cursor Docs"))

When you start a **parallel agent**, Cursor typically **spawns a new worktree (and usually a branch) behind the scenes**, and that worktree is created **from whatever branch you currently have checked out**. In other words: if you want all agents to start from `main`, you should checkout `main` first, then launch them. ([Cursor - Community Forum](https://forum.cursor.com/t/start-local-worktree-agent-from-a-specific-branch/139524?utm_source=chatgpt.com "Start local worktree agent from a specific branch"))

This setup is effectively **pseudo-parallel agents**: as of Dec 2025, the agents don’t coordinate with each other or share awareness/state. The parallelism comes from Git isolation and you orchestrating the work, not from a true multi-agent system. ([Cursor](https://cursor.com/docs/configuration/worktrees?utm_source=chatgpt.com "Parallel Agents | Cursor Docs"))

**Important:** results do **not** “auto-merge at the end.” Instead, you typically **apply/merge each agent’s completed work individually** back into your primary working tree. In Cursor, this commonly means reviewing the agent’s diff and clicking an **Apply**-style action (or doing a normal Git merge/cherry-pick yourself). If multiple agents touched the same files or shared interfaces, you may need to resolve conflicts just like any normal merge. ([Cursor - Community Forum](https://forum.cursor.com/t/is-it-possible-to-work-on-several-tasks-in-parallel-with-cursor/142949?utm_source=chatgpt.com "Is It Possible to Work on Several Tasks in Parallel ..."))

Because you’re merging each agent’s work one at a time, this workflow works best when each agent is assigned a distinct feature that is likely to affect different files. Strong separation of concerns—MVC, service layers, modular components, clear file ownership—reduces conflicts and makes parallel work feasible. This is harder when the project is monolithic (e.g., one giant JavaScript file), because unrelated features still collide in the same places. ([Cursor](https://cursor.com/docs/configuration/worktrees?utm_source=chatgpt.com "Parallel Agents | Cursor Docs"))

**Working Tree mode guideline:** treat each agent as a “feature branch.” Give each agent a scoped task with minimal overlap, then **merge/apply agent outputs sequentially** into the main line.

Work tree mode:
![[Pasted image 20251214070652.png]]

