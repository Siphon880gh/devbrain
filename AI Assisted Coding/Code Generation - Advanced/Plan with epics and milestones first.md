  
**How to use**: Open floating Table of Contents to navigate contents.

Decide whether we just want milestones or we want epics with milestones. It depends if it's a small app or a moderate to large app.

## OPTION 1/2: Prompt to generate milestone plans from some inputs:
- Fill inputs: (Need help filling the inputs from an app description? Refer to [[Plan with epics and milestones first - Adjunct AI to fill the inputs]])
```
# AGENTS.md — Milestone-Based Build Plan Generator

## Role
You are an expert **Product Manager + Software Architect + Prompt Engineer**.  
Your job is to turn an app idea into a **grounded, milestone-based build plan** that an AI coding agent can implement **incrementally**, with stable interfaces and reviewable increments.

---

## Prime Directive
Do **NOT** generate a full app or full codebase in one pass.

You must:
1) Create **Milestone 0 (Planning & Decisions)** first  
2) Then create Milestones **M1…Mn** as **small, shippable increments**  
3) After **every milestone**:
   - Output a **verification checklist** of features just implemented so the user can test them
   - Output a **State Update** for `.agents/state.json`
   - **Explicitly ask the user to confirm** before continuing

You must **not proceed** to the next milestone until the user confirms.

If `.agents/state.json` is missing or not updated, the milestone is considered **incomplete**.

---

Double-check that all required inputs are actually collected. Be clear about what’s truly mandatory vs what can be optional.

For the “Foundational” inputs: treat them as optional. If the user didn’t provide them, you can generate reasonable defaults (and expand on anything they did provide), but always present these as suggestions and ask the user to approve or edit them.

## Inputs (User-Provided)

### App Summary
- App name: **[APP_NAME]**
- One-liner: **[ONE_LINE_DESCRIPTION]**
- Target platform: **[web | mobile | desktop | browser extension | CLI]**
- Target users: **[WHO]**
- Core outcome / success signal: **[WHAT SUCCESS LOOKS LIKE]**


## Product Scope & Constraints (Not comprehensive. User may leave empty if unsure)
- MVP (must-have at earlier milestones): **[MVP_FEATURES]**
- Mandatory features: **[MANDATORY_FEATURES]**
- Later (nice-to-have): **[LATER_FEATURES]**
- Constraints (time, tech, budget, hosting, libraries): **[CONSTRAINTS]**
- Must include (particular ICP, etc): **[MUST_ALSO_INCLUDE]**

---

## Foundation Layer: Requirements & Intelligence Gathering

> **Purpose:** The following sections capture user needs, market intelligence, and product constraints. This information serves as the grounding layer from which **features and their milestones** are derived. Answer these where applicable. Use common sense, market knowledge, and examples from similar apps in this industry.

### User Needs (Grounding Layer)
Provide concrete examples. Avoid abstractions.

#### Use-Based Needs (Functional Jobs) (If applicable)
Examples:
- Must monitor blood glucose levels
- Must log daily actions quickly

Your app:
- [USE_NEED_1]
- [USE_NEED_2]

#### Usability-Based Needs (Constraints) (If applicable)
Examples:
- Must be portable
- Must work offline
- Must be usable one-handed

Your app:
- [USABILITY_NEED_1]
- [USABILITY_NEED_2]

#### Meaning-Based Needs (Identity / Emotion) (If applicable)
Examples:
- Wants to avoid broadcasting a medical condition
- Wants calm, non-clinical design

Your app:
- [MEANING_NEED_1]
- [MEANING_NEED_2]

#### Social / Status Needs (If applicable)
Examples:
- Should feel “normal” for a college student
- Should align with tools peers already use
- Use the app to signal status, credibility, or professional legitimacy
- Use the app to signal alignment with a specific group or identity

Your app:
- [SOCIAL_NEED_1]
- [SOCIAL_NEED_2]

### Customer / Market Intelligence

#### ICP 1
- Ideal Customer Profile description: **[ICP_Description]**
- ICP goals: **[GOALS]**
- Primary use cases: **[USE_CASES]**
- Existing alternatives users rely on today: **[ALTERNATIVES]**
- Key differentiation: **[DIFFERENTIATOR]**

#### ICP 2 (if possible)
...

#### ICP 3 (if possible)
...

### Product Scope & Constraints
Add to (in addition to anything the user already provided):

- MVP (must-have at earlier milestones): **[MVP_FEATURES]**
- Mandatory features: **[MANDATORY_FEATURES]**
- Later (nice-to-have): **[LATER_FEATURES]**
- Constraints (time, tech, budget, hosting, libraries): **[CONSTRAINTS]**
- Must include (particular ICP, etc): **[MUST_ALSO_INCLUDE]**

### → Output: Features & Milestones

> **Generated from the above:** Based on the user needs, ICP profiles, and product scope, the following features and milestones are derived:

| Milestone | Features | Derived From |
|-----------|----------|--------------|
| M1 (MVP)  | [FEATURE_LIST] | MVP scope, core Use-Based Needs |
| M2        | [FEATURE_LIST] | Mandatory features, Usability Needs |
| M3+       | [FEATURE_LIST] | Later features, Meaning/Social Needs |

---

## Required Planning Artifacts (Must Exist Before Creating Milestones Plan)

### 1) User Flows
Create these **before** milestones:
- Onboarding / first-run flow
- Primary usage loop
- Secondary flows (settings, history, export, etc.)
- Error & edge-case flows

### 2) State & Persistence Plan
Separate clearly:
- Persisted business data
- Persisted settings/preferences
- Temporary UI state
- Offline vs online behavior

### 3) UI States (Explicit)
List at minimum:
- Empty state
- Loading state
- Error state
- Success / confirmation state
- First-run state
- Edge cases

---

## Milestone Design Rules (Non-Negotiable)
- Each milestone must produce **observable progress**
- Categorize milestones (add the category in parentheses at the end of the milestone folder name)
  - **MVP**
  - **Basic**
  - **Intermediate**
  - **Advanced**
  - Note: You can combine categories like this: MVP Basic, MVP Intermediate.
- Avoid combining **two high-complexity features** in the same milestone unless they are both needed for one to work.
- Each milestone must be runnable/testable
- Early milestones should prioritize a working end-to-end loop over polish
- Every milestone must declare:
  - Deliverables (what exists afterward)
  - Interfaces/contracts (what shapes should be stable)
  - Files touched (what changed)
  - Verification (how to tell it works)
- You should organize into nested folders of phases/milestones/sprints. Prefix the folder names with the sequence numbers: eg. 1., 2., 3., etc.
- At each milestone folder, add in parentheses at the end of the filename whether it's MVP, Basic, Intermediate or Advanced, or MVP Basic or MVP Intermediate


---

## Mandatory Features
Some features MUST appear somewhere in the milestones:
- [MANDATORY_FEATURE_1]
- [MANDATORY_FEATURE_2]
- [MANDATORY_FEATURE_3]

(If unknown, propose defaults and ask for confirmation.)

---

## State Tracking (Required)

### File
**`.agents/state.json`**

### Purpose
Allows the agent to:
- Resume work exactly
- Track milestone progression
- Record key decisions so later milestones remain compatible

### Required Fields
```json
{
  "current_milestone_id": "",
  "status": "not_started | in_progress | blocked_waiting_user | complete",
  "last_updated_iso": "",
  "decisions": {},
  "completed": []
}
```


## OPTION 2/2: IF BIGGER SCOPE, add epics:
- Fill inputs: (Need help filling the inputs from an app description? Refer to [[Plan with epics and milestones first - Adjunct AI to fill the inputs]])
```
# Epic-Based Product Plan Generator

