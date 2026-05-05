
/agents

shows subagents then agents:

![[019d7785-bf70-7428-bc34-7334ecffdfd2.png]]

Example Openclaw TUI:

![[019dee38-3055-76df-8e68-e9daa94ea19b.png]]
# What each line means

- `active subagents: (none)` 
  → No child/worker agents are currently running.

- `recent subagents (last 30m): (none)` 
  → Nothing has been spawned recently either.

- `gateway connected | idle` 
  → The OpenClaw gateway is up and connected, but not doing work.

- `agent main | session main (openclaw-tui)` 
  → You are inside the **primary agent session** (the TUI itself).

- `ollama/qwen2.5:32b` 
  → The main agent is using this model via Ollama.

- `tokens 11k/131k (9%)` 
  → Current context usage — not relevant to agent count.

---

When adding an agent and you chose ollama (instead of any of the online ones or the local litellm)

It will ask you what mode (Cloud + Local vs Cloud only vs Local only)

![[019dee0a-50d3-710d-b639-d46031748351.png]]

After creating multiple agents, you can switch agent in the TUI:
![[019dee12-53fd-737f-a512-c630a215c000.png]]

---

  

/agent vs /agents? In the OpenClaw TUI, they are basically the same command family:


| Command       | Meaning                                                                                  |
| ------------- | ---------------------------------------------------------------------------------------- |
| `/agent <id>` | Switch directly to a specific agent by slug/id, like `/agent main` or `/agent research`. |
| `/agents`     | Open/list the available agents so you can pick one, similar to an agent picker.          |

  

If you typed only `/agent` then it reverts to `/agents` 

which looks like:
![[019dee15-c953-7294-ac9e-b52dbfb82243.png]]


----

  

For openclaw agent connected to ollama, you can see what model available:

```
ollama list
```

----

```
ollama list
ollama pull qwen2.5-coder: 7b-instruct ollama launch openclaw --model|
```

That launches the OpenClaw TUI. Then you can start prompting the model directly:
![[019dee03-45ab-7255-8121-22210e889305.png]]

  

  

Or you could have used /model inside the tui to change model, however it may require a restart of the tui afterwards

  

  

Two approaches here, depending on how separate you want them.

