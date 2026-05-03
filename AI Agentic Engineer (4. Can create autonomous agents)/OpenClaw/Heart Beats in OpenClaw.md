A `HEARTBEAT.md` file is a small instruction file that tells an AI agent what to check during periodic heartbeat runs.

A heartbeat is not the same as a normal user prompt. Instead of waiting for a person to ask something, the agent system wakes up on a schedule and gives the agent a small maintenance turn.

In OpenClaw, heartbeat runs are described as periodic agent turns in the main session. The goal is to let the model surface something that needs attention without spamming the user. Heartbeat runs are scheduled turns, not detached background task records. ([OpenClaw][1])

A simple heartbeat flow looks like this:

```text
Heartbeat tick happens
        ↓
Runtime or heartbeat script wakes up
        ↓
It checks heartbeat settings / HEARTBEAT.md
        ↓
If there is nothing to do, it may skip the model call
        ↓
If there is work, it sends a heartbeat prompt to the AI model
        ↓
The model replies HEARTBEAT_OK or sends a useful update
```

^ When checking heartbeat settings, do we use a local model to check? > Usually, no. Those are deterministic checks. A Bash script, Node script, Python script, cron job, or the **agent runtime** can do them cheaply. (Agent runtime = the system that wakes up, checks settings, reads files, manages tools, starts sessions, and decides whether to call the model. It is NOT an AI Agent but because of the shared word Agent, beginners may think they're similiar)


The important idea is this:

```text
The runtime may be available 24/7.

The model does not need to think 24/7.
```

---

# The Default `HEARTBEAT.md`

A default `HEARTBEAT.md` can stay almost empty.

```markdown
# HEARTBEAT.md Template

# Keep this file empty, or with only comments, to skip heartbeat API calls.

# Add tasks below when you want the agent to check something periodically.
```

This means:

```text
No real heartbeat tasks configured.
No need to call the AI model.
```

That default is useful when the agent should only respond to normal user messages and should not do extra maintenance work between conversations.

---

# Expanded `HEARTBEAT.md` Example

If heartbeat should do useful light maintenance, the file can become a checklist.

```markdown
# Heartbeat Checklist

Rotate through these on each heartbeat tick.

Pick 2–3 items per heartbeat. Skip the rest.

If nothing applies, reply:

HEARTBEAT_OK

---

## 1. Heartbeat State

Check:

memory/heartbeat-state.json

Update `lastChecks` timestamps for the items you ran.

If the file does not exist, create it with a simple skeleton structure.

---

## 2. Daily Note

Determine today’s date in America/Los_Angeles using the runtime-provided current time or a safe system clock command.

Use this format:

memory/YYYY-MM-DD.md

Append one short line only if something notable happened since the last heartbeat.

Do not add filler.

---

## 3. MEMORY.md

Review recent activity.

If there is a clear win, lesson, decision, or recurring issue from the last few days, add one short bullet to:

MEMORY.md

Do not bloat the file.

Only save information that is likely to help future work.

---

## 4. Open Loops

Skim:

- MEMORY.md
- Yesterday’s daily note

Look for stalled tasks, unresolved blockers, or items waiting on the user.

If something is clearly blocked on the user, send one short update with the blocker.

Do not spam.

Example:

Blocked: need approval before pushing the auth changes.

---

## 5. Repo / Workspace Check

If this workspace matters, optionally run a safe workspace check such as:

git status

If there is meaningful drift, note it in the daily file.

Do not commit, push, delete, reset, or modify repo history unless explicitly asked.

---

## Quiet Hours

Quiet hours are 23:00–08:00 in America/Los_Angeles.

Before doing non-urgent heartbeat work, determine the current local time using runtime-provided time context or a safe system clock command.

If the current time is during quiet hours and nothing is urgent, reply only:

HEARTBEAT_OK
```

^ The `memory/heartbeat-state.json` file is a small tracking file that helps the agent remember what it already checked during previous heartbeat runs. Instead of treating every tick like a brand-new event, the agent can read this file to see timestamps such as when it last checked daily notes, reviewed open loops, scanned `MEMORY.md`, or looked at repo drift. This lets the agent rotate through tasks intelligently, avoid repeating the same check too often, and prevent noisy duplicate updates. For example, if `lastChecks.dailyNote` was updated 20 minutes ago, the agent can skip that item and check something else instead. In short, `heartbeat-state.json` gives heartbeat memory, pacing, and anti-spam behavior.

The purpose is not to make the agent busy.

The purpose is to let the agent do small, safe, useful checks.

---

# What Is the Agent Runtime?

The **agent runtime** is the program that coordinates the agent.

The AI model is the brain.

The runtime is the body, nervous system, scheduler, and tool manager.

```text
AI model
  = thinks and generates responses

Agent runtime
  = keeps the agent system alive
  = receives messages
  = manages sessions
  = gives the model tools
  = connects to files, channels, and APIs
  = decides when to call the model
  = handles heartbeat ticks
```

In OpenClaw, this runtime layer is mainly the **Gateway**. OpenClaw configuration is stored in `~/.openclaw/openclaw.json`, and that config can control channels, models, tools, sandboxing, automation, sessions, networking, UI, and heartbeat behavior. ([OpenClaw][2])

So the runtime is not the same thing as the model.

The runtime may stay running in the background.

The model is usually called only when there is an actual message, task, tool run, or heartbeat turn.

---

# Does Heartbeat Mean the Model Runs 24/7?

No.

Heartbeat does not usually mean the model is actively running all day.

A better mental model is:

```text
Runtime / Gateway
  = available 24/7

AI model
  = called only when needed
```

For cloud models, the model is not running on the local machine at all. The runtime sends an API request when a heartbeat needs model reasoning.

For local models, a local inference server may stay open, such as:

```text
Ollama
LM Studio
llama.cpp server
local inference server
```

That server may stay loaded in memory, but the model only actively generates when it receives a prompt.

So the practical version is:

```text
The agent system may stay awake.

The model usually only works during scheduled ticks or user requests.
```

---

# Does Every Heartbeat Tick Send a Prompt to the AI Model?

Not always.

A basic implementation may call the model every time the heartbeat interval fires.

```text
Tick happens
        ↓
Runtime sends heartbeat prompt to model
        ↓
Model reads HEARTBEAT.md
        ↓
Model replies HEARTBEAT_OK or sends an alert
```

That works, but it can waste tokens, API calls, logs, and local compute.

A more efficient implementation does a cheap pre-check first.

```text
Tick happens
        ↓
Runtime or heartbeat script reads HEARTBEAT.md
        ↓
If no real tasks exist, stop
        ↓
If real tasks exist, call the model
```

OpenClaw’s heartbeat docs describe a related optimization for `tasks:` blocks: OpenClaw checks tasks against their own intervals, includes only due tasks in the heartbeat prompt, and skips the heartbeat entirely if no tasks are due. ([OpenClaw][1])

So the clean answer is:

```text
A heartbeat tick does not have to call the model.

The scheduler can wake up first.

The runtime or heartbeat script can decide whether the model needs to be called.
```

---

# Who Checks `HEARTBEAT.md` at Every Tick?

Usually, a lightweight part of the system checks first.

That could be:

```text
- Agent runtime
- Gateway
- Heartbeat script
- Cron job
- Daemon
- Queue worker
- Platform scheduler
```

The model does not have to wake up first.

The flow can be:

```text
Scheduler tick
        ↓
Runtime/script checks HEARTBEAT.md
        ↓
No real tasks? → stop
        ↓
Real tasks? → call AI model
        ↓
Agent performs heartbeat checklist
        ↓
Agent replies HEARTBEAT_OK or sends useful update
```

This distinction matters because the runtime can do cheap deterministic checks, while the model should only be used when reasoning is needed.

---

# How the Runtime Knows Whether `HEARTBEAT.md` Has Real Tasks

The runtime or heartbeat script can inspect `HEARTBEAT.md` as plain text before sending it to the AI model.

A simple version may check:

```text
- Does HEARTBEAT.md exist?
- Is it empty?
- Does it only contain blank lines?
- Does it only contain comments or headings?
- Does it contain actual task instructions?
```

For example, this file has no real tasks:

```markdown
# HEARTBEAT.md Template

# Keep this file empty, or with only comments, to skip heartbeat API calls.

# Add tasks below when you want the agent to check something periodically.
```

Even though it contains text, it is basically saying:

```text
No heartbeat work configured.
```

A file with real tasks may look like:

```markdown
# Heartbeat Checklist

- Check memory/heartbeat-state.json
- Update today’s daily note if something notable happened
- Skim MEMORY.md for blockers
- Reply HEARTBEAT_OK if nothing applies
```

Now the runtime can treat heartbeat as active.

A very simple heartbeat script could use logic like this:

```bash
#!/usr/bin/env bash
set -euo pipefail

FILE="HEARTBEAT.md"

if [ ! -f "$FILE" ]; then
  exit 0
fi

REAL_CONTENT="$(grep -vE '^\s*$|^\s*#' "$FILE" || true)"

if [ -z "$REAL_CONTENT" ]; then
  echo "No heartbeat tasks. Skipping model call."
  exit 0
fi

echo "Heartbeat tasks found. Call the agent/model here."
# run-agent-heartbeat main
```

That example is intentionally simple.

A more advanced runtime could parse Markdown checklists, YAML frontmatter, or structured `tasks:` blocks.

The important concept is:

```text
The heartbeat scheduler can wake up without automatically involving the model.

The model only needs to be called when there is actual heartbeat work to evaluate.
```

---

# What Is `HEARTBEAT_OK` For?

`HEARTBEAT_OK` is the no-op response.

It means:

```text
Nothing important needs attention right now.
```

OpenClaw’s default heartbeat prompt tells the agent to read `HEARTBEAT.md`, follow it strictly, avoid repeating old tasks from prior chats, and reply `HEARTBEAT_OK` if nothing needs attention. ([OpenClaw][1])

This is useful because most heartbeat runs should be quiet.

Without a no-op contract, the model may feel like it needs to produce a full update every time it wakes up.

That creates noise.

A good heartbeat system should make boring heartbeats disappear.

---

# Does the Agent Know What Time It Is?

Only if the runtime gives it time context.

The model itself does not automatically know the real current time. It only knows what appears in the prompt, system context, files, or tools.

A heartbeat agent may know the time because:

```text
1. The runtime injects the current timestamp into the heartbeat prompt
2. The agent has a tool that can check the system clock
3. The heartbeat script passes the time as a variable
4. The agent reads/writes files using today’s date
```

A good heartbeat prompt may include:

```text
Current time: 2026-05-03 04:42 America/Los_Angeles
```

Or the agent may use a safe system command:

```bash
TZ=America/Los_Angeles date +%F
```

That returns the current date in `YYYY-MM-DD` format.

---

# Does the Agent Always Need to Know the Time?

No.

Time only matters for heartbeat tasks that depend on time.

The agent needs time context for things like:

```text
- Quiet hours
- Daily notes
- Today’s file
- Yesterday’s file
- Overdue tasks
- Reminder timing
- “Since last heartbeat”
- “Blocked for more than 24 hours”
- Morning vs evening behavior
```

For example, this task requires time:

```markdown
Open memory/YYYY-MM-DD.md using today’s date in America/Los_Angeles.
```

This task also requires time:

```markdown
During quiet hours from 23:00–08:00, reply HEARTBEAT_OK only unless urgent.
```

Without the current time, the model could guess incorrectly.

But time is less important for simple workspace checks:

```text
- Check git status
- Look for uncommitted changes
- Skim MEMORY.md for obvious blockers
- Reply HEARTBEAT_OK if nothing applies
```

The rule is:

```text
If the task uses today, yesterday, quiet hours, overdue, since last check, or reminders,
give the agent the current timestamp.

If the task is a simple workspace check,
exact time may not matter.
```

Still, the safest setup is to inject the current timestamp into every heartbeat prompt.

It is cheap context and prevents confusion.

---

# How Are Heartbeat Ticks Set?

`HEARTBEAT.md` usually does not control when the agent wakes up.

It controls what the agent should do after it wakes up.

The tick schedule usually lives in:

```text
- Agent runtime settings
- Gateway config
- Cron
- systemd timer
- LaunchAgent
- Queue worker
- Platform scheduler
```

In OpenClaw, heartbeat intervals can be configured with `every`, such as `30m`, and setting `every` to `0m` disables heartbeat. The docs also show per-agent heartbeat configuration through `agents.list[].heartbeat.every`. ([OpenClaw][1])

The clean distinction is:

```text
Scheduler
  = when to wake up

Runtime / Gateway
  = how to run the agent

HEARTBEAT.md
  = what to check

Model
  = reasons over the prompt
```

---

# Can Different Agents Have Different Heartbeat Intervals?

Yes.

Different agents should often have different heartbeat intervals.

Not every agent needs to wake up at the same rate.

Example:

```text
Main workspace agent       Every 30–60 minutes
Memory agent               Every 2–6 hours
Repo review agent           Every 1–4 hours during active work
Monitoring agent            Every 5–15 minutes
Daily summary agent         Once per day
Coding agent                On demand only
```

A monitoring agent may need frequent checks.

A memory agent may only need a few checks per day.

A coding agent may not need heartbeat unless it has an active assignment.

A practical rule:

```text
The more urgent the job, the shorter the heartbeat interval.

The more expensive or risky the job, the longer the heartbeat interval.
```

OpenClaw supports per-agent heartbeat settings, and the docs note that per-agent settings merge on top of defaults. The docs also describe active hours, where heartbeat runs can be skipped outside the configured local-time window. ([OpenClaw][1])

---

# Basic OpenClaw Runtime Setup

A basic OpenClaw setup has four parts:

```text
1. Install OpenClaw
2. Start or install the Gateway runtime
3. Configure heartbeat
4. Add HEARTBEAT.md to the workspace
```

OpenClaw’s install docs recommend the installer script because it detects the OS, installs Node if needed, installs OpenClaw, and launches onboarding. ([OpenClaw][3])

```bash
curl -fsSL https://openclaw.ai/install.sh | bash
```

After installation, the normal setup path is to run onboarding:

```bash
openclaw onboard --install-daemon
```

For testing the Gateway manually:

```bash
openclaw gateway --port 18789
```

To check status:

```bash
openclaw gateway status
openclaw status
openclaw logs --follow
```

The config file lives here:

```text
~/.openclaw/openclaw.json
```

OpenClaw watches this config file and can apply many changes automatically without a manual restart. Its docs describe hot reload for many categories, including automation and heartbeat-related settings. ([OpenClaw][2])

---

# Example `openclaw.json` Heartbeat Config

A simple default heartbeat config may look like:

```json
{
  "agents": {
    "defaults": {
      "heartbeat": {
        "every": "30m",
        "target": "none"
      }
    }
  }
}
```

Meaning:

```text
every: "30m"
  Run heartbeat every 30 minutes.

target: "none"
  Run heartbeat internally, but do not send external messages by default.
```

A more advanced setup:

```json
{
  "agents": {
    "defaults": {
      "heartbeat": {
        "every": "30m",
        "target": "none",
        "lightContext": true,
        "isolatedSession": true,
        "prompt": "Read HEARTBEAT.md if it exists. Follow it strictly. If nothing needs attention, reply HEARTBEAT_OK."
      }
    },
    "list": [
      {
        "id": "main",
        "default": true
      },
      {
        "id": "memory",
        "heartbeat": {
          "every": "4h",
          "target": "none"
        }
      },
      {
        "id": "repo-review",
        "heartbeat": {
          "every": "2h",
          "target": "none"
        }
      }
    ]
  }
}
```

This creates different heartbeat cadences for different agents.

---

# Heartbeat vs Cron

Heartbeat and cron are related, but they are not the same.

Heartbeat is best for:

```text
- Checking whether anything needs attention
- Reviewing memory notes
- Surfacing blockers
- Sending a small alert
- Saying HEARTBEAT_OK if nothing matters
```

Cron is better for:

```text
- Running a specific command at a specific time
- Executing a fixed script
- Performing deterministic jobs
- Running isolated scheduled tasks
```

A simple way to think about it:

```text
Heartbeat asks:
“Does anything need attention?”

Cron says:
“Run this job now.”
```

Use heartbeat for lightweight awareness.

Use cron for specific scheduled work.

---

# What Heartbeat Should Do

Good heartbeat tasks are small and safe.

Examples:

```text
- Update a heartbeat state file
- Append one useful line to a daily note
- Check for unresolved blockers
- Record one useful lesson in MEMORY.md
- Note repo drift with git status
- Send one short alert if something is clearly blocked
```

Good heartbeat tasks have limits.

For example:

```text
Pick 2–3 items per heartbeat.

Do not bloat memory.

Do not spam.

Do not repeat old tasks.

Reply HEARTBEAT_OK if nothing applies.
```

Heartbeat should feel like an operator checking a dashboard, not like a developer starting a new project.

---

# What Heartbeat Should Not Do

Heartbeat should avoid risky actions.

Avoid giving it permission to:

```text
- Push code
- Delete files
- Reset branches
- Rewrite git history
- Make large edits
- Run expensive jobs without limits
- Send repeated reminders
- Contact people repeatedly
- Continue coding without an active assignment
```

A heartbeat agent should be conservative.

It should notice things, summarize things, and ask for approval when needed.

It should not surprise the user.

---

# Recommended Final `HEARTBEAT.md`

Here is a clean practical version:

```markdown
# Heartbeat Checklist

Rotate through these on each heartbeat tick.

Pick 2–3 items per heartbeat. Skip the rest.

If nothing applies, reply:

HEARTBEAT_OK

---

## 1. Heartbeat State

Check:

memory/heartbeat-state.json

Update `lastChecks` timestamps for the items you ran.

If the file does not exist, create it with a simple skeleton structure.

---

## 2. Daily Note

Determine today’s date in America/Los_Angeles using runtime-provided current time or a safe system clock command.

Use this format:

memory/YYYY-MM-DD.md

Append one short line only if something notable happened since the last heartbeat.

Do not add filler.

---

## 3. MEMORY.md

Review recent activity.

If there is a clear win, lesson, decision, or recurring issue from the last few days, add one short bullet to:

MEMORY.md

Do not bloat the file.

Only save information that is likely to help future work.

---

## 4. Open Loops

Skim:

- MEMORY.md
- Yesterday’s daily note

Look for stalled tasks, unresolved blockers, or items waiting on the user.

If something is clearly blocked on the user, send one short update with the blocker.

Do not spam.

Example:

Blocked: need approval before pushing the auth changes.

---

## 5. Repo / Workspace Check

If this workspace matters, optionally run a safe workspace check such as:

git status

If there is meaningful drift, note it in the daily file.

Do not commit, push, delete, reset, or modify repo history unless explicitly asked.

---

## Quiet Hours

Quiet hours are 23:00–08:00 in America/Los_Angeles.

Before doing non-urgent heartbeat work, determine the current local time using runtime-provided time context or a safe system clock command.

If the current time is during quiet hours and nothing is urgent, reply only:

HEARTBEAT_OK
```

---

# Practical Mental Model

A heartbeat system has four layers:

```text
Scheduler
  Decides when a tick happens.

Runtime / Gateway
  Wakes up, checks config, manages sessions, and decides whether to call the model.

HEARTBEAT.md
  Tells the agent what to check.

AI model
  Reasons over the heartbeat prompt and replies.
```

So when someone says:

```text
The agent reads HEARTBEAT.md every 30 minutes.
```

The more accurate version is:

```text
The scheduler ticks every 30 minutes.

The runtime wakes up and checks whether heartbeat should run.

If needed, the runtime sends a heartbeat prompt to the AI model.

The model follows HEARTBEAT.md and replies HEARTBEAT_OK or sends a useful update.
```

That distinction matters.

It means the system can stay available without the model constantly running.

It also means heartbeat can be designed to save tokens, reduce noise, and avoid risky autonomous behavior.

A good `HEARTBEAT.md` should be boring, limited, and predictable.

That is exactly what a background agent needs.

[1]: https://docs.openclaw.ai/gateway/heartbeat "Heartbeat - OpenClaw"
[2]: https://docs.openclaw.ai/gateway/configuration "Configuration - OpenClaw"
[3]: https://docs.openclaw.ai/install?utm_source=chatgpt.com "Install"