## Role
You are an expert **Product Manager + Software Architect + Prompt Engineer**.  
Your job is to turn an app idea into a **grounded, epic-based product plan** that an AI coding agent can implement **incrementally**, with stable interfaces and reviewable increments.

---

## Prime Directive
Do **NOT** generate a full app or full codebase in one pass.

You must:
1. Create **Epic 0 (Planning & Decisions)** first.
2. Then identify **Epics E1...En** as **major capability groups**.
3. For each epic:
   - Explain the **user outcome**
   - List the **features/stories inside the epic**
   - Explain **why this epic exists**
   - Identify **dependencies / prerequisites**
   - Suggest a **recommended implementation order**
4. After generating the epic plan:
   - Output a **verification checklist** the user can use to validate whether the epic definition or milestone definition is correct.
   - Output a **State Update** for `.agents/state.json`
   - **Explicitly ask the user to confirm** before breaking any epic into milestones or implementation steps

You must **not** jump directly into milestone execution unless the user confirms.

If `.agents/state.json` is missing or not updated, the planning step is considered **incomplete**.

---

## Objective
Your primary job is to identify the correct **epics** for this product.

An **epic** is:
- a large product capability or outcome area
- made up of multiple related features, flows, or stories
- meaningful to users and the business
- large enough to be split into milestones later

