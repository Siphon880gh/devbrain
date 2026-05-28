## Service layer — code-structure skill (Michael Shimeles)

- Skill source: https://github.com/michaelshimeles/skills/blob/main/code-structure/SKILL.md  
- Author: [Michael Shimeles](https://github.com/michaelshimeles)

An **agent skill** that steers how the AI **writes and extends your application code**: actions own domain rules; a **service layer** owns shared operational mechanics so the model does not recreate the same helpers on every new feature nor bloat the codebase context.

---

## The problem it solves

When an AI adds features over many sessions, it often:

- Creates **another helper** that does the same thing as an existing one (sandbox setup, email send, Stripe call, health check).
- Puts **operational “how”** mixed into **domain “why/when”** in action/route handlers.
- Fixes a bug in one workflow but **misses the copy-paste** of the same logic elsewhere.

That makes the repo harder for the **next** prompt: the model greps, sees three similar functions, and picks the wrong pattern—or invents a fourth.

---

## What the skill enforces: actions + service layer

| Layer | Role | AI should put here |
| --- | --- | --- |
| **Actions** (or routes/handlers) | Domain orchestration — auth, policy, status transitions, *when* something runs | Business rules for *this* feature |
| **Service layer** | Shared **operational mechanics** — SDK calls, retries, sandbox creation, parsing | Anything **2+ features** need the same way |

**One sentence from the skill:** Actions orchestrate domain rules; the service layer centralizes reusable operational mechanics.

### Why a service layer helps the AI

1. **One place for repeated “how”** — New features call `createSandbox()` or `sendTransactionalEmail()` instead of re-implementing inline.
2. **Less duplicate code** — The skill tells the agent to extract when the same operational block appears across callers.
3. **Clearer feature prompts** — “Add checkout” → action handles policy; service already owns payment client + error shape.
4. **Easier navigation** — Grep finds **one** implementation; the model is less confused about which file to edit.

---

## Rules the skill pushes

- **Explicit parameters in, structured results out** — no hidden globals or reaching into DB from deep helpers.
- **Extract only when repeated** — used in 2+ callers; avoid over-abstracting one-off logic.
- **Keep domain logic in actions** — auth, classification, “what state means” stays out of generic services.
- **Workflow:** write the flow in the action first → spot repeated chunks → extract to service → replace callers one by one → typecheck/lint.

---

## Install the skill

### Option A — `npx skills` (recommended)

From any terminal (see [[Recommended Setup on Mac - Npx skills]]):

```bash
npx skills add michaelshimeles/skills
```

In the wizard:

- Select agent(s) if prompted (Cursor reads universal `~/.agents/skills` either way).
- Use space to select **`code-structure`** only, or install the whole repo if you want other skills from that author.

Installed path:

```text
~/.agents/skills/code-structure/SKILL.md
```

### Option B — Manual copy

```bash
mkdir -p ~/.agents/skills/code-structure
curl -o ~/.agents/skills/code-structure/SKILL.md \
  https://raw.githubusercontent.com/michaelshimeles/skills/main/code-structure/SKILL.md
```

Useful alias: [[Recommended Setup on Mac - Cursor Skills Cd]] (`cdskills` → `~/.agents/skills`).

Restart Cursor (or start a **new agent chat**) after install so skill discovery picks up the new folder.

---

## How to invoke

This skill has **no** dedicated slash command in its `SKILL.md` (unlike `/greploop`). Cursor loads it from `~/.agents/skills` and applies it when the task matches the skill **description** or when you **name it explicitly**.

### 1. Explicit prompt (most reliable)

Start the task by naming the skill:

```text
Use the code-structure skill. Add [feature]. Put domain rules in actions;
reuse or extend the service layer for shared mechanics. Do not duplicate helpers
that already exist—grep for similar operations first.
```

### 2. Natural-language triggers (auto-discovery)

The skill’s description is written to match prompts like:

- “We have the same sandbox setup copy-pasted in three action files—refactor.”
- “What belongs in actions vs shared services for this flow?”
- “Add a new feature that uses the same payment/email/sandbox mechanics as X.”
- “Extract repeated operational logic into a service layer.”

If the agent ignores the pattern, fall back to **explicit prompt (1)**.

### 3. New Cursor chat after install

Skills are discovered at session start. If behavior does not change:

1. Confirm `~/.agents/skills/code-structure/SKILL.md` exists.
2. Open a **new** Agent chat (not an old thread started before install).
3. Repeat the explicit prompt.

### 4. Project rules (optional, always-on)

For repos where every feature should follow this layout, add a short rule in `.cursor/rules` or `AGENTS.md`:

```text
Follow code-structure: actions = domain orchestration; services = shared
operational mechanics only. Grep before adding helpers. Extract to service
when 2+ callers share the same non-domain logic.
```

That complements the skill; it does not replace installing `SKILL.md`.

### 5. Verify the skill is visible

In chat, ask:

```text
List which agent skills you can see under code-structure or service layer.
```

Or inspect on disk:

```bash
ls ~/.agents/skills/code-structure/
cat ~/.agents/skills/code-structure/SKILL.md | head -20
```

---

## When to invoke

- Multiple workflows duplicate the same operational logic.
- Adding a feature that shares mechanics with an existing flow (payments, sandboxes, webhooks).
- Refactoring after copy-pasted blocks appear in several action files.
- Greptile or human review flags **duplicated helpers** → fix using this layout (see [[Greptile Code Review and greploop]]).

---

## How this pairs with other patterns

| Pattern | What it optimizes |
| --- | --- |
| [[Large Context in 2026 - Prefer Code at Hand Over Describing Libraries]] | Reading **external** libs and **your** repo accurately |
| [[_Context - Ever-updating High-Level Context that Optimizes Token Usage and Lowers Likelihood of Lines disappearing]] | **Where** things live in a large app |
| **Service layer / code-structure (this note)** | **How** new code is shaped so the AI does not duplicate helpers |

---

## Related

- [[Giving More Code Access to AI - Cursor, opensrc, and bash-tool]]
- [[File Architecture for SKILL.md]]
- [[NPX Skills CLI - PRIMER (Shortcut)]]
- [[Recommended Setup on Mac - Npx skills]]
