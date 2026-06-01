2025 made “AI agents” popular.

But for many people, the tools still felt like chatbots with extra steps. You asked. The AI answered. Then you had to reply again, guide it again, fix it again, or manually move the work into another app.

2026 feels different because tools like **OpenClaw, NemoClaw, Hermes, and Paperclip** show a more complete agent stack forming. They are not all the same kind of product. Together, they show the shift from **“I use an AI chatbot”** to **“I manage AI workers.”** This article combines the earlier licensing/commercial-use framing with your uploaded draft’s four-layer agent stack.

## Simple mental model

| Tool          | What it is                             | Simple explanation                                           | Layer            |
| ------------- | -------------------------------------- | ------------------------------------------------------------ | ---------------- |
| **OpenClaw**  | Personal AI assistant / action agent   | The AI worker that can do tasks for you                      | Action layer     |
| **NemoClaw**  | Security and guardrail stack           | The safety wrapper for running agents with more control      | Safety layer     |
| **Hermes**    | Self-improving autonomous agent        | The agent that remembers, learns, and grows skills over time | Learning layer   |
| **Paperclip** | Agent orchestration / management layer | The company dashboard for managing multiple AI agents        | Management layer |

OpenClaw is the worker. NemoClaw is the guardrail layer. Hermes is the worker that learns. Paperclip is the company dashboard that manages the workers.

They've gotten so popular that Hostinger even offer separate servers for them:
![[Pasted image 20260531215207.png]]

---

# Open-source and commercial-use status

As of May 31, 2026, all four appear to be open source and permissively licensed, but **not all under the same license**.

|Tool|Open source?|License|Commercial use?|Personal use?|Refactor/fork?|Main condition|
|---|--:|---|--:|--:|--:|---|
|**OpenClaw**|Yes|MIT|Yes|Yes|Yes|Keep copyright/license notice|
|**Hermes**|Yes|MIT|Yes|Yes|Yes|Keep copyright/license notice|
|**Paperclip**|Yes|MIT|Yes|Yes|Yes|Keep copyright/license notice|
|**NemoClaw**|Yes|Apache 2.0|Yes|Yes|Yes|Keep license/notice requirements; follow Apache terms|