A **milestone** is **not** the same thing as an epic.  
Do **not** confuse:
- **Epics** = what major capability areas the product needs
- **Milestones** = how implementation is sequenced later

Your first responsibility is to discover the right **epics**, not implementation chunks.

---

## Inputs (User-Provided)

### App Summary
- **App name:** `[APP_NAME]`
- **One-liner:** `[ONE_LINE_DESCRIPTION]`
- **Target platform:** `[web | mobile | desktop | browser extension | CLI]`
- **Target users:** `[WHO]`
- **Core outcome / success signal:** `[WHAT SUCCESS LOOKS LIKE]`

### Product Scope & Constraints
- **MVP (must-have):** `[MVP_FEATURES]`
- **Mandatory features:** `[MANDATORY_FEATURES]`
- **Later (nice-to-have):** `[LATER_FEATURES]`
- **Constraints (time, tech, budget, hosting, libraries):** `[CONSTRAINTS]`
- **Must include:** `[MUST_ALSO_INCLUDE]`

If some of these are missing, generate reasonable defaults, clearly label them as **assumptions**, and ask the user to confirm or edit them.

---

## Foundation Layer: Requirements & Intelligence Gathering

> The following sections are used to derive the product's **epics**.  
> They are grounding inputs, not optional fluff.

Double-check that all required inputs are actually collected.  
Be clear about what is truly mandatory vs optional.

For foundational inputs that are missing, generate suggested defaults, label them as **suggestions**, and ask the user to approve or revise them.

---

## User Needs (Grounding Layer)

Provide concrete examples. Avoid vague abstractions.

### Use-Based Needs (Functional Jobs) *(if applicable)*
Examples:
- Must monitor blood glucose levels
- Must log daily actions quickly

Your app:
- `[USE_NEED_1]`
- `[USE_NEED_2]`

### Usability-Based Needs (Constraints) *(if applicable)*
Examples:
- Must be portable
- Must work offline
- Must be usable one-handed

Your app:
- `[USABILITY_NEED_1]`
- `[USABILITY_NEED_2]`

### Meaning-Based Needs (Identity / Emotion) *(if applicable)*
Examples:
- Wants to avoid broadcasting a medical condition
- Wants calm, non-clinical design

Your app:
- `[MEANING_NEED_1]`
- `[MEANING_NEED_2]`

### Social / Status Needs *(if applicable)*
Examples:
- Should feel “normal” for a college student
- Should align with tools peers already use
- Use the app to signal status, credibility, or professional legitimacy
- Use the app to signal alignment with a specific group or identity

Your app:
- `[SOCIAL_NEED_1]`
- `[SOCIAL_NEED_2]`

---

## Customer / Market Intelligence

### ICP 1
- **Ideal Customer Profile description:** `[ICP_DESCRIPTION]`
- **ICP goals:** `[GOALS]`
- **Primary use cases:** `[USE_CASES]`
- **Existing alternatives users rely on today:** `[ALTERNATIVES]`
- **Key differentiation:** `[DIFFERENTIATOR]`

### ICP 2 *(if possible)*
- **Ideal Customer Profile description:** `[ICP_DESCRIPTION]`
- **ICP goals:** `[GOALS]`
- **Primary use cases:** `[USE_CASES]`
- **Existing alternatives users rely on today:** `[ALTERNATIVES]`
- **Key differentiation:** `[DIFFERENTIATOR]`

### ICP 3 *(if possible)*
- **Ideal Customer Profile description:** `[ICP_DESCRIPTION]`
- **ICP goals:** `[GOALS]`
- **Primary use cases:** `[USE_CASES]`
- **Existing alternatives users rely on today:** `[ALTERNATIVES]`
- **Key differentiation:** `[DIFFERENTIATOR]`

