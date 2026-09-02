A loop prompt is a reusable instruction that an agent executes **one tick at a time**, then wakes itself and runs again, until a **stop condition** fires or a human stops the process.

A prompt gives one instruction. A loop chases a **goal**: it keeps working, grading, and fixing until it hits that goal, a stop condition, or a human stops it. Unlike automation’s fixed steps, the path can change; the destination is what stays still.

A **tick** is either:

- A **time interval** (`30s`, `5m`, `2h`) — a feature, a wait, or X minutes on a clock. Usual when you meta-prompted the agent to write a loop-prompt `.md` file and then run `/loop` against it on a timer.
- A **unit of work** — one slice implemented, one feature, one milestone, one criterion tested, one defect repaired. Usual for dynamic `/loop` with no interval: the next tick starts when that unit is done, not when a timer fires.

You can ask the agent to **figure out the tick** (and often the stop conditions) when you meta-prompt it to create the loop file.

Use it when the work is a backlog that can be drained without waiting for a casual “continue”: implement the next slice, verify it, persist progress, repeat. People already use the same idea for back-in-stock watchers, dream-job trackers, tools that find customers first, scraping or updating a dashboard, and automatic coding.

## Loop engineering at a glance

Loop engineering is how to get an agent to work continuously (including 24/7 coding) and escalate to a human if needed, if a stop condition is met, or to run until a human comes in to stop it.

There are two common **forms**:

| Form | What wakes the next tick |
|------|--------------------------|
| **Scheduled job loops** | A clock (`every hour`, `/loop 2m`, cron). See [Scheduled job loops](#scheduled-job-loops). |
| **Event / work loops** | A unit of work finishing, or an event (git ref, log line, file change). Most of this note is this form, on a coding agent. |

And two common **uses**: scraping or updating a dashboard, and automatic coding.

Necessary instruction: **perform automatic verification**. Only stop the loop if automatic verification fails, or human verification is absolutely required.

Related: prevent wasting tokens when a model is shortsighted on an implementation or error. Tell it that if it fails to fix an error in **ten rounds**, including a fix that causes another error, it must stop and hand off.

A good loop prompt leverages **self-learning / self-healing** skills. When a skill fails, the agent takes guesses at what might work, then updates the skill once it is working — or branches to another skill variation if that is more appropriate.

Have it make **commits at major points** (let it judge those points, or state a preference). If the loop broke something, you can check out a previous commit or ask the agent to compare against older commits.

The agent learns how to loop dynamically to complete goals continuously.

## What every loop needs

- **A task or goal** with a concrete “done” state.
- **Skills it will use** — you can ask the agent to design them into local `.agents/skills/`.
- **Stopping points** — for example: error 10 times in a row and cannot fix; automatic verification after an implementation required human review because it failed.
- **What a tick is** — time or work (a feature implemented, a milestone, or X minutes). You can ask the agent to figure out the tick.
- **How to invoke it** — `/loop` plus a thin pointer that says to run the loop file exactly.

## Two layers

| Layer | Cadence | Who stops it |
|-------|---------|--------------|
| **Outer loop** (`/loop`) | Infinite by default. Each tick is a time interval **or** a unit of work. | The human, or a stop condition in the prompt. |
| **Inner loop** (error-fix episode) | Bounded. Same failing check, minimal patch, re-run. | Exhausted round budget, or the check passes. |

Keep these separate. The outer loop should not burn its time on unbounded retries. The inner loop should not start a new feature.

You *can* set outer limits (5 milestones, 20 iterations). If you intend to run to the end of a plan, see [Caveats](#caveats).

## File vs a quick `/loop` line

A quick-and-dirty way is `/loop` followed by the task, tick definition, and stop conditions in the chat message. That is rarely precise enough compared to a **loop `.md` file** the agent can re-read every tick and **self-heal / improve**.

**Self-heal:** an autonomous closed-loop capability: detect errors, diagnose root causes, and apply fixes without human intervention. It relies on observation, automated retraining or code patching, and verification.

Keep the `/loop` line short enough to reuse every tick. If the prompt is huge, save it as a `.agents/skills/` skill **or** an `AGENTS_LOOP-….md` file and loop a thin pointer.

```text
/loop Read and follow LOOP_PROMPT.md. Execute one tick, then keep looping until a STOP condition in that file fires.
```

`/loop` does **not** auto-discover a prompt file. The chat message must tell the agent to read that file **every tick** and follow it exactly.

Paste-the-whole-prompt also works. A file is better: same instructions every tick, easy to revise, and the agent can improve the file itself.

## How `/loop` runs

Cursor accepts `/loop [interval] <prompt>`.

### Dynamic mode (default for real work)

No interval. The agent runs the prompt **now**, then self-paces the next wake so the next tick starts as soon as the current one is worth continuing.

```text
/loop Read and follow LOOP_PROMPT.md. Execute one tick, then keep looping until a STOP condition in that file fires.
```

Dynamic mode is the right choice for backlog draining, QA, and “continue until done.” A fixed `5m` wait between ticks wastes time when the next slice is already ready.

**Dynamic ticks vs a blanket timer:** the default instinct is to analyze the backlog and pick a worst-case duration (a feature takes X minutes), then sleep the remainder of X after each tick. Dynamic pacing instead lets the agent sleep **case by case** — wake when the milestone/slice is done — rather than using the same duration for every tick.

### Fixed interval (polling and scheduled jobs)

```text
/loop 5m check deploy status
/loop 30s tail the error log
/loop 2m Continue using LOOP_PROMPT.md (commit+push YES; infinite; 10-round error stop).
```

Use a clock when the work is waiting on an external event (deploy, CI, a log line) or is a recurring job. Intervals look like `30s`, `5m`, `2h`, `1d`.

### What the agent does on start

1. Run the prompt immediately once.
2. Confirm the schedule (dynamic vs fixed).
3. Arm a wake for the next tick.
4. On each wake: read the prompt again, do one tick, continue or stop.

## Method: implied ticks and stops

You do not always specify the tick and stops yourself. Meta-prompt the agent to **create a loop-prompt `.md` and run it**, and let it infer:

- the tick (time or unit of work)
- the stop (often implied by the goal: when the work is gone, stop)

Example meta-prompt:

```text
Create a loop prompt md that will run Higgsfield MCP in order to fill all the
placeholders. Recall that image and video placeholders have html attributes that
store the prompt to generate that image or video. It also contains html
attribute that mentions whether it's an image or video. Once the asset is
generated, download locally and swap out the image placeholder, so can be shown
in the interface. Run the loop
```

Here the stop is implied: all placeholders swapped out. Tick can be “one placeholder” or whatever the agent chooses. Then leave the session minimized and check in occasionally.

That run started adding images and videos into a hospital game without further prompting, because a loop was already connected to Higgsfield MCP. The same pattern can add media into other apps with consistent style (with some AI slop — for example a patient shown awake during a code). Review later.

## Method: drain the loop

Looping is still new enough that an agent may pause and ask whether to continue. Reply **drain the loop**: keep looping for sure until a stop condition hits.

What that looks like in practice:

- 24/7 implementing the next item until automatic verification fails or human verification is absolutely required.
- It may **skip commits** even if the prompt said to commit. Watch for that; state commit preference in the loop file and in the `/loop` line.
- The next tick starts when the unit of work is done (a feature or milestone), not on a timer.
- It finishes with `STOP_DONE` when the backlog is drained.

If it stops at `STOP_HUMAN`, you can defer that gate and tell it to drain the rest. Do not claim the deferred item passed.

## Anatomy of a loop prompt

Avoid conversational wording. Structure the file as an automated loop specification. Fill every section with **observable** language.

```markdown
# OBJECTIVE
[What “done” looks like. One concrete end state, e.g. green CI, every placeholder swapped.]

# CONTEXT
[Sources of truth, branch, recent logs, error files, state file, boundaries.]
[Commit / push policy — YES/NO for each, not implied.]
[Outer loop: infinite unless a STOP below fires.]

# STEP-BY-STEP CADENCE (one tick)
1. Orient from persisted state.
2. Classify the current item: AUTO vs HUMAN_REQUIRED.
3. Act on one scoped slice (or verify it).
4. Verify with the smallest decisive check, then broaden.
5. Persist state. If STOP did not fire, continue immediately.

# ERROR-FIX EPISODE (inner loop, max N rounds)
When an AUTO check fails:
1. Capture the failing command and essential output.
2. Identify the cause from that evidence.
3. Apply a minimal patch.
4. Re-run the same failing check.
5. Log: round #, symptom, change, new result.

New errors after a fix still count toward the same N-round budget.

# VERIFICATION RUBRIC
- Advance only when remaining items are AUTO and those checks pass.
- Return PASS only if the named checks yield zero errors (or the equivalent).
- Return a tick status (see Stop statuses).

# STOP CONDITIONS / ESCAPE HATCHES
1. Human interrupt.
2. Human gate (HUMAN_REQUIRED).
3. Error budget exhausted — emit a handoff, then stop mutating.
4. Safety aborts (deps, secrets, destructive actions, irreconcilable docs).
5. Optional outer cap: 5 passes / 20 iterations / 5 milestones — if you set one.

# ANTI-PATTERNS
- Do not idle waiting for “continue” when AUTO can proceed.
- Do not expand into later items.
- Do not burn the error budget on unrelated refactors.
```

### Objective

Write a **done** state a later tick can test, not a vibe.

- Good: “Every item in the backlog has evidence-backed QA, all automatable checks pass, and no unresolved human gate remains.”
- Bad: “Make the project better.”

### Context

Name the files the agent must re-read every tick: state, maps, stories, logs. State **commit and push** rules here. If commits are allowed, say so explicitly. If they are not, say so. Do not leave it implied.

Depending on preference: make git commits whenever meaningful implementations are done, **or** suggest a commit message without committing so a human can commit between ticks.

Do not let cleaning up Git (messy history, oversized commits, renaming, squashing, rebasing) delay completing the current item.

### One tick

A tick is one coherent unit: one slice implemented, one feature, one milestone, one criterion tested, or one defect repaired — **or** one interval on a clock. Not “keep going until the whole backlog is empty” inside a single turn.

Typical work tick:

1. **Orient** — read persisted state first, then only the files it points at.
2. **Classify** — `AUTO` if a command, contract, or browser assertion can prove it; `HUMAN_REQUIRED` only when credentials, paid side effects, production mutations, or subjective judgment cannot be automated.
3. **Act** — implement or test that one item. Prefer automating a “human verify” UI step (browser DOM/text/network) before classifying it as human-only.
4. **Verify** — smallest check first, then broader. A backend pass is not proof of a frontend criterion.
5. **Persist** — write progress so the next tick resumes, it does not restart.
6. **Report** — short: item, what changed, AUTO result, next slice or stop status.

### AUTO vs HUMAN_REQUIRED

| Class | Meaning |
|-------|---------|
| `AUTO` | Provable without human judgment: tests, lint, typecheck, build, scripts, API contracts, browser assertions. |
| `HUMAN_REQUIRED` | Needs unavailable credentials, paid or irreversible external effects, production-only access, or subjective judgment. |
| `CONTRADICTED` | Documents and checked-out behavior disagree. |

The loop keeps going while work is `AUTO`. It stops and names the exact human action when a gate is `HUMAN_REQUIRED`.

A human can later say “defer that gate and continue” / **drain the loop**. The loop should keep the deferred item marked incomplete and move to the next automatable item. Do not claim the deferred item passed.

## Designing a loop file (meta-prompt)

Requirement: a tracker for where you are and what is next (a milestone system, a placeholder list, a QA matrix — some source of truth).

Place your **commit/push preference** in the meta-prompt. Then ask the agent to design the loop file from the skeleton, save it, and recommend how to run it.

```text
Design a loop prompt that will run these epics and milestones. Here are the
basics of a loop prompt:

**PREFERENCES**
Should we commit and push automatically - YES to both

"""
# OBJECTIVE: [Define concrete "Done" state, e.g., Green CI pipeline]
# CONTEXT: [Target branch, recent logs, error files]

# STEP-BY-STEP CADENCE:
1. Run local test suite using `npm test`.
2. If tests fail, read errors from stderr.
3. Modify codebase to patch errors using minimal changes.
4. Re-run tests.

# VERIFICATION RUBRIC:
- Return PASS only if `npm test` yields zero errors.

# STOP CONDITIONS / ESCAPE HATCHES:
- Maximum iterations: 5 passes.
- Abort immediately if unexpected third-party dependencies are altered.
"""

And keep in mind we have a Milestone system that tracks where we are and what
we're doing next.

If we were to continuously loop to `continue` on the milestones and passing
automatic verification, we should be able to reach the end of all the milestones.

We only stop if an automatic verification fails or human verification is
absolutely required.

As for the stop conditions, for our maximum iterations: Infinite. I'll stop the
AI process when I want to.

But an important stop condition:
If you fail to fix an error in ten rounds including new errors that appear after
fixing one error, you will also stop, making a summary of the error fixing
attempts so that the human can take over debugging.

If it is efficient because of repeating the same tasks, you may create new
skills locally under .agents/skills/* . These skills may be self learning /
self healing. When a skill fails, you may take guesses at what might work, then
update the skill once it’s working. If a skill is adapted for another purpose,
you can create another skill entirely.

Lets save as "AGENTS_LOOP-Continue-Milestone.md" and recommend how to run this
loop prompt
```

Save the prompt it recommends. Then invoke with a thin pointer (dynamic unless you chose a clock):

```text
/loop Read and follow AGENTS_LOOP-Continue-Milestone.md. Execute one tick, then keep looping until a STOP condition in that file fires.
```

With a timer, if you prefer:

```text
/loop 2m Continue using AGENTS_LOOP-Continue-Milestone.md (commit+push YES; infinite; 10-round error stop).
```

## Stop statuses

Return one status at the end of every tick.

| Status | Meaning |
|--------|---------|
| `PASS_CONTINUE` | Evidence-backed progress. Arm the next wake. |
| `STOP_DONE` | The objective’s done state is true (backlog drained, all placeholders swapped, every milestone QA-passed). Do not arm another wake. |
| `STOP_HUMAN` | A human-only gate remains (`HUMAN_REQUIRED` or `blocked_waiting_user`). State the exact action, location, and expected result. |
| `STOP_ERROR_BUDGET` | Inner-loop rounds exhausted. Emit the handoff below. Stop mutating. |
| `STOP_CONTRADICTION` | Docs and checked-out behavior disagree with no safe resolution. |
| `STOP_WORKTREE_CONFLICT` | Required edits overlap pre-existing uncommitted work that cannot be separated. |

Add statuses that match the job. Keep them machine-readable so a later tick (or a human) can act without rereading the whole session.

### Error-fix handoff (`STOP_ERROR_BUDGET`)

After **N** unsuccessful rounds on the **same** episode (including regressions that appear after a “fix”):

- Item / step
- Failing command(s)
- Timeline of rounds 1–N (symptom → change → result)
- Current best hypothesis
- Exact files touched
- Smallest next experiment for a human
- Do not keep mutating code after this stop

A typical inner budget is **10** rounds. The outer loop stays infinite; the human stops the process when they want.

### Safety aborts (immediate `STOP_HUMAN`)

Stop rather than “make it pass” when the agent would need to:

- Alter unexpected third-party / vendor lockfiles or unrelated dependencies
- Use production secrets, paid side effects, or destructive production actions
- Resolve a contradiction between docs and code with no safe choice

## Persist state between ticks

Each tick must leave enough state that a **new** wake can resume without the previous turn’s memory.

Persist at least:

- Current item
- Criteria already evaluated, with evidence
- Open defects or human gates
- Commit hashes created by this loop (if commits are allowed)
- Next item

Preserve existing state fields. Do not treat a “complete” label as QA evidence. Re-derive the backlog from source documents each run when the job is verification. Do not mark an item QA-passed until every acceptance criterion has evidence.

## Tick report

Keep it short. Long narrative wastes the next wake’s context.

```text
- Item: …
- Evidence: … (command or workflow + result)
- Repair: … (or none)
- Commit: … (or none)
- Next: …
- Status: PASS_CONTINUE | STOP_HUMAN | STOP_DONE | …
```

## Repeating procedures → skills

If the same procedure repeats across **two or more** ticks, write or update a local skill under `.agents/skills/<name>/SKILL.md` for that procedure: verify suites, milestone advance, common fix patterns, browser smoke paths.

**Self-learning / self-healing:** on failure, try a bounded alternate approach, then rewrite the skill once a working path is found. If a skill is reused for a different purpose, create a new skill instead of overloading the old one.

You can ask the agent, in the meta-prompt, to design the skills it will need into `.agents/skills/` up front.

## Starting, continuing, stopping

**Start**

```text
/loop Read and follow LOOP_PROMPT.md. Execute one tick, then keep looping until a STOP condition in that file fires.
```

On start, the agent should confirm: dynamic vs fixed, that the first tick already ran, when the next wake is, and that it will keep firing until stopped.

**If it asks instead of looping**

Reply **drain the loop**.

**Continue after a human gate** (optional)

Tell the agent to preserve the deferred `HUMAN_REQUIRED` item, not claim it passed, and take the next automatable item.

**Stop**

Say `stop the loop`. The agent should kill any sleeper/watcher process and **not** arm another wake. Interrupting the session also stops it.

**When to abort**

Abort when another tick message shows, or when automatic verification tests have finished. If you abort earlier, **keep the chat thread** (do not erase the history) so next time you can ask it to resume. That lowers the chance of leaving the tree half-applied.

## Choosing a schedule

| Job | Mode |
|-----|------|
| Drain a backlog, implement next slice, QA next criterion | Dynamic (no interval) |
| Poll deploy / CI / logs | Fixed (`30s`, `5m`, …) |
| Recurring world update (standings, scrape, dashboard) | Fixed / cron (see [Scheduled job loops](#scheduled-job-loops)) |
| Wait for a git ref, log line, or file change | Dynamic, with an event watcher as the primary wake and a long heartbeat as fallback |

Do not run two loops for the same purpose. Do not put noisy commands inside the wake shell.

## Caveats

- **Heat and runtime.** An infinite loop aimed at a full plan can heat a machine quickly if it cannot handle the load. You can set limits (5 milestones, 20 iterations) if you do not intend to run to the end.
- **Abort timing.** Stop on a tick boundary or after verification, not mid-patch. Keep the thread if you abort early so you can resume.
- **Token use.** It will burn through tokens. Watch usage.
- **Commits may be skipped.** Even with “commit YES,” loops have skipped commits along the way. Check git history; put the preference in both the file and the `/loop` line.
- **Quality.** Unattended generation (images, video, large coding sweeps) can be sloppy. Check in occasionally.

## Git and GitHub use cases

In Git workflows, loop prompts (agent loop engineering) are a shift from manual, one-off prompts to automated, self-correcting execution. Instead of instructing an agent task-by-task, a loop prompt feeds a continuous script or objective contract that runs until a defined stop condition or verification metric is met.

Instead of babysitting:

- **CI/CD repair** — monitor failing Actions, read the error log, modify code, commit, and push until tests pass.
- **PR babysitting** — loop through review feedback, rewrite, and push fixes.
- **Dependency triage** — check vulnerability alerts, generate fixes, run local tests, open clean PRs.
- **Flaky-test hunting** — run a suite in a continuous loop (`while :; do …`) to isolate intermittent failures, debug, and submit corrections.

Native terminal pattern (“Ralph loop”): `while :; do cat PROMPT.md | agent; done`.

### Libraries and tools

- [invincible04/awesome-loop-engineering](https://github.com/invincible04/awesome-loop-engineering) — curated copy-pasteable loop prompts and patterns, including Ralph loops and Claude Code `/goal` or `/loop` scripts.
- [byigitt/pi-loop-designer](https://github.com/byigitt/pi-loop-designer) — blueprint: objective, state/memory model, iteration criteria, validation checks, absolute stop rules.
- [SeanZoR/ralph-pilot](https://github.com/SeanZoR/ralph-pilot) — wrapper for formatting loop prompts with completion criteria, self-correction, timeouts, and escape hatches.
- [feiskyer/koder](https://github.com/feiskyer/koder) — terminal coding assistant with local cron-backed loops over repositories.

## Scheduled job loops

Clock-woken, not backlog-woken. Example prompt:

```text
Set up a scheduled task that checks the world cup standing every hour, can you
make sure to update the site based on the standing?
```

Same anatomy (objective, cadence, verification, stops), different tick: **time**.

Some descriptions of loop engineering use **two agents** — one does the work, the other grades it — and they keep fixing output until they hit your goal. Cursor `/loop` is usually one agent re-reading the same file; you can still put a grade/verify step in the cadence.

## Other domains

**Media / MCP.** Meta-prompt a loop that generates from placeholders (prompt + image-or-video attributes), downloads locally, and swaps the placeholder. Stop when none remain. See [Method: implied ticks and stops](#method-implied-ticks-and-stops).

**Games.** Loop prompting can drive game-dev skills. Starting points: [game-development skills](https://github.com/sickn33/agentic-awesome-skills/tree/main/skills/game-development) and gist loop-prompt libraries.

## What you still design

The loop can code continuously. What stays human is designing **standards, systems, and prompts** ahead of time so the agent does not go off the rails — or using a milestone/tracker system as that context.

After a large implementation pass, switch to a higher-reasoning pass and **QA every item**, then (optionally) QA **user flows**. If completeness checks still find gaps, design the next milestone set and loop to cover them.

## Worked example: continue a milestone backlog

Run from the repository root. The original pass used Grok 4.5 on Max Mode in Cursor.

**Preferences:** commit and push automatically — YES to both (change this if yours differ). Dynamic mode (no interval) fits best; kill the process when you want. Fixed `5m` intervals waste time between auto-capable steps.

If you want this saved as a skill (for example `.agents/skills/milestone-continue-loop/SKILL.md`) and optionally a one-line pointer from `AGENTS.md`, say so when you meta-prompt.

How this interacts with current state: if a milestone such as M4.21 is `verification_ready` with UI “(human verify)” items, the loop should try browser automation for those UI assertions (for example Why tags on run detail / scheduler) first; it only stops if those cannot be asserted automatically.

```markdown
# OBJECTIVE
Drain the milestone backlog to completion by repeatedly executing the repo’s
“continue” cadence (AGENTS.md + AGENTS-MILESTONES_TURNS.md +
AGENTS-CODE_REFERENCE_TURNS.md).

Depending on preference for committing: Make git commits whenever meaningful
implementations are done OR suggest a commit message without committing and
just continue on because user can make commit between ticks.

**Done** = `.agents/state.json` shows every milestone in the execution sequence
completed (or no further `in_progress` / `verification_ready` work remains),
OR a hard STOP condition below fires.

# CONTEXT
- Source of truth: `.agents/state.json`, `EPIC_MAP.md`, `IMPLEMENTATION_STORIES.md`
- Code maps first: `AGENTS_CODE_REFERENCE.md` (+ linked `AGENTS_CODE_REFERENCE-*.md`)
- Local skills (create/adapt as needed): `.agents/skills/*`
- Commit or push: Suggest a commit message without committing OR make a commit,
  based on our preference for committing
- Outer loop iterations: **infinite** (human stops the process).

# STEP-BY-STEP CADENCE (one tick)

1. **Orient**
   - Read `.agents/state.json`.
   - Read maps, then only the source files they point to.
   - Identify `current_milestone_id`, `status`, and the next unfinished story/checklist item.

2. **Classify the gate** for the current milestone checklist item:
   - `AUTO` — runnable locally/CI/browser without judgment:
     tests, lint, typecheck, build, script smoke, API contract checks,
     browser DOM/text/network assertions.
   - `HUMAN_REQUIRED` — only if auto means cannot prove correctness:
     live secrets/env, paid third-party side effects, irreversible prod actions,
     subjective product/UX judgment that automation cannot assert,
     or explicit `blocked_waiting_user` decisions.
   - Prefer automating “human verify” UI items via browser tools before classifying
     them as `HUMAN_REQUIRED`.

3. **Act by status**
   - `in_progress` → implement the next scoped slice; minimal diffs; follow repo patterns.
   - `verification_ready` → run all `AUTO` checks; if they pass and no
     `HUMAN_REQUIRED` remains, mark milestone complete, advance to next,
     update `EPIC_MAP.md` / `IMPLEMENTATION_STORIES.md` / `.agents/state.json`.
   - `complete` → advance to next milestone; set `in_progress`.
   - `blocked_waiting_user` → STOP (human gate).

4. **Verify every code change** (smallest → broader):
   targeted test → lint → typecheck → build → browser/UI automation as needed.
   Treat verification failure as an **error-fix episode** (see below).

5. **Skills (efficiency / self-heal)**
   - If the same procedure repeats ≥2 ticks, create or update a skill under
     `.agents/skills/<name>/SKILL.md`.
   - Skills may be self-learning: on failure, try a bounded alternate approach,
     then rewrite the skill once a working path is found.
   - If a skill is reused for a different purpose, create a new skill instead of
     overloading the old one.
   - Prefer skills for: verify suites, milestone advance, common fix patterns,
     browser smoke paths.

6. **Commit check**
   - Only if user preference is to commit.
   - At a good commit point: refresh LLM maps if architecture/contracts/flows changed
   - Do not let cleaning up Git commits delay completing the milestone. The agent
     should not stop feature work just because commits are messy, too large,
     poorly named, or need squashing/rebasing.

7. **End of tick**
   - Persist state.
   - If STOP did not fire: immediately continue to the next milestone slice
     (no waiting for user “continue”).
   - Keep the tick report short: milestone, what changed, AUTO result, next slice.

# ERROR-FIX EPISODE (inner loop, max 10 rounds)

Start an episode when any AUTO verification fails, or a new failure appears
after a fix.

Each round:
1. Capture failing command + stderr/stdout essentials.
2. Hypothesize root cause from evidence (no speculative dependency churn).
3. Apply a **minimal** patch.
4. Re-run the same failing check (then broader checks if it passes).
5. Log: round #, symptom, change made, new result.

**New errors after a fix still count toward the same 10-round budget.**

# VERIFICATION RUBRIC
- Milestone may auto-advance only if every remaining checklist item is `AUTO`
  and all `AUTO` checks pass.
- Return tick status:
  - `PASS_CONTINUE` — advanced or made verified progress; keep looping
  - `STOP_HUMAN` — `HUMAN_REQUIRED` or `blocked_waiting_user`
  - `STOP_ERROR_BUDGET` — 10-round fix episode exhausted
  - `STOP_DONE` — backlog drained

# STOP CONDITIONS / ESCAPE HATCHES
1. **Human stop** — user interrupts the process (outer loop is infinite otherwise).
2. **Human gate** — `HUMAN_REQUIRED` or `blocked_waiting_user`. Present a precise
   checklist (route/control/expected result) and stop.
3. **Error budget** — after **10** unsuccessful fix rounds on the same episode
   (including regressions/new errors), STOP and emit:

   ## Error-fix handoff
   - Milestone / step
   - Failing command(s)
   - Timeline of rounds 1–10 (symptom → change → result)
   - Current best hypothesis
   - Exact files touched
   - Smallest next experiment for a human
   - Do not keep mutating code after this STOP

4. **Safety aborts (immediate STOP_HUMAN with reason)**
   - Need to alter unexpected third-party/vendor lockfiles or unrelated deps
     to “make it pass”
   - Need production secrets, paid side effects, or destructive prod actions
   - Milestone docs and code contracts contradict with no safe resolution

# ANTI-PATTERNS
- Do not idle waiting for a casual “continue” when AUTO can proceed.
- Do not treat every UI checklist as human-only; automate first.
- Do not skip map-first reading before edits.
- Do not expand scope into later milestones.
- Do not burn the 10-round budget on unrelated refactors.
```

## Worked example: QA every milestone

After implementation (for example on a higher-reasoning model such as GPT-5.6 Sol on Max in Cursor), derive a **second** loop from the continue file: QA every milestone, commit each meaningful QA unit, save as its own file.

```text
Read and follow AGENTS_LOOP-Continue-Milestone.md. Create a loop prompt from it
whose purpose is QA for every milestone. Have it make a git commit for each
meaningful QA. Save this as a separate prompt file that I will refer to for a
future loop prompt.
```

Then:

```text
/loop Read and follow AGENTS_LOOP-QA-Milestones.md
```

Full prompt file:

```markdown
# Milestone-by-Milestone QA Loop Prompt

Use this file as the prompt payload for a future dynamic `/loop`.

## Objective

QA every milestone in repository execution order. Test each milestone's acceptance
criteria against the checked-out product, repair defects within scope, and create
a git commit for each meaningful QA unit.

Done means every milestone has evidence-backed QA status, all automatable checks
pass, and no unresolved defect or human-only gate remains.

## Authority and boundaries

- This prompt explicitly authorizes git commits for scoped QA work.
- Do not push.
- Never commit unrelated or pre-existing work.
- A meaningful QA unit is one coherent defect fix, regression-test addition, or
  acceptance-criteria correction with passing evidence.
- A passing QA run that changes no tracked files does not need an empty commit.
- Keep milestone scope isolated. Do not fold later milestone work or opportunistic
  refactors into the current QA commit.
- Preserve the `flexagents/` and `ctrl-openclaw-agent-pack/` repository boundaries.
  Commit in the repository that owns the changed files. If the root repository
  tracks a resulting submodule pointer, commit that pointer separately only when
  it is part of the completed QA unit.

## Sources of truth

Read these before source:

1. `AGENTS.md`
2. `.agents/state.json`
3. `EPIC_MAP.md`
4. `IMPLEMENTATION_STORIES.md`
5. `AGENTS_CODE_REFERENCE.md` and applicable companion maps
6. The current milestone's code, tests, contracts, and user-visible workflow

Derive the complete milestone list and execution order from the documents on each
run. Include milestones already marked complete: status is not QA evidence.

## Persistent loop progress

Use `.agents/state.json` to persist:

- the milestone currently under QA
- acceptance criteria already evaluated
- commands and workflow evidence
- open defects or human gates
- commit hashes created by this QA loop
- the next milestone

Preserve existing state fields. Do not mark a milestone QA-passed until every
acceptance criterion has evidence.

## One loop tick

### 1. Establish repository safety

- Inspect git status in the root and relevant nested repositories.
- Record pre-existing modified, staged, and untracked paths.
- Exclude those paths from all staging and commits.
- If QA requires editing a path with pre-existing work and the edits cannot be
  separated safely, return `STOP_WORKTREE_CONFLICT` with the exact path.
- Inspect recent commit messages and follow the repository's commit style.

### 2. Select the QA target

- Resume the persisted milestone and criterion when present.
- Otherwise select the earliest milestone without QA-passed evidence.
- Read its stories, tasks, acceptance criteria, tests, stable interfaces, and
  applicable code maps.
- Trace each criterion to concrete code and a runnable product workflow.

### 3. Build an evidence matrix

Classify every acceptance criterion:

- `AUTO`: provable with tests, lint, type checks, build, contracts, scripts, API
  requests, database assertions, or browser automation.
- `HUMAN_REQUIRED`: requires unavailable credentials, paid or irreversible
  external effects, production-only access, or subjective judgment that cannot be
  asserted automatically.
- `CONTRADICTED`: milestone documents and checked-out behavior disagree.

Use the smallest decisive test for each criterion, but test the complete workflow
when the criterion spans multiple components. Backend-only success is not proof of
a frontend or end-to-end criterion.

### 4. Execute QA

- Run existing targeted tests before broader suites.
- Exercise success, failure, authorization, boundary, and regression paths that
  are material to the criterion.
- For UI criteria, use browser automation and inspect visible state plus relevant
  network behavior.
- Use the running server when available. Before any server configuration change,
  ask: `Is your current server working?` Do not change server type or configuration
  without explicit user direction.
- Avoid real sends, paid calls, destructive actions, or production mutations.
- Do not claim a criterion passed without captured command or workflow evidence.

### 5. Repair a failed criterion

Treat each failure as one error-fix episode with a maximum of 10 rounds:

1. Capture the failing command or workflow and essential output.
2. Identify the cause from evidence.
3. Apply the smallest milestone-scoped repair.
4. Add or strengthen a regression test when practical.
5. Re-run the exact failing scenario.
6. Run the broader relevant quality gate.

New failures caused by a repair count toward the same 10-round budget. Do not
perform unrelated dependency churn or broad refactors to obtain a pass.

### 6. Commit each meaningful QA unit

When one coherent QA unit is complete and its relevant tests pass:

1. Review root and owning-repository status and diffs.
2. Refresh applicable `AGENTS_CODE_REFERENCE*.md` files only when the repaired
   architecture, contract, or primary flow materially differs from the maps.
3. Stage only files belonging to this QA unit, using explicit paths.
4. Re-check the staged diff for unrelated or secret-bearing files.
5. Commit with the repository's message style and a milestone-scoped message,
   such as `fix(M4.7): preserve scheduled ledger email gating` or
   `test(M6.2): cover hosted-provider fallback`.
6. Run git status and record the commit hash in `.agents/state.json`.

If a hook changes files, review those edits and include them only when they belong
to the same QA unit. Never bypass hooks. Never amend a rejected commit. Do not
create an empty commit for evidence-only passes.

### 7. Close or continue the milestone

- Mark a criterion QA-passed only with evidence.
- Mark a milestone QA-passed only when all criteria pass.
- Persist the next unfinished criterion or milestone.
- Continue immediately while automatable work remains.

Keep tick output concise:

- milestone and criterion
- evidence run and result
- defect and repair, if any
- commit hash, if created
- next QA target or stop status

## Stop statuses

- `PASS_CONTINUE`: evidence-backed progress; continue the loop.
- `STOP_HUMAN`: a human-only gate remains. State the exact action, location, and
  expected result.
- `STOP_WORKTREE_CONFLICT`: required files overlap pre-existing work.
- `STOP_CONTRADICTION`: milestone contracts conflict and no safe resolution is
  evidenced.
- `STOP_ERROR_BUDGET`: 10 repair rounds were exhausted. Report the failing
  scenario, round-by-round evidence, touched files, and smallest next experiment.
- `STOP_DONE`: every milestone has evidence-backed QA completion.

## Anti-patterns

- Do not trust completion labels without testing.
- Do not skip acceptance criteria because a broad suite passes.
- Do not stage with `git add .` or otherwise capture unrelated work.
- Do not combine multiple unrelated defects in one commit.
- Do not push, force-push, rewrite history, bypass hooks, or use destructive git
  commands.
- Do not keep mutating files after a stop status.
```

That loop is meant to leave **meaningful QA commits** (one coherent unit each), not empty evidence-only commits.

## Worked example: user-flow QA

Another QA shape:

1. Create learning goals and user flows (for example: user clicks X tab, then clicks Start under Y tile…) to achieve those learning goals. If parts of the app must be redone, implement them. Save to `QA_User_Flows.md`.
2. Create a loop prompt `AGENTS_LOOP_QA_User_Flows.md` that QAs those existing user flows.
3. Suggest a `/loop` line that runs that file.

Example commit from that flow:

```text
[main d4a477d] Loop AI Systems: User flow QA
 4 files changed, 487 insertions(+), 4 deletions(-)
 create mode 100644 AGENTS_LOOP_QA_User_Flows.md
 create mode 100644 QA_User_Flows.md
```

**Completeness:** after the flows exist, check for gaps (for example: any gaps in learning the markets and their trades and patterns?). If there are gaps, design a milestone set and loop to cover them.

## Resources

- Video: [Learning loop engineering](https://www.youtube.com/watch?v=4biXYSNkn9Y)
- Video: [Matthew’s Loop Library](https://www.youtube.com/watch?v=9QaD8Avfu2Q)
- Human-in-the-loop in loop engineering: [LinkedIn post (omarsar)](https://www.linkedin.com/posts/omarsar_loop-engineering-is-great-until-something-activity-7480273140250558464-Jy8J/)

## Anti-patterns

- Waiting for the user to type “continue” when AUTO work remains (say **drain the loop** instead)
- Treating every UI checklist as human-only without trying browser automation
- Skipping the prompt file on later ticks (`/loop` must re-read it)
- Using only a chat-line `/loop` when the job needs a file the agent can improve
- Expanding into later items in the same tick
- Combining unrelated defects in one commit (when commits are allowed)
- Empty commits for evidence-only passes
- Pushing unless the prompt explicitly allows it
- Staging with a blanket add that captures unrelated work
- Burning the inner error budget on refactors or dependency churn
- Mutating files after a stop status
- Letting Git cleanup delay the current item
- Erasing the chat after an early abort, then being unable to resume
- Skipping map-first reading before edits
- Trusting completion labels without testing
- Skipping acceptance criteria because a broad suite passed