OpenClaw’s license grants broad rights to use, copy, modify, publish, distribute, sublicense, and sell copies of the software, with the condition that the copyright and permission notice remain included. ([GitHub](https://github.com/openclaw/openclaw/blob/main/LICENSE "openclaw/LICENSE at main · openclaw/openclaw · GitHub"))

Hermes is presented as open source and MIT-licensed by Nous Research, and its GitHub repo labels it with an MIT license. ([GitHub](https://github.com/nousresearch/hermes-agent "GitHub - NousResearch/hermes-agent: The agent that grows with you · GitHub"))

Paperclip’s repo also shows an MIT license and describes the product as open-source orchestration for teams of AI agents. ([GitHub](https://github.com/paperclipai/paperclip "GitHub - paperclipai/paperclip: The open-source app everyone uses to manage agents at work · GitHub"))

NemoClaw is different: NVIDIA’s repo describes it as an open-source reference stack for running always-on AI agents more safely inside NVIDIA OpenShell sandboxes, and its license is **Apache 2.0**, not MIT. ([GitHub](https://github.com/NVIDIA/NemoClaw "GitHub - NVIDIA/NemoClaw: Run agents like Hermes and OpenClaw more securely inside NVIDIA OpenShell with managed inference · GitHub"))

Practical takeaway: **yes, all four are generally free to use, fork, and refactor for personal or commercial projects**, but you still need to follow each license and respect any third-party dependencies, API/model provider terms, trademarks, hosted-service rules, and customer-data obligations.

---

# 1. OpenClaw: The AI assistant that actually does things

**OpenClaw** is one of the clearest examples of the 2026 agent pattern.

Instead of being only a chatbot, OpenClaw is designed as a personal AI assistant that runs on your own devices and connects to the channels you already use. Its GitHub setup flow centers on a gateway, workspace, channels, and skills, with installation support for macOS, Linux, and Windows through WSL2. ([GitHub](https://github.com/openclaw/openclaw "GitHub - openclaw/openclaw: Your own personal AI assistant. Any OS. Any Platform. The lobster way.  · GitHub"))

The important idea is this:

> **OpenClaw is an action layer.**

ChatGPT-style tools are often where you think, write, or ask questions. OpenClaw is closer to a worker that can be connected to apps, channels, local tools, and workflows so it can carry out tasks.

In plain English, OpenClaw can be used for things like:

- reading and responding through chat channels
    
- helping with email
    
- managing calendar-related tasks
    
- running automations
    
- using tools on your behalf
    
- acting more like a digital assistant than a text generator
    

That is why OpenClaw became part of the 2026 agent conversation. It makes the “AI employee” idea easier to picture.

## OpenClaw pros

**1. It makes agents feel practical**

OpenClaw gives the agent a place to live, a gateway to run through, and channels to communicate through. That makes it more like an always-available assistant than a browser tab.

**2. It fits the skill-based agent model**

OpenClaw’s setup emphasizes workspaces, channels, and skills. This makes it easier to imagine repeatable procedures, project-specific rules, and custom workflows. ([GitHub](https://github.com/openclaw/openclaw "GitHub - openclaw/openclaw: Your own personal AI assistant. Any OS. Any Platform. The lobster way.  · GitHub"))

**3. It is permissively licensed**

Because OpenClaw is MIT-licensed, it is friendly to personal and commercial refactoring, assuming you preserve the required notices. ([GitHub](https://github.com/openclaw/openclaw/blob/main/LICENSE "openclaw/LICENSE at main · openclaw/openclaw · GitHub"))

**4. It is a good starting point**

If someone wants to experiment with agentic workflows, OpenClaw is a strong starting point because the mental model is simple: give the agent tools, channels, and skills.

## OpenClaw cons

**1. Action creates risk**

The moment an AI can use tools, access files, touch apps, or run workflows, mistakes matter more. A wrong answer is one thing. A wrong action is another.

**2. Skills can become messy**

A skill-based system is only as good as the skill library. If skills are vague, outdated, duplicated, or unsafe, the agent becomes harder to trust.

**3. It still needs supervision**

OpenClaw can act, but that does not mean it should act without limits. Human review, permissions, and sandboxing still matter.

---

# 2. NemoClaw: Guardrails for OpenClaw-style agents

Once agents can read emails, manage calendars, access files, and run tasks, the next question becomes obvious:

> **How do you stop them from doing the wrong thing?**

That is where **NemoClaw** fits.

NVIDIA describes NemoClaw as an open-source reference stack for running always-on AI agents more safely inside NVIDIA OpenShell sandboxes. It provides guided onboarding, a hardened blueprint, routed inference, network policy, and lifecycle management through a single CLI. ([GitHub](https://github.com/NVIDIA/NemoClaw "GitHub - NVIDIA/NemoClaw: Run agents like Hermes and OpenClaw more securely inside NVIDIA OpenShell with managed inference · GitHub"))

In simple terms:

> **OpenClaw gives the agent hands. NemoClaw tries to give those hands rules.**

NVIDIA’s NemoClaw page says it helps teams move from agent prototypes to governed deployment by bringing runtime controls, model routing, skill execution, state, and observability into integrated setup paths. ([NVIDIA](https://www.nvidia.com/en-us/ai/nemoclaw/ "Safer AI Agents & Assistants with OpenClaw | NVIDIA NemoClaw"))

NemoClaw is about controls around:

- what the agent is allowed to access
    
- what data it can handle
    
- what actions it can perform
    
- what policies it must follow
    
- how much freedom it should have
    
- how inference/model routing should be governed
    
- how lifecycle and sandboxing should be managed
    

This matters especially for companies. A solo developer might be willing to experiment with a local agent. But a business has to think about customer data, employee data, contracts, financial records, credentials, and compliance.

NemoClaw exists because once agents become useful, they also become risky.

## NemoClaw pros

**1. It focuses on safety and governance**

NemoClaw directly addresses the biggest problem with action agents: control. It adds policy controls, sandboxing, lifecycle management, routed inference, and network policy. ([GitHub](https://github.com/NVIDIA/NemoClaw "GitHub - NVIDIA/NemoClaw: Run agents like Hermes and OpenClaw more securely inside NVIDIA OpenShell with managed inference · GitHub"))

**2. It supports OpenClaw and Hermes-style agents**

NVIDIA’s page specifically describes running Hermes agents with NemoClaw and running OpenClaw autonomous agents with NemoClaw. ([NVIDIA](https://www.nvidia.com/en-us/ai/nemoclaw/ "Safer AI Agents & Assistants with OpenClaw | NVIDIA NemoClaw"))

**3. It is better suited for enterprise thinking**

Companies need controls, logs, privacy boundaries, and policy enforcement. NemoClaw is important because it represents that enterprise-grade layer.

**4. It is permissively licensed**

NemoClaw is Apache-2.0 licensed, which generally supports personal and commercial use, modification, and redistribution under Apache’s conditions. ([GitHub](https://github.com/NVIDIA/NemoClaw "GitHub - NVIDIA/NemoClaw: Run agents like Hermes and OpenClaw more securely inside NVIDIA OpenShell with managed inference · GitHub"))

## NemoClaw cons

**1. It is not the agent itself**

NemoClaw is a safety/reference stack. It does not replace OpenClaw or Hermes. It wraps, controls, and governs agent execution.

**2. It adds complexity**

Security layers are necessary, but they add setup, policy design, operational overhead, and debugging complexity.

**3. It has stronger legal/license obligations than MIT**

Apache 2.0 is still permissive, but it is more detailed than MIT. You need to pay attention to notices, patent terms, and redistribution requirements.

**4. It is still an early category**

Even when the tooling is open source, agent governance is a young space. Teams should treat it as an evolving stack, not a magic safety guarantee.

---

# 3. Hermes: The agent that learns and grows skills

**Hermes Agent** is different from OpenClaw.

OpenClaw is framed around giving an agent practical ways to do tasks through devices, channels, and tools. Hermes is framed more around long-term autonomy, memory, self-improvement, and skill growth.

Nous Research describes Hermes as a self-improving AI agent with a built-in learning loop. The repo says it creates skills from experience, improves them during use, nudges itself to persist knowledge, searches past conversations, and builds a deepening model of the user across sessions. ([GitHub](https://github.com/nousresearch/hermes-agent "GitHub - NousResearch/hermes-agent: The agent that grows with you · GitHub"))

That is the key difference.

Hermes is not only asking:

> **Can the agent do the task?**

It is asking:

> **Can the agent remember what worked, improve its own process, and become more useful over time?**

That makes Hermes important in the 2026 agent conversation.

A basic agent can follow instructions.

A better agent can use tools.

A stronger agent can remember patterns.

A more advanced agent can create or improve skills.

Hermes pushes toward that last category.

In plain English:

> **Hermes is trying to become an agent that gets better at being your agent.**

## Hermes pros

**1. It has a built-in learning loop**

Hermes is designed to learn from repeated work. That makes it stronger for ongoing projects where the agent should remember previous decisions, tools, and workflows. ([GitHub](https://github.com/nousresearch/hermes-agent "GitHub - NousResearch/hermes-agent: The agent that grows with you · GitHub"))

**2. It can create and improve skills**

The major difference from a static assistant is that Hermes can create skills from experience and improve them during use. ([GitHub](https://github.com/nousresearch/hermes-agent "GitHub - NousResearch/hermes-agent: The agent that grows with you · GitHub"))

**3. It works across platforms**

Hermes supports interaction through Telegram, Discord, Slack, WhatsApp, Signal, CLI, and other channels from a gateway process. ([GitHub](https://github.com/nousresearch/hermes-agent "GitHub - NousResearch/hermes-agent: The agent that grows with you · GitHub"))

**4. It supports scheduled automations**

Hermes includes a built-in cron scheduler for reports, backups, audits, and other natural-language scheduled work. ([GitHub](https://github.com/nousresearch/hermes-agent "GitHub - NousResearch/hermes-agent: The agent that grows with you · GitHub"))

**5. It is MIT-licensed**

Hermes is open source and MIT-licensed, so it is friendly for personal and commercial refactoring with the required notices preserved. ([Hermes Agent](https://hermes-agent.nousresearch.com/?utm_source=chatgpt.com "Hermes Agent - nous research"))

## Hermes cons

**1. Self-improvement creates drift risk**

If an agent can improve its own skills, it can also improve them in the wrong direction. Over time, the workflow may drift away from what the user actually wanted.

**2. Memory can become cluttered**

Persistent memory is powerful, but bad memory is dangerous. If the agent stores low-quality assumptions, outdated facts, or irrelevant details, future work can get worse.

**3. It is harder to audit than static skills**

With a static skill file, you can inspect what the agent was told. With a self-improving agent, you need version history, skill review, and memory review.

**4. It needs governance**

Hermes is powerful, but power means you need boundaries: what it can remember, what it can change, what tools it can use, and which actions require approval.

---

# 4. Paperclip: The management layer for AI workers

If OpenClaw and Hermes are workers, **Paperclip** is closer to management software.

Paperclip’s GitHub page describes it as open-source orchestration for teams of AI agents. It says Paperclip is a Node.js server and React UI that orchestrates a team of AI agents to run a business, letting users bring their own agents, assign goals, and track work and costs from one dashboard. ([GitHub](https://github.com/paperclipai/paperclip "GitHub - paperclipai/paperclip: The open-source app everyone uses to manage agents at work · GitHub"))

That description matters because Paperclip is not trying to be one single agent.

It is trying to answer a different problem:

> **What happens when you have many agents?**

Once you have one agent doing coding, another doing research, another doing content, another doing QA, and another doing outreach, you need more than a chat window.

You need:

- goals
    
- tasks
    
- budgets
    
- roles
    
- approvals
    
- org charts
    
- accountability
    
- cost tracking
    
- governance
    

Paperclip frames this clearly. Its README says:

> **If OpenClaw is an employee, Paperclip is the company.**

It also says Paperclip has org charts, budgets, governance, goal alignment, and agent coordination under the hood. ([GitHub](https://github.com/paperclipai/paperclip "GitHub - paperclipai/paperclip: The open-source app everyone uses to manage agents at work · GitHub"))

That is why Paperclip is important.

It reflects the next phase of agent tooling:

> **The problem is no longer just creating agents. The problem is managing them.**

This is similar to how companies evolved from hiring people to needing managers, dashboards, departments, budgets, and operating systems.

Paperclip is trying to become that layer for AI labor.

## Paperclip pros

**1. It coordinates multiple agents**

Paperclip solves the “I have too many agents running and I lost track” problem. It gives structure to agent teams.

**2. It tracks goals and costs**

Paperclip’s GitHub page emphasizes assigning goals and tracking work and costs from one dashboard. ([GitHub](https://github.com/paperclipai/paperclip "GitHub - paperclipai/paperclip: The open-source app everyone uses to manage agents at work · GitHub"))

**3. It supports different agent types**

Paperclip’s README lists OpenClaw, Claude Code, Codex, Cursor, Bash, and HTTP-style agents, with the framing: “If it can receive a heartbeat, it’s hired.” ([GitHub](https://github.com/paperclipai/paperclip "GitHub - paperclipai/paperclip: The open-source app everyone uses to manage agents at work · GitHub"))

**4. It introduces management concepts**

Org charts, governance, goal alignment, and accountability make agent work feel more like running a team than prompting a chatbot.

**5. It is MIT-licensed**

Paperclip’s license allows broad use, modification, sublicensing, and selling copies, as long as the required notice is included. ([GitHub](https://github.com/paperclipai/paperclip/blob/master/LICENSE "paperclip/LICENSE at master · paperclipai/paperclip · GitHub"))

## Paperclip cons

**1. It can be overkill**

If you only need one assistant, Paperclip may be too much. You probably do not need a company dashboard for one agent.

**2. It does not make weak agents strong**

Paperclip can manage agents, but it does not magically improve the underlying model, prompts, tools, or workflows.

**3. Multi-agent systems can get noisy**

More agents can mean more logs, more tickets, more cost, more duplicated work, and more coordination overhead.

**4. It needs strong human supervision**

A dashboard helps, but someone still needs to approve priorities, review output, control budgets, and stop bad workflows.

---

# Why these tools matter together

The important part is not just that these tools exist.

The important part is that they represent different layers of the same new stack.

|Layer|Tool example|What it solves|
|---|---|---|
|**Action layer**|OpenClaw|Lets an AI agent do real tasks|
|**Safety layer**|NemoClaw|Adds policies, privacy controls, sandboxing, and guardrails|
|**Learning layer**|Hermes|Helps an agent remember, improve, and grow skills|
|**Management layer**|Paperclip|Coordinates many agents like a team or company|

That is why 2026 feels like a real step forward.

Before, AI was mostly something you used directly.

Now, AI is becoming something you assign work to.

The user’s job changes too.

You are no longer only writing prompts.

You are defining roles, setting goals, reviewing output, approving actions, controlling permissions, and deciding which agent should do what.

That is a different skill set.

It is less like “talking to a chatbot” and more like:

> **running a small AI-powered team.**

---

# The big shift: From chatbots to AI workers

The old pattern was:

```text
Human → Prompt → AI response → Human fixes it
```

The new pattern is becoming:

```text
Human → Goal → Agent works → Agent uses tools → Agent reports back → Human approves or redirects
```

That is the agentic shift.

OpenClaw shows the agent can act.

NemoClaw shows agents need guardrails.

Hermes shows agents can improve over time.

Paperclip shows agents need management systems.

That combination is why these projects matter in 2026.

They show that the future is not just smarter chat.

The future is more likely to be:

> **AI workers with tools, memory, policies, budgets, and managers.**

---

# Best use case for each tool

|Situation|Best fit|
|---|---|
|You want one agent that can do tasks on your machine or through channels|**OpenClaw**|
|You want safer agent execution with policies, sandboxing, and governance|**NemoClaw**|
|You want an agent that remembers, learns, and improves its own skills|**Hermes**|
|You want to manage multiple agents like a team or company|**Paperclip**|

---

# Practical stack recommendation

For personal experimentation:

```text
Start with OpenClaw
→ add skills and workflows
→ add Hermes if you want memory and self-improvement
→ add NemoClaw when safety and governance matter
→ add Paperclip when you have multiple agents to manage
```

For business use:

```text
Paperclip = management dashboard
OpenClaw / Hermes = worker agents
NemoClaw = governance and sandbox layer
Skills = procedures
Memory = long-term context
Budgets = cost control
Human approval = final safety rail
```

For a serious agentic setup, the best model is not “one super-agent does everything.”

The better model is:

> **many specialized agents, each with clear permissions, managed by a dashboard, protected by policy controls, and reviewed by humans.**

---

# Final take

Your original understanding was close:

**OpenClaw** is the original-style action agent.  
**Hermes** is like OpenClaw conceptually, but with a stronger memory and self-improvement loop.  
**Paperclip** is not really another worker agent; it is the company/dashboard layer that manages many agents.  
**NemoClaw** is the safety and governance layer that makes OpenClaw/Hermes-style agents safer to run.

On licensing, the corrected version is:

> **OpenClaw, Hermes, and Paperclip are MIT-licensed. NemoClaw is Apache-2.0 licensed. All four are open source and generally usable/refactorable for personal or commercial projects, but you must preserve license notices and follow each project’s license terms.**