---

## Required Planning Artifacts (Must Exist Before Defining the Epic Plan)

### 1) User Flows
Create these first:
- Onboarding / first-run flow
- Primary usage loop
- Secondary flows (settings, history, export, admin, collaboration, etc.)
- Error & edge-case flows

### 2) State & Persistence Plan
Separate clearly:
- Persisted business data
- Persisted settings/preferences
- Temporary UI state
- Offline vs online behavior

### 3) UI States (Explicit)
List at minimum:
- Empty state
- Loading state
- Error state
- Success / confirmation state
- First-run state
- Edge cases

---

## Epic Design Rules (Non-Negotiable)

- Each epic must represent a **major user or business capability**
- Each epic must be **larger than a single feature**
- Each epic must be able to be broken into smaller milestones or stories later
- Avoid defining epics purely by technical layer unless the technical layer is user-meaningful
- Prefer epics that map to user outcomes, workflows, or core business functions

Every epic must declare:
- **Epic name**
- **Epic goal / user outcome**
- **Why it matters**
- **Included features/stories**
- **Dependencies**
- **Risks / unknowns**
- **What is explicitly out of scope**

Distinguish between:
- **Core epics** needed for MVP
- **Mandatory epics** required by constraints or business rules
- **Later epics** for expansion or polish

---

## Mandatory Features Coverage
Some features MUST appear inside one or more epics:
- `[MANDATORY_FEATURE_1]`
- `[MANDATORY_FEATURE_2]`
- `[MANDATORY_FEATURE_3]`

If unknown, propose defaults and ask for confirmation.

---

## Output Requirements: Epic Map

Based on the user needs, ICP profiles, flows, and scope, identify the product’s major epics.

Return the following sections:

### A. Suggested Epic List

| Epic ID | Epic Name | Goal / Outcome | Includes | Derived From | Priority |
|--------|-----------|----------------|----------|--------------|----------|
| E1 | `[EPIC_NAME]` | `[USER_OUTCOME]` | `[FEATURES/STORIES]` | `[Needs / ICP / MVP / Constraint]` | `[MVP / Mandatory / Later]` |

### B. Epic Details

For each epic, provide a section in this format:

#### E1. [Epic Name]
- **Goal / user outcome:** ...
- **Why this epic exists:** ...
- **Includes:** ...
- **Dependencies:** ...
- **Risks / unknowns:** ...
- **Out of scope:** ...
- **Suggested order:** ...

### C. Coverage Check

Show how the proposed epics cover:
- MVP requirements
- Mandatory features
- User needs
- ICP needs
- Constraints

### D. Verification Checklist

Provide a checklist the user can use to confirm whether the epic structure is correct.

Example items:
- Does each epic represent a major capability rather than a single feature?
- Are all mandatory features covered by at least one epic?
- Can each epic be split into milestones later?
- Are any epics too technical and not user-meaningful?
- Are any major product outcomes missing?

### E. Optional Next Step

After the epic plan is approved, optionally propose:
- how to break each epic into milestones
- how to order milestones for implementation
- how to define stories/tasks inside each epic

Do **not** generate those yet unless the user confirms.

---

## State Tracking (Required)

### File
`.agents/state.json`

### Purpose
Allows the agent to:
- Resume work exactly
- Track epic planning progression
- Record key decisions so later milestones remain compatible

### Required Output
Return a proposed state update in this format:

"""
{
  "current_epic_id": "E0",
  "status": "in_progress",
  "last_updated_iso": "[ISO_TIMESTAMP]",
  "decisions": {
    "platform": "[PLATFORM]",
    "mvp_scope": "[SUMMARY]",
    "main_constraints": "[SUMMARY]"
  },
  "identified_epics": [
    {
      "id": "E1",
      "name": "[EPIC_NAME]",
      "priority": "[MVP | Mandatory | Later]"
    }
  ],
  "completed": ["E0.discovery"]
}
"""

---

## Final Instruction

Your first job is to identify the **right epics**, not to generate implementation milestones.

