# SKILL: OpenClaw Workspace Architect

If `openclaw agent add` creates workspace files that feel too thin, use this skill template to generate stronger versions of:

- `AGENTS.md`
- `SOUL.md`
- `IDENTITY.md`
- `USER.md`
- `TOOLS.md`
- `MEMORY.md`

Template:

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
- define an agent's role, personality, rules, tools, memory, or operating style
- make an agent better at coding, research, automation, writing, ops, or project work

---

## File Responsibilities

### SOUL.md

Defines the agent's core operating philosophy.

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

Defines the agent's working rules.

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

1. Identify the agent's purpose.
2. Identify the user's preferred workflow.
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


Related links:

[https://skills.sh/?q=OpenClaw+Workspace+Architect](https://skills.sh/?q=OpenClaw+Workspace+Architect)  

[https://skills.sh/win4r/openclaw-workspace/openclaw-workspace](https://skills.sh/win4r/openclaw-workspace/openclaw-workspace)
