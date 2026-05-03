OpenClaw is a self-hosted AI agent system you can run on your own machine or server. It gives an AI assistant a place to live, connect to tools, respond through channels, and operate through a local gateway. In simple terms, OpenClaw is not the AI model itself. It is the runtime, gateway, and harness around the model. (GitHub)

A useful mental model is:

|Layer|What It Does|
|---|---|
|AI model|Generates reasoning and responses|
|OpenClaw|Runs the assistant, tools, sessions, channels, and gateway|
|Your code or workflow|Decides what should happen next|
|External systems|Provide data, triggers, files, APIs, logs, and business logic|

So OpenClaw can run the agent, but your surrounding system usually decides the larger workflow.

For example:

```text
New lead comes in
        ↓
Your app or n8n workflow detects it
        ↓
OpenClaw agent analyzes the lead
        ↓
Your workflow decides whether to send outreach, nurture, or escalate
```

OpenClaw is strongest when treated as an **agent execution layer**, not as your entire business automation system.

---

## Core Concepts

### Agents

An agent is a configured AI worker. It can have a name, role, model, tools, memory, workspace, and routing rules.

Examples:

- Lead qualifier
    
- Coding assistant
    
- Research agent
    
- Support triage agent
    
- Monitoring agent
    
- Report generator
    

An agent should have a focused job. The more specific the role, the easier it is to test and improve.

---

### Identity

An identity defines how the agent behaves.

This can include:

- Tone
    
- Role
    
- Constraints
    
- Rules
    
- Communication style
    
- What the agent should or should not do
    

Think of identity as the agent’s “job description plus personality.”

Example:

```md
You are a strict analyst.
Be concise.
Do not speculate.
Always explain your reasoning.
Escalate uncertain cases.
```

---

### Tools

Tools let the agent interact with the outside world.

Examples:

- Browser
    
- Filesystem
    
- Shell commands
    
- APIs
    
- Databases
    
- Messaging channels
    
- Webhooks
    
- Cron jobs
    

This is what makes agents different from basic chatbots. A chatbot answers. An agent can answer **and act**.

