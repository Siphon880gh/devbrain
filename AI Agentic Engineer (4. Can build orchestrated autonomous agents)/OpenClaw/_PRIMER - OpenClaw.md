## OpenClaw: Self-Hosted AI Agent Runtime, Gateway, and Workflow Layer

OpenClaw is a self-hosted personal AI assistant system you can run on your own machine, server, VPS, or cloud environment. It is not the AI model itself. The AI model is the reasoning engine. OpenClaw is the runtime, gateway, workspace, tool layer, channel layer, and control surface around that model. The official project describes OpenClaw as a personal AI assistant that runs on your own devices and answers through channels you already use; its Gateway acts as the control plane for sessions, channels, tools, and events. ([GitHub](https://github.com/openclaw/openclaw?utm_source=chatgpt.com "OpenClaw — Personal AI Assistant"))

---

In plain English, OpenClaw is like the “home base” or “engine room” for your AI agents. The AI model does the thinking, but OpenClaw gives that AI a place to run, remember things, use tools, and connect to the outside world.

For example, you might have an OpenClaw agent connected to Slack, Telegram, or WhatsApp. Instead of logging into a special AI dashboard every time, you can send a message from one of those apps and talk to your agent there. You could ask it to summarize something, check a file, review a lead, write a reply, or help with a workflow.

OpenClaw can also keep agents running 24/7 as long as the machine or server is on and the OpenClaw engine is running. That means your agent can be available like a digital worker that is always listening through the channels you connected. If someone messages the agent in Slack, Telegram, WhatsApp, or another supported channel, OpenClaw can receive that message, route it to the right agent, and send the response back through that same channel.

While for basic use, you may not need to touch the advanced controls often because you can simply talk to your agent from a normal chat channel, such as Slack or Telegram...

For deeper management, you would open the OpenClaw dashboard or use the TUI, which is the terminal interface. Those are better for setup, configuration, debugging, advanced tasks, managing agents, checking sessions, changing models, working with tools, and controlling how the agent runs. So the simple requests can happen in Slack, Telegram, or WhatsApp, while the deeper engine work happens in the dashboard or terminal.

---

A useful mental model is:

|Layer|What It Does|
|---|---|
|AI model|Generates reasoning, decisions, and responses|
|OpenClaw|Runs the assistant, Gateway, agents, tools, sessions, channels, skills, cron, and UI surfaces|
|Your code or workflow|Decides the larger business process, guardrails, retries, approvals, and next steps|
|External systems|Provide data, triggers, files, APIs, logs, CRMs, calendars, inboxes, databases, and business logic|

In simple terms:

```text
OpenClaw gives the AI agent a place to live and act.
Your workflow decides what the business process should be.
External tools provide the data and actions.
```

For example:

```text
New lead comes in
        ↓
Your app, CRM, or n8n workflow detects it
        ↓
OpenClaw agent analyzes the lead
        ↓
Your workflow decides whether to send outreach, nurture, or escalate
```

OpenClaw is strongest when treated as an agent execution and coordination layer. It can run agents, connect tools, manage sessions, connect chat channels, schedule tasks, and expose APIs. For larger business automation, your surrounding system should still define the workflow logic, approvals, escalation rules, and final decisions.

---

## Core Concepts

### Agents

An agent is a configured AI worker with its own role, workspace, session context, model settings, tools, skills, and routing behavior.

Examples:

- Lead qualifier
    
- Coding assistant
    
- Research agent
    
- Support triage agent
    
- Monitoring agent
    
- Report generator
    
- Calendar assistant
    
- Inbox assistant
    

OpenClaw supports isolated agents with workspaces, auth, and routing bindings. You can list, add, bind, unbind, and delete agents through the CLI. The docs describe agents as isolated units based around workspaces, auth, and routing. ([OpenClaw](https://docs.openclaw.ai/cli/agents "agents - OpenClaw"))

A practical rule:

```text
One agent = one focused job.
```

The more specific the agent’s job, the easier it is to test, improve, and secure.

---

### Workspaces

The workspace is the agent’s home. It is where OpenClaw stores the files that shape the agent’s behavior and memory. The official docs describe the workspace as the only working directory used for file tools and workspace context, but they also warn that it is not a hard sandbox by default. Relative paths resolve against the workspace, but absolute paths can still reach elsewhere on the host unless sandboxing is enabled. ([OpenClaw](https://docs.openclaw.ai/concepts/agent-workspace "Agent Workspace - OpenClaw"))

Default workspace:

```text
~/.openclaw/workspace
```

Common workspace files include:

|File|Purpose|
|---|---|
|`AGENTS.md`|Operating instructions, rules, priorities, and behavior guidance|
|`SOUL.md`|Persona, tone, and boundaries|
|`USER.md`|Information about the user and how to address them|
|`IDENTITY.md`|Agent name, vibe, and emoji|
|`TOOLS.md`|Notes about local tools and conventions|
|`HEARTBEAT.md`|Optional checklist for heartbeat runs|
|`BOOT.md`|Optional startup checklist|
|`BOOTSTRAP.md`|First-run setup ritual|
|`memory/YYYY-MM-DD.md`|Daily memory logs|
|`MEMORY.md`|Optional curated long-term memory|
|`skills/`|Workspace-specific skills|

These files matter because they shape how the agent behaves across sessions. ([OpenClaw](https://docs.openclaw.ai/concepts/agent-workspace "Agent Workspace - OpenClaw"))

---

### Identity and Behavior

In OpenClaw, “identity” can mean the agent’s visible identity, such as name, theme, emoji, or avatar. The `openclaw agents set-identity` command writes identity fields into the agent configuration. ([OpenClaw](https://docs.openclaw.ai/cli/agents "agents - OpenClaw"))

But the agent’s deeper behavior usually comes from workspace files such as:

- `AGENTS.md`
    
- `SOUL.md`
    
- `USER.md`
    
- `TOOLS.md`
    
- `HEARTBEAT.md`
    
- `MEMORY.md`
    

A simple behavior file might say:

```md
You are a strict analyst.
Be concise.
Do not speculate.
Always explain uncertainty.
Escalate unclear or risky cases.
Do not perform destructive actions without approval.
```

Think of this as:

```text
IDENTITY.md = who the agent is
AGENTS.md / SOUL.md / USER.md = how the agent behaves
TOOLS.md = how the agent should think about local tools
MEMORY.md / memory/ = what the agent should remember
```

---

### Models

OpenClaw does not replace the model. It connects to model providers and uses the configured model for reasoning. Current OpenClaw model configuration supports a primary model, fallbacks, image models, PDF models, image-generation models, music-generation models, and video-generation models. ([OpenClaw](https://docs.openclaw.ai/concepts/models "Models CLI - OpenClaw"))

That means OpenClaw is not the same thing as GPT, Claude, Gemini, DeepSeek, Qwen, or a local Ollama model. Instead:

```text
The model thinks.
OpenClaw gives the model tools, memory, sessions, channels, and a runtime.
```

---

### Tools

Tools let the agent interact with the outside world.

Examples:

- Read and write files
    
- Run shell commands
    
- Browse the web
    
- Search the web
    
- Send messages
    
- Manage sessions
    
- Use browser automation
    
- Use canvas
    
- Use paired nodes/devices
    
- Manage cron jobs
    
- Analyze or generate images
    
- Generate video, audio, or speech
    
- Call plugin-provided capabilities
    

The official OpenClaw docs describe tools as everything the agent does beyond generating text. Tools are how the agent reads files, runs commands, browses the web, sends messages, and interacts with devices. ([OpenClaw](https://docs.openclaw.ai/tools "Tools and Plugins - OpenClaw"))

This is what separates an agent from a basic chatbot:

```text
A chatbot answers.
An agent can answer and act.
```

---

### Skills

Skills teach the agent when and how to use tools. OpenClaw uses AgentSkills-compatible skill folders, where each skill is a directory containing a `SKILL.md` file with YAML frontmatter and instructions. ([OpenClaw](https://docs.openclaw.ai/skills "Skills - OpenClaw"))

A skill can explain:

- When to use a tool
    
- How to use a tool safely
    
- What steps to follow
    
- What constraints to respect
    
- What outputs to produce
    

Skills can come from several locations, including bundled skills, managed/local skills, personal skills, project skills, and workspace skills. Workspace skills have the highest precedence when names conflict. ([OpenClaw](https://docs.openclaw.ai/skills "Skills - OpenClaw"))

A simple mental model:

```text
Tools = what the agent can call
Skills = instructions for using those tools well
Plugins = packages that add tools, skills, channels, model providers, and other capabilities
```

---

### Plugins

Plugins extend OpenClaw with additional capabilities. They can add channels, model providers, tools, skills, speech, realtime transcription, realtime voice, media understanding, image generation, video generation, web fetch, web search, and more. Some plugins are core; others can come from the community. ([OpenClaw](https://docs.openclaw.ai/tools/plugin?utm_source=chatgpt.com "Plugins"))

Because plugins and skills can increase what the agent can do, they should be treated as part of your security surface.

---

### Channels

Channels are the places where you talk to the agent.

OpenClaw supports many chat and messaging channels, including Telegram, Slack, Discord, WhatsApp, Google Chat, Signal, iMessage-related setups, Matrix, Mattermost, Microsoft Teams, LINE, Twitch, WeChat, Zalo, WebChat, and others. Each channel connects through the Gateway. Text is supported everywhere, while media and reactions vary by channel. ([OpenClaw](https://docs.openclaw.ai/channels "Chat channels - OpenClaw"))

This is why OpenClaw can feel different from a normal web chatbot. You can interact with the same assistant from the places you already use.

---

## Web Version vs TUI Version

OpenClaw can be used through different interfaces. These are not separate “brains.” They are different ways to talk to OpenClaw agents and the Gateway.

### Web Version

The web version is the browser-based Control UI. It lets you use OpenClaw through a browser dashboard. The official docs describe the Gateway dashboard as the browser Control UI served at `/` by default. The local dashboard is commonly available at:

```text
http://127.0.0.1:18789/
```

or:

```text
http://localhost:18789/
```

You can reopen it with:

```bash
openclaw dashboard
```

The dashboard is an admin surface. It can involve chat, config, and execution approvals, so the docs warn not to expose it publicly. Prefer localhost, Tailscale, or an SSH tunnel for remote access. ([OpenClaw](https://docs.openclaw.ai/web/dashboard "Dashboard - OpenClaw"))

Use the web version when you want:

- A visual dashboard
    
- Browser-based chat
    
- Session visibility
    
- Configuration access
    
- Control UI access
    
- Easier non-terminal operation
    

---

### TUI Version

The TUI is the terminal user interface. It lets you chat with and control the agent from your terminal.

Common commands:

```bash
openclaw tui
openclaw chat
openclaw tui --local
```

The docs state that `openclaw tui` opens the terminal UI connected to the Gateway, or can run in local embedded mode. They also state that `chat` and `terminal` are aliases for `openclaw tui --local`. ([OpenClaw](https://docs.openclaw.ai/cli/tui "TUI - OpenClaw"))

Use the TUI when you want:

- A developer-style workflow
    
- Terminal-first usage
    
- Local embedded runs
    
- Fast testing and debugging
    
- CLI-driven agent interaction
    

Important distinction:

```text
Gateway mode = uses the Gateway.
Local mode = embedded agent runtime directly, with Gateway-only features unavailable.
```

---

## OpenAI-Compatible API Surface

OpenClaw’s Gateway exposes OpenAI-compatible endpoints such as:

```text
GET  /v1/models
POST /v1/embeddings
POST /v1/chat/completions
POST /v1/responses
```

The Gateway docs say these endpoints are useful because many Open WebUI, LobeChat, and LibreChat integrations probe `/v1/models` first. ([OpenClaw](https://docs.openclaw.ai/gateway "Gateway runbook - OpenClaw"))

That means OpenClaw can often sit behind compatible chat frontends while still routing requests to OpenClaw agents.

---

## How to Install OpenClaw

The fastest install path is the official installer script. The docs say it detects your operating system, installs Node if needed, installs OpenClaw, and launches onboarding. ([OpenClaw](https://docs.openclaw.ai/install "Install - OpenClaw"))

### macOS / Linux / WSL2

```bash
curl -fsSL https://openclaw.ai/install.sh | bash
```

### Windows PowerShell

```powershell
iwr -useb https://openclaw.ai/install.ps1 | iex
```

### Install Without Onboarding

macOS / Linux / WSL2:

```bash
curl -fsSL https://openclaw.ai/install.sh | bash -s -- --no-onboard
```

Windows PowerShell:

```powershell
& ([scriptblock]::Create((iwr -useb https://openclaw.ai/install.ps1))) -NoOnboard
```

### Install with npm

If you already manage Node yourself:

```bash
npm install -g openclaw@latest
openclaw onboard --install-daemon
```

OpenClaw currently recommends Node 24, with Node 22.14+ also supported. The official docs also list macOS, Linux, Windows, and WSL2 as supported install targets, with WSL2 noted as more stable than native Windows. ([OpenClaw](https://docs.openclaw.ai/install "Install - OpenClaw"))

Verify the install:

```bash
openclaw --version
openclaw doctor
openclaw gateway status
```

Then open the web dashboard:

```bash
openclaw dashboard
```

Or start the TUI:

```bash
openclaw tui
```

---

## How OpenClaw Runs Agents

OpenClaw can run agents in several common ways.

### 1. Manual CLI Runs

Useful for testing, debugging, and one-off tasks.

```bash
openclaw agent --agent ops --message "Summarize logs"
```

The current CLI docs say `openclaw agent` runs an agent turn through the Gateway, with `--local` available for embedded mode. The command requires a message and at least one selector, such as `--agent`, `--to`, or `--session-id`. ([OpenClaw](https://docs.openclaw.ai/cli/agent "Agent - OpenClaw"))

Other examples:

```bash
openclaw agent --agent main --message "Review this checklist"
openclaw agent --session-id 1234 --message "Summarize inbox"
openclaw agent --agent ops --message "Generate report" --deliver --reply-channel slack --reply-to "#reports"
```

---

### 2. Web Dashboard

Useful for managing and chatting with agents visually.

```bash
openclaw dashboard
```

The dashboard is best for users who want a browser-based control surface instead of a terminal-first workflow.

---

### 3. TUI

Useful for terminal-first workflows.

```bash
openclaw tui
```

Local embedded mode:

```bash
openclaw tui --local
```

Shortcut:

```bash
openclaw chat
```

---

### 4. Channels

OpenClaw can connect to channels such as Telegram, Slack, Discord, WhatsApp, Google Chat, Signal, Matrix, Microsoft Teams, WebChat, and more. Channels can run simultaneously, and OpenClaw can route per chat. ([OpenClaw](https://docs.openclaw.ai/channels "Chat channels - OpenClaw"))

Example pattern:

```text
User sends message in Telegram
        ↓
OpenClaw Gateway receives it
        ↓
Gateway routes it to the right agent/session
        ↓
Agent responds through the channel
```

---

### 5. Cron, Webhooks, Heartbeat, and External Automation

OpenClaw includes its own automation surfaces. Cron is the Gateway’s built-in scheduler. It can persist jobs, wake the agent at the right time, and deliver output back to a chat channel or webhook endpoint. ([OpenClaw](https://docs.openclaw.ai/automation/cron-jobs?utm_source=chatgpt.com "Scheduled tasks"))

OpenClaw also distinguishes scheduled tasks, background tasks, task flow, standing orders, hooks, and heartbeat. Scheduled Tasks are best for precise timing; Heartbeat is better for periodic awareness that benefits from main-session context. ([OpenClaw](https://docs.openclaw.ai/automation?utm_source=chatgpt.com "Automation and tasks"))

Examples:

- Daily report at 9 AM
    
- Reminder in 20 minutes
    
- Weekly deep analysis
    
- Check inbox every 30 minutes
    
- Monitor calendar for upcoming events
    
- Trigger an agent from a webhook
    
- Run a recurring operational checklist
    

A clean mental model:

```text
Cron = precise scheduled execution
Heartbeat = periodic awareness loop
Tasks = records of detached/background work
Task Flow = durable multi-step flow layer
Hooks/Webhooks = event-driven triggers
External workflow tools = business process orchestration
```

---

## Where OpenClaw Stops

OpenClaw can run agents, manage sessions, expose tools, connect channels, schedule jobs, and provide a Gateway.

But a larger production system may still need to decide:

- Which agent should run next
    
- Whether the result is good enough
    
- Whether to retry
    
- Whether to escalate to a human
    
- Whether to store the result
    
- Whether to trigger another workflow
    
- Whether an action needs approval
    
- Whether a task is too risky to automate
    

That is the orchestration layer.

Example:

```python
result = run_agent("lead_qualifier", lead_data)

if result["status"] == "qualified":
    run_agent("sales_outreach", result)
elif result["status"] == "uncertain":
    escalate_to_human(result)
else:
    run_agent("nurture_agent", result)
```

OpenClaw can execute the agent. Your app, workflow engine, or orchestration code should still own the business logic.

---

## Security and Production Safety

OpenClaw is powerful because it can connect to real tools, files, channels, and devices. That also means it needs serious guardrails.

The project’s own GitHub README warns that tools run on the host for the `main` session by default, so the agent can have full access when it is just you. For group or channel safety, OpenClaw supports sandboxing for non-main sessions, with Docker as the default sandbox backend and SSH/OpenShell also available. ([GitHub](https://github.com/openclaw/openclaw "GitHub - openclaw/openclaw: Your own personal AI assistant. Any OS. Any Platform. The lobster way.  · GitHub"))

Important production rules:

- Do not expose the dashboard publicly.
    
- Use localhost, Tailscale, VPN, or SSH tunnels for admin access.
    
- Treat inbound messages as untrusted input.
    
- Use pairing and allowlists for DMs.
    
- Use sandboxing for untrusted sessions.
    
- Limit tools with allow/deny lists.
    
- Do not give broad authority on day one.
    
- Add approval gates for risky actions.
    
- Review logs regularly.
    
- Keep secrets out of workspace files and prompts.
    

The workspace docs also warn that the workspace is not a hard sandbox by itself. If you need isolation, configure sandboxing. ([OpenClaw](https://docs.openclaw.ai/concepts/agent-workspace "Agent Workspace - OpenClaw"))

---

## Common Production Patterns

### Logging

Store every run:

```json
{
  "agent": "lead_qualifier",
  "input": {},
  "output": {},
  "timestamp": "2026-05-03T12:00:00Z",
  "duration_ms": 3200,
  "status": "completed"
}
```

This helps with debugging, audits, compliance, and performance tracking.

---

### Retry Logic

```python
for attempt in range(3):
    try:
        result = run_agent("critical_agent", payload)
        break
    except Exception as error:
        if attempt == 2:
            result = run_agent("fallback_agent", payload)
```

Retries should be limited. Infinite retries can create loops, duplicate messages, wasted API spend, or accidental repeated actions.

---

### Escalation

```python
if result["confidence"] < 0.7:
    escalate_to_human(result)
```

Good escalation rules include:

- Low confidence
    
- Missing data
    
- Conflicting information
    
- High-risk action
    
- Payment-related issue
    
- Legal, medical, financial, or safety-sensitive decision
    
- Customer anger or complaint
    
- Unexpected tool failure
    

---

### Human Approval Gates

```python
if action["type"] in ["send_email", "refund_payment", "delete_file"]:
    require_human_approval(action)
else:
    execute_action(action)
```

Approval gates are especially important when the agent can send messages, change records, run commands, delete files, or trigger business actions.

---

### Parallel Agents

```python
agents = ["research_agent", "summary_agent", "risk_agent"]

results = [run_agent(agent, payload) for agent in agents]

final = run_agent("review_agent", results)
```

Parallel agents are useful when you want separate perspectives, such as:

- Research
    
- Risk review
    
- Summary
    
- Fact checking
    
- Compliance review
    
- Customer reply drafting
    

---

## Practical File Structure

A practical setup may look like this:

```text
~/.openclaw/
  openclaw.json
  credentials/
  agents/
    main/
      agent/
        models.json
      sessions/
  workspace/
    AGENTS.md
    SOUL.md
    USER.md
    IDENTITY.md
    TOOLS.md
    HEARTBEAT.md
    MEMORY.md
    memory/
      2026-05-09.md
    skills/
      crm-lookup/
        SKILL.md
      report-writer/
        SKILL.md

/orchestration
  orchestrator.py
  scheduler.py
  webhook_handler.py
  approval_queue.py
  audit_logger.py
```

OpenClaw handles the agent runtime, workspace, tools, skills, sessions, channels, and Gateway. Your orchestration code handles the larger workflow.

Keep secrets out of the workspace. The official workspace docs say files such as `~/.openclaw/openclaw.json`, credentials, auth profiles, and session transcripts live under `~/.openclaw/` and should not be committed to the workspace repo. ([OpenClaw](https://docs.openclaw.ai/concepts/agent-workspace "Agent Workspace - OpenClaw"))

---

## Real-World Use Cases

### Sales Automation

- Qualify leads
    
- Research prospects
    
- Draft outreach
    
- Score opportunities
    
- Summarize CRM history
    
- Escalate hot leads
    
- Send daily pipeline summaries
    

Example:

```text
CRM lead created
        ↓
OpenClaw researches lead
        ↓
Agent scores fit
        ↓
Workflow routes to sales, nurture, or disqualification
```

---

### Customer Support

- Detect intent
    
- Route tickets
    
- Draft replies
    
- Summarize ticket history
    
- Suggest next steps
    
- Escalate risky cases
    
- Monitor angry or urgent customer messages
    

Example:

```text
Support message received
        ↓
Agent classifies intent and urgency
        ↓
Agent drafts reply
        ↓
Human approves or workflow sends if low risk
```

---

### Monitoring and Incident Response

- Review logs
    
- Summarize errors
    
- Suggest fixes
    
- Open tickets
    
- Notify humans
    
- Track recurring failures
    
- Generate post-incident summaries
    

Example:

```text
Error detected
        ↓
OpenClaw agent reviews logs
        ↓
Agent summarizes likely cause
        ↓
Workflow alerts engineer or opens incident ticket
```

---

### Content Automation

- Generate drafts
    
- Rewrite for tone
    
- Check style guides
    
- Prepare publishing checklists
    
- Repurpose content across platforms
    
- Review SEO opportunities
    
- Summarize analytics
    

Example:

```text
New article draft
        ↓
Agent rewrites for clarity
        ↓
Agent creates social snippets
        ↓
Workflow sends to approval queue
```

---

### Personal and Small Business Assistant Workflows

- 24/7 voice or chat receptionist
    
- Appointment booking
    
- Inbox triage
    
- Calendar monitoring
    
- Reminder workflows
    
- Simple CRM updates
    
- Daily briefings
    
- Follow-up message drafting
    

This is one of OpenClaw’s strongest small-business patterns: the agent can live in channels people already use, while your workflow decides what actions are allowed.

---

## Best Way to Think About OpenClaw

OpenClaw is best understood as a self-hosted AI assistant runtime and Gateway.

It can:

- Run AI agents
    
- Connect to model providers
    
- Connect to tools
    
- Manage sessions
    
- Use workspace memory files
    
- Use skills and plugins
    
- Support web and terminal interfaces
    
- Connect to messaging channels
    
- Run scheduled jobs
    
- Support webhooks and external triggers
    
- Work with external workflow systems
    

The web version gives you a browser dashboard. The TUI gives you a terminal interface. Channels let you talk to the assistant from messaging apps. The Gateway ties the system together.

The clean mental model is:

```text
OpenClaw runs the agent.
The model provides the reasoning.
Tools provide actions.
Skills teach tool usage.
Channels provide communication.
The Gateway coordinates sessions and access.
Your system orchestrates the business workflow.
Logs, approvals, and sandboxing keep it production-safe.
```