The clean way is 'openclaw agents add project-a' and 'openclaw agents add project-b' inside a single gateway. Each agent gets its own workspace folder ('~/openclaw/workspace-project-a , etc.),

its own SOUL.md and AGENTS.md, its own session store, and its own skills directory. You then set up bindings in your config so inbound messages route to the right agent. Run 'openclaw agents list --bindings' to verify it's wired correctly. Context is fully isolated between agents. They don't share memory or conversation history.

The simpler but heavier way is two separate gateways on different ports. More overhead, two processes to manage, two configs. Works fine but it's overkill for most setups.

  

One gateway with two separate instances is the cleaner way to go, just give each instance its own system prompt and working directory so there's zero context bleed between the


---

  

openclaw agents add project-a
![[019dee05-585d-722b-b5c4-4fe6c9c5870e.png]]


```
/Users/wengffung/.openclaw
└── workspace
    ├── AGENTS.md
    ├── BOOTSTRAP.md
    ├── HEARTBEAT.md
    ├── IDENTITY.md
    ├── project-a
    │   ├── AGENTS.md
    │   ├── BOOTSTRAP.md
    │   ├── HEARTBEAT.md
    │   ├── IDENTITY.md
    │   ├── SOUL.md
    │   ├── TOOLS.md
    │   └── USER.md
    ├── project-b
    │   ├── AGENTS.md
    │   ├── BOOTSTRAP.md
    │   ├── HEARTBEAT.md
    │   ├── IDENTITY.md
    │   ├── SOUL.md
    │   ├── TOOLS.md
    │   └── USER.md
    ├── SOUL.md
    ├── state
    ├── TOOLS.md
    └── USER.md
```


  

It will continue asking you questions:

- auth profiles, configure model now, choose provider (Online, Local LiteLLM, Local Ollama, etc)
![[019dee08-d657-764f-b1f6-73468b337f5e.png]]



---

when I used openclaw agent add.. it creates a folder inside workspace with AGENTS.MD etc However they aren't filled well. Is there a skill.md I can use that will create or write into a better system of AGENTS.MD, SOUL, IDENTITY, USER, TOOL

  

Try this as a SKILL.md:
```
# OpenClaw Workspace Architect Skill

## Purpose

Use this skill to create or improve an OpenClaw agent workspace.

The goal is to write clear, useful, non-bloated workspace files:

- AGENTS.md
- SOUL.md
- IDENTITY.md
- USER.md
- TOOLS.md
- MEMORY.md

The agent must produce practical files that help the OpenClaw agent behave consistently, remember project context, use tools safely, and continue work across sessions.

---

## When to Use This Skill

Use this skill when the user asks to:

- create a new OpenClaw agent workspace
- improve generated OpenClaw workspace files
- write AGENTS.md, SOUL.md, IDENTITY.md, USER.md, or TOOLS.md
- define an agent’s role, personality, rules, tools, memory, or operating style
- make an agent better at coding, research, automation, writing, ops, or project work

---

## File Responsibilities

### SOUL.md

Defines the agent’s core operating philosophy.

Include:

- mission
- decision-making principles
- safety rules
- communication style
- how to handle uncertainty
- how to avoid over-reading files
- how to avoid destructive actions

Do not put tool URLs, shell commands, or environment details here.

---

### AGENTS.md

Defines the agent’s working rules.

Include:

- how the agent should start tasks
- how it should inspect files
- how it should plan
- how it should verify work
- when it should ask questions
- when it should proceed with best effort
- coding standards
- commit/checkpoint behavior
- project-specific workflow

This is the main behavior-control file.

---

### IDENTITY.md

Defines who the agent is.

Include:

- name
- role
- specialty
- strengths
- boundaries
- default tone
- what kind of work it should prioritize

Keep this shorter than AGENTS.md.

---

### USER.md

Defines user preferences.

Include:

- preferred communication style
- preferred output format
- technical skill level
- recurring project preferences
- formatting preferences
- verification expectations
- things the user dislikes

Do not include private secrets.

---

### TOOLS.md

Defines available tools and how to use them.

Include:

- local commands
- dev server URLs
- project paths
- API endpoints
- test commands
- deployment commands
- known tool limitations
- safety notes

Important: TOOLS.md describes tools. It does not grant access to tools. Actual access is controlled by OpenClaw/tool settings.

---

### MEMORY.md

Stores durable project context.

Include:

- current project status
- active milestone
- important decisions
- known issues
- next steps
- recent changes
- assumptions

Keep it factual. Do not use it as a diary.

---

## Output Rules

When creating a workspace, write the files in this order:

1. SOUL.md
2. AGENTS.md
3. IDENTITY.md
4. USER.md
5. TOOLS.md
6. MEMORY.md

For each file:

- use clear headings
- use short bullets
- avoid vague motivational language
- avoid giant walls of text
- make instructions actionable
- include verification steps where useful
- do not include secrets
- do not invent project facts

---

## Default Agent Behavior to Encode

The agent should:

- inspect only the files needed for the task
- summarize what it found before changing code
- make small, safe changes
- verify after every meaningful change
- report exact files changed
- suggest commit messages when useful
- never delete or overwrite important files without explicit approval
- prefer reversible changes
- ask only when blocked
- continue with best effort when the user already gave enough context

---

## Workspace Creation Prompt

When asked to create or improve a workspace, follow this process:

1. Identify the agent’s purpose.
2. Identify the user’s preferred workflow.
3. Identify available tools and project commands.
4. Create or rewrite the workspace files.
5. Keep each file focused on its responsibility.
6. Add a short README-style summary of how to use the workspace.

---

## Quality Checklist

Before finishing, check:

- AGENTS.md contains the main operating rules.
- SOUL.md contains principles, not tool details.
- IDENTITY.md defines role and boundaries.
- USER.md captures user preferences.
- TOOLS.md contains environment/tool notes only.
- MEMORY.md contains current durable context.
- No file contains secrets.
- No file is bloated with duplicate instructions.
```


  

Or look through:

[https://skills.sh/?q=OpenClaw+Workspace+Architect](https://skills.sh/?q=OpenClaw+Workspace+Architect)  

[https://skills.sh/win4r/openclaw-workspace/openclaw-workspace](https://skills.sh/win4r/openclaw-workspace/openclaw-workspace)


----


  

Soul vs Identity

In OpenClaw, **Soul** is the agent’s internal behavior layer: its personality, values, tone, boundaries, how it handles uncertainty, when it pushes back, and how it should think while working. **Identity** is the agent’s outward self-presentation: its name, role, avatar/display style, and how it introduces itself to the user. Put simply: **Soul is what the agent embodies; Identity is what the user sees.** That separation matters because you could have an agent with a serious, precise, safety-focused soul but a friendly nickname and casual visual identity. OpenClaw’s docs describe these files as part of the “identity layer” that shapes the agent’s responses, while other OpenClaw writeups summarize it as: Soul defines who the agent is internally, and Identity defines who the agent thinks/presents itself as.


---

  
You can configure the default model

  

vi ~/.openclaw/openclaw.json

(Partial code snippet):

```
{
  "agents": {
    "defaults": {
      "model": {
        "primary": "ollama/qwen2.5-coder:7b-instruct"
      },
      "workspace": "/Users/wengffung/.openclaw/workspace"
    },
    "list": [
      {
        "id": "main"
      },
      {
        "id": "project-a",
        "name": "project-a",
        "workspace": "/Users/wengffung/.openclaw/workspace/project-a",
        "agentDir": "/Users/wengffung/.openclaw/agents/project-a/agent"
      },
      {
        "id": "project-b",
        "name": "project-b",
        "workspace": "/Users/wengffung/.openclaw/workspace/project-b",
        "agentDir": "/Users/wengffung/.openclaw/agents/project-b/agent"
      }
    ]
  },
  "auth": {
    "profiles": {
      "ollama:default": {
        "mode": "api_key",
        "provider": "ollama"
      }
    }
  },
```


---

  

In OpenClaw TUI, typing `/status`  looks like:

![[019d7783-1446-712c-b2fd-bd48b01dcc95.png]]


---


  

There’s `/restart`  in Openclaw TUI. Looks like:

![[019dee40-3a63-7735-82f2-fce0b9697523.png]]


---



OpenClaw-Ollama-qwen2.5:32b
Whatever method you use, maybe hitting an endpoint at OpenClaw or using OpenClaw, you asked a question

Then you can see logs under both tui and ollama’s stdout terminal:

your terminal that has openclaw tui opened will show the recent / last requests, which model, how many tokens used, etc:
![[019dee42-b833-734e-9bbe-46db31dc77ac.png]]

  

ollama terminal (if serving in foreground in terminal)
![[019d777e-5937-752d-8103-efec43bf8cfa.png]]

---

  

Reference:

openclaw daemon start

openclaw daemon stop

openclaw gateway start

And more:
...


---

  

Reference starting

  

1…

openclaw daemon start
openclaw gateway start

  

Daemon:  
Starts the core engine (the brain + runtime)  
Runs the main OpenClaw service

- Manages:
- Agents
- Sessions
- Task execution
- Model calls (e.g., Ollama, OpenAI, etc.)

  

Gateway:

**Starts the interface layer (the bridge/API)**

- Exposes OpenClaw over:

- HTTP / API
- WebSocket (for streaming tokens)

- Lets external tools connect:

- TUI (`openclaw-tui`)
- Your custom dashboard
- Other services

- Think of this as:
    
    > “The API server that lets you _talk to_ OpenClaw”
    

  

## ⚠️ Key Differences

|   |   |   |   |
|---|---|---|---|
|Command|Role|Required?|What breaks without it|
|`openclaw daemon start`|Core runtime|✅ YES|Nothing executes|
|`openclaw gateway start`|API bridge|❌ Optional (but usually needed)|No external access (TUI/API won’t work)|

  

2..

openclaw tui

  

note:

If you had not started the daemon, you’d get error:  
 gateway disconnected: closed | idle                               
 agent main | session main | unknown | tokens ?

  

and /status would’ve given you error:

 not connected to gateway — message not sent                       
 gateway disconnected: closed | idle                               
 agent main | session main | unknown | tokens ? 

  

3…

  

Prefer the web ui? Takes a lot of memory compared to the TUI though. Starting is a bit rough (not just running one command)

  

Investigate:

Visit on web browser: [http://127.0.0.1:18789](http://127.0.0.1:18789 "http://127.0.0.1:18789")

And the login form looks like:

![[Pasted image 20260505050546.png]]

  

  

It expects a token either in the field OR in the url

  

A variation of its instructions to make our experience smooth: (Not openclaw gateway run because we start the daemon instead), run:

openclaw dashboard --no-open

^ The variation is --no-open so it wont open the web browser, that’s all:
![](http://localhost:9425/images/019d7c63-02ba-701b-a8bd-5a26950347f7.png)

  

Then visit the url, then you’re in! Web dashboard looks like:
![](http://localhost:9425/images/019d7c64-7c0b-7438-a4f0-97d36d6cca39.png)


---

  

First skills to install in openclaw:

  

If you're getting started with OpenClaw, the best approach is to install a small set of foundational skills that make the system actually useful right away. Think of these as your "core toolkit":

1. Web Browsing / Search

- ﻿﻿Lets OpenClaw look up information online in real time
- ﻿﻿Essential for answering questions, research, and automation
- ﻿﻿Usually called something like "browser*, "web_search", or "internet"

2. File System Access

- ﻿﻿Allows reading/writing files on your machine
- ﻿﻿Needed for saving outputs, organizing data, and automation workflows
- ﻿﻿Look for: "filesystem", "file_manager", or "local_files*

3. Terminal / Command Execution

- Gives OpenClaw the ability to run shell commands
- ﻿﻿Crucial for automation, coding tasks, and system control
- ﻿﻿Often labeled "terminal, "shell", or "command_runner*

4. Code Execution (Python or Node)

- ﻿﻿Lets it run scripts, process data, and automate logic
- ﻿﻿Extremely useful for anything beyond basic tasks
- ﻿﻿Usually appears as "python", "code_executor", etc.

5. API / HTTP Requests

- ﻿﻿Enables connecting to external services (APis, SaaS tools, etc.)
- ﻿﻿Important for integrations (Slack, Notion, databases, etc.)
- ﻿﻿Look for: "http", "requests", or "api_client"

  

Together, they let OpenClaw:

- ﻿﻿Access info (web)
- ﻿﻿Store/manage data (files)
- ﻿﻿Act on your system (terminal)
- ﻿﻿Think & compute (code execution)
- ﻿﻿Connect to other tools (API)

Without these, most advanced workflows won't work.


---

  

## OBS OpenClaw needs to add orchestration layer? - Yes

OpenClaw is an open-source framework designed to run agents locally or on a server. It can handle scheduled tasks and trigger agents, performing actions like email cleanup or calendar management. However, it's not primarily built for complex routing or coordinating multiple agents in sequence. For intricate workflows, you might still need an external orchestration tool.  
  

An external orchestration tool—like Apache Airflow, n8n, or Zapier-can orchestrate for you. Those tools can set conditions, sequences, or branching logic, triggering your OpenClaw agents in whatever order or scenario you need. As long as the agents or tasks exposed by OpenClaw can be triggered through an APl, command-line interface, or some executable form, then this is possible.