OpenClaw supports tool and automation surfaces such as browser, canvas, nodes, cron, sessions, and channel actions. ([GitHub](https://github.com/openclaw/openclaw "GitHub - openclaw/openclaw: Your own personal AI assistant. Any OS. Any Platform. The lobster way.  · GitHub"))

---

## Web Version vs TUI Version

OpenClaw can be used through different interfaces. These are not separate “brains.” They are different ways to talk to the same OpenClaw gateway and agents.

### Web Version

The web version is the browser-based Control UI. It lets you chat, view sessions, manage configuration, and interact with the gateway from a browser. By default, the local dashboard is served at:

```text
http://127.0.0.1:18789/
```

You can also open it with:

```bash
openclaw dashboard
```

The official docs describe the Web Control UI as a browser dashboard for chat, config, sessions, and nodes. ([OpenClaw](https://docs.openclaw.ai/?utm_source=chatgpt.com "OpenClaw - OpenClaw"))

You can also connect OpenClaw to Open WebUI using its OpenAI-compatible API endpoint, which gives you a polished browser chat frontend for OpenClaw agents. ([Open WebUI](https://docs.openwebui.com/getting-started/quick-start/connect-an-agent/openclaw/ "OpenClaw / Open WebUI"))

### TUI Version

The TUI is the terminal user interface. It lets you chat with and control the agent from your terminal.

Common commands:

```bash
openclaw tui
openclaw chat
openclaw tui --local
```

The TUI can connect to the Gateway, or run in local embedded mode. The docs note that `chat` and `terminal` are aliases for `openclaw tui --local`. ([OpenClaw](https://docs.openclaw.ai/cli/tui?utm_source=chatgpt.com "openclaw tui"))

Use the TUI when you want a developer-style workflow. Use the web version when you want a visual dashboard.

---

## How to Install OpenClaw

The fastest install path is the official installer script. It detects your operating system, installs Node if needed, installs OpenClaw, and launches onboarding. ([OpenClaw](https://docs.openclaw.ai/install "Install - OpenClaw"))

### macOS / Linux / WSL2

```bash
curl -fsSL https://openclaw.ai/install.sh | bash
```

### Windows PowerShell

```powershell
iwr -useb https://openclaw.ai/install.ps1 | iex
```

### Install Without Onboarding

```bash
curl -fsSL https://openclaw.ai/install.sh | bash -s -- --no-onboard
```

### Install with npm

If you already manage Node yourself:

```bash
npm install -g openclaw@latest
openclaw onboard --install-daemon
```

OpenClaw currently recommends Node 24, with Node 22.14+ also supported. The official install docs also list `openclaw --version`, `openclaw doctor`, and `openclaw gateway status` as basic verification commands. ([OpenClaw](https://docs.openclaw.ai/install "Install - OpenClaw"))

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

### 1. Manual Runs

Useful for testing, debugging, and one-off tasks.

```bash
openclaw agent --message "Review this checklist"
```

### 2. Web Dashboard

Useful for managing and chatting with agents visually.

```bash
openclaw dashboard
```

### 3. TUI

Useful for terminal-first workflows.

```bash
openclaw tui
```

### 4. Channels

OpenClaw can connect to channels such as Telegram, Slack, Discord, WhatsApp, and others. Its Gateway handles sessions, routing, and channel connections. ([GitHub](https://github.com/openclaw/openclaw "GitHub - openclaw/openclaw: Your own personal AI assistant. Any OS. Any Platform. The lobster way.  · GitHub"))

### 5. Cron, Webhooks, and External Automation

OpenClaw can be part of scheduled or event-based workflows. Your external system can trigger the agent when something happens, such as:

- New lead received
    
- Error detected
    
- Payment failed
    
- Daily report needed
    
- File uploaded
    
- Support message received
    

---

## Where OpenClaw Stops

OpenClaw can run the agent, manage sessions, expose tools, and connect channels.

But your larger system may still need to decide:

- Which agent should run next
    
- Whether the result is good enough
    
- Whether to retry
    
- Whether to escalate to a human
    
- Whether to store the result
    
- Whether to trigger another workflow
    

That is the orchestration layer.

Example:

```python
result = run_agent("lead_qualifier", lead_data)

if result["status"] == "qualified":
    run_agent("sales_outreach", result)
else:
    run_agent("nurture_agent", result)
```

OpenClaw executes the agent. Your app decides the flow.

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
  "duration_ms": 3200
}
```

This helps with debugging, audits, and performance tracking.

### Retry Logic

```python
for attempt in range(3):
    try:
        run_agent("critical_agent", payload)
        break
    except Exception:
        if attempt == 2:
            run_agent("fallback_agent", payload)
```

### Escalation

```python
if result["confidence"] < 0.7:
    run_agent("human_review_agent", result)
```

### Parallel Agents

```python
agents = ["research_agent", "summary_agent", "risk_agent"]
```

You can run multiple agents against the same problem, then compare results.

---

## Example File Structure

A practical setup may look like this:

```text
/openclaw
  /agents
    lead_qualifier.md
    outreach_agent.md
    support_triage.md

  /identities
    strict_analyst.md
    friendly_support.md

  /skills
    crm_lookup/
    report_writer/

/orchestration
  orchestrator.py
  scheduler.py
  webhook_handler.py
```

OpenClaw handles the agent side. Your orchestration code handles the workflow side.

---

## Real-World Use Cases

### Sales Automation

- Qualify leads
    
- Draft outreach
    
- Score opportunities
    
- Escalate hot leads
    

### Customer Support

- Detect intent
    
- Route tickets
    
- Draft replies
    
- Escalate risky cases
    

### Monitoring and Incident Response

- Review logs
    
- Summarize errors
    
- Suggest fixes
    
- Notify humans
    

### Content Automation

- Generate drafts
    
- Review quality
    
- Rewrite for tone
    
- Prepare publishing checklists
    

---

## Final Summary

OpenClaw is best understood as a **self-hosted agent runtime and gateway**.

It can:

- Run AI agents
    
- Connect to tools
    
- Manage sessions
    
- Support web and terminal interfaces
    
- Connect to messaging channels
    
- Work with cron jobs, webhooks, and external workflows
    

The web version gives you a browser dashboard. The TUI gives you a terminal interface. Both connect back to the same core idea: OpenClaw gives your AI agent a place to run.

The clean mental model is:

```text
OpenClaw runs the agent.
Your system orchestrates the workflow.
External tools provide data and actions.
Logs and monitoring keep it production-safe.
```