Always:
1. Ground the epics in user needs, ICPs, flows, and constraints
2. Show why each epic exists
3. Check whether all mandatory features are covered
4. Ask the user to confirm the epic map before converting any epic into milestones
```

---


## Prompt to continue work (jumping back into Cursor):

If you're concerned about jumping pass verification steps from another day: 
Yes - If you hadn’t verified a previous milestone’s implementation, it will know to ask you a series of questions because of state.json.

Please adjust “Where to refer to for milestones etc” because the initiating prompt allowed the AI to decide what file structure is best for the milestone/epic planning

Please adjust the “Where to read code” to either:
- “LLM_CODE_REFERENCE*.md which are high level overviews with line references. If it appears out of date, read the actual codebase.”
- Or wherever the milestones were generated
  
Prompt:
```
## Instructions for AI Agent

You are continuing development on an app project organized by milestones. 

Where to refer to for milestones etc:
EPIC_MAP.md and IMPLEMENTATION_STORIES.md

Where to read code:
LLM_CODE_REFERENCE*.md which are high level overviews with line references

### Step 1: Read Current State

First, read the state file to understand where we are:

"""
.agents/state.json
"""

The state file contains:
- `current_milestone_id` — The milestone currently being worked on
- `status` — Current status (see table below)
- `completed` — Array of finished milestone IDs
- `app_name` — The application being built
- `decisions` — Tech stack and architectural decisions already made

### Step 2: Read Project Overview

Read the root `README.md` to understand:
- The app's purpose and target users
- The complete milestone list and order
- Folder structure mapping milestone IDs to folders

### Step 3: Determine Action Based on Status

| Status | Action |
|--------|--------|
| `blocked_waiting_user` | **STOP.** Tell user what confirmation is needed. Do not proceed without explicit approval. |
| `in_progress` | Continue implementing the current milestone. Check the milestone README for remaining work. |
| `verification_ready` | Present the verification checklist to the user. Wait for confirmation before marking complete. |
| `complete` | Move to the next milestone. Update `current_milestone_id` and set status to `in_progress`. |

### Step 4: Locate Milestone Documentation

Find the folder matching `current_milestone_id` from the project structure. Each milestone folder contains a `README.md` with:
- **Deliverables** — What must be working when done
- **Interfaces/Contracts** — Types and APIs to implement
- **Files to Create** — Exact file paths and purposes
- **Verification Checklist** — All items must pass before completion

### Step 5: Implement the Milestone

**Implementation Rules:**
1. Use the tech stack from `state.json` decisions
2. Create files one at a time, allowing human review between files
3. Follow existing code patterns if the codebase already has code
4. Do not skip ahead to future milestones
5. Do not implement features from later milestones
6. Reference the milestone README for exact specifications

### Step 6: Update State When Complete

After all verification checklist items pass, update `.agents/state.json`:

**When code is ready for verification:**
"""json
{
  "current_milestone_id": "<current>",
  "status": "verification_ready",
  "last_updated_iso": "<current ISO timestamp>",
  ...
}
"""

**Ask user to verify the work:**
    - Output a **verification checklist** the user can follow to confirm whether the epic or milestone definition is correct and completed.

    - Each verification item should include:
      - the exact page or route to visit
      - the exact button, link, tab, or control to click
      - the exact value or text to enter
      - the exact expected result
      - what to compare against
      - what the user should report back

    - Where useful, include optional **DevTools Console** commands to verify:
      - visible values
      - state values
      - DOM content
      - local storage
      - network payload assumptions
      - function outputs

    - For each verification item, tell the user:
      - where to go
      - what to click
      - what to type or select
      - what should happen
      - what value, text, label, or count should match
      - how to report back in a structured way

    - When applicable, provide a copy-paste **DevTools Console** command and specify exactly what output should match the verification checklist.

Remind user they can ask for help with a specific verification step if they don't understand it.

**When user confirms verification passed:**
"""json
{
  "current_milestone_id": "<next milestone>",
  "status": "in_progress",
  "last_updated_iso": "<current ISO timestamp>",
  "completed": ["<all completed milestones including current>"]
}
"""

And recommend to user a git commit message name for these updates, but do not actually commit it for the user.

---

## Completion Report Format

When you finish work on a milestone (or a work session), report to the user:

"""markdown
## Work Completed

**Milestone:** [ID] - [Name]
**App:** [app_name from state.json]
**Status:** [new status]

### Files Created/Modified
- `path/to/file.ts` — Brief description
- `path/to/another.tsx` — Brief description
- ...

### What's Working Now
- Feature 1 is functional
- Feature 2 is functional
- ...

### Verification Steps for Human

Please test the following:

1. [ ] [First verification item from milestone README]
2. [ ] [Second verification item]
3. [ ] [Continue for all items...]

### Next Steps

Once you confirm the verification checklist passes:
- Reply "verified" to proceed to [next milestone]
- Or report any issues that need fixing
"""

---

## Human Validation Checklist Template

For each milestone, the human should:

### Quick Smoke Test
1. [ ] Application starts without errors
2. [ ] No console errors in browser DevTools (if web app)
3. [ ] New feature is accessible

### Functional Testing
- Follow the verification checklist items from the milestone README
- Test each feature manually
- Try edge cases (empty inputs, invalid data, rapid interactions)

### Visual/UX Check
1. [ ] Layout matches expected design patterns
2. [ ] Responsive behavior is reasonable (if applicable)
3. [ ] Loading states are visible where appropriate
4. [ ] Error states are clear and helpful

### Code Quality (Optional)
1. [ ] No type errors (if using TypeScript)
2. [ ] Code follows project conventions
3. [ ] No obvious security issues

---

## Status Responses

Use these responses based on state:

### If `blocked_waiting_user`:
"""
Development is paused at **[Milestone ID] - [Name]** awaiting your confirmation.

Please review the following and confirm:
[List items from milestone README's awaiting confirmation section]

Reply with your confirmations or modifications to proceed.
"""

### If `in_progress`:
"""
Continuing development on **[Milestone ID] - [Name]**.

Current progress:
- [List what's done based on files that exist]
- [List what remains based on milestone README]

Proceeding with: [Next file or feature to implement]
"""

### If `verification_ready`:
"""
**[Milestone ID] - [Name]** is ready for verification.

Please test:
[Verification checklist from milestone README]

Reply "verified" to proceed or describe any issues found.
"""

---

## Quick Start Command

Copy and paste this to an AI agent to begin:

"""
Read .agents/state.json in the milestones folder, then read the root README.md 
to understand the project structure. Find and read the README for the current 
milestone based on current_milestone_id. Tell me the current status and either 
continue development or tell me what confirmation you need.
"""

---

## State File Schema

"""json
{
  "current_milestone_id": "string — ID of current milestone (e.g., M0, M1)",
  "status": "string — blocked_waiting_user | in_progress | verification_ready | complete",
  "last_updated_iso": "string — ISO 8601 timestamp",
  "app_name": "string — Name of the application being built",
  "decisions": {
    "key": "value — Architectural and tech stack decisions"
  },
  "completed": ["array — List of completed milestone IDs"]
}
"""

---

## Milestone README Expected Structure

Each milestone README should contain:

"""markdown
# [Milestone ID]: [Name]

> **Status:** [Current status]
> **Depends On:** [Previous milestone]
> **Unlocks:** [Next milestone]

## Deliverables
[What must be working when this milestone is complete]

## Interfaces / Contracts
[TypeScript types, API contracts, data structures]

## Files to Create
[Table of files with paths and purposes]

## Verification Checklist
[Checkbox list of testable requirements]

## UI States Covered (if applicable)
[List of states: empty, loading, error, success, etc.]

## Notes
[Any additional context or constraints]
"""

---

## Error Recovery

If the AI encounters issues:

| Situation | Action |
|-----------|--------|
| `state.json` missing | Create it with `current_milestone_id: "M0"` and `status: "in_progress"` |
| Milestone folder not found | List directory structure and ask user to clarify |
| Verification checklist item fails | Report the failure, suggest fix, do not mark complete |
| Unclear requirements | Ask user for clarification before implementing |
| Conflicting instructions | Prioritize milestone README over general assumptions |
```

At every finished code generation, there likely is a verification list (eg. A list item reads: “Please check you can sign up”). Make sure to double check everything works according to the verification list and reply back to the AI. It will continue.

---

## Did the app break?

If you had been managing context with LLM_CODE_REFERENCE*:
Prompt:
```
Refer to the LLM code reference and see what you broke. You're failing to fix this
```