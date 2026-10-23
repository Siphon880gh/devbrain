GSD ([GSD Core](https://github.com/open-gsd/gsd-core)) stands for Git - ship - done. It solves [context rot](https://github.com/open-gsd/gsd-core/blob/next/docs/explanation/context-engineering.md) — the quality degradation that accumulates as an AI fills its context window — by running all heavy research, planning, and execution work in fresh-context subagents while keeping your main session lean.

Practically, it is a command-driven framework that guides an AI coding agent from an initial idea through scoping, requirements, planning, implementation, testing, and shipping.

You do **not** need to create a `PROJECT-SCOPE.md` file yourself. For beginners, the recommended approach is to run `/gsd-new-project` and let GSD interview you. It will create the project documentation, requirements, and roadmap from your answers.

If you already have a written project brief, you can provide it as an optional shortcut.

GSD Core works in both **Claude Code** and **Cursor**.

## Step 1: Choose Claude Code or Cursor

You only need one coding environment:

- **Claude Code** is an AI coding agent that runs from your terminal.
    
- **Cursor** is a code editor with an integrated Agent chat.
    

GSD’s workflow is essentially the same in both environments.

## Step 2: Open your project folder

For a completely new application, create an empty folder and open it in Claude Code or Cursor.

For an existing application, open its current Git repository.

In Cursor, you can use the integrated terminal inside the project folder.

## Step 3: Install GSD Core

Run this command in the terminal:

```bash
npx @opengsd/gsd-core@latest
```

When prompted, select your coding environment:

- Select **Claude Code** if you use Claude Code.
    
- Select **Cursor** if you use Cursor.
    

The installer may also ask whether you want a local or global installation:

- Choose **local** to install GSD only for the current project.
    
- Choose **global** to make GSD available across multiple projects.
    

A local installation is usually simpler when trying GSD for the first time.

After installation, restart Claude Code or open a fresh Cursor Agent conversation if the commands do not immediately appear.

## Step 4: Let GSD create the project scope or give GSD an existing project scope

You have two ways to begin.

### Option A: Let GSD interview you

This is the recommended beginner path. You do not need to write a scope document.

Run:

```text
/gsd-new-project
```

GSD will ask questions to understand what you want to build.

It may ask about:

- The type of application
    
- The problem it should solve
    
- Its intended users
    
- Required features
    
- The main user journey
    
- User accounts and permissions
    
- Reference websites
    
- Preferred technologies
    
- Integrations such as payments, email, calendars, or AI
    
- Features that should be postponed
    
- How you will determine whether the app is complete
    

You can begin with a simple description such as:

```text
I want to build an appointment-booking application for small service
businesses.

Customers should be able to view available times, book appointments,
receive confirmation emails, and manage their reservations.

Business owners should have a dashboard for managing services, schedules,
customers, and bookings.

I like the general workflow and appearance of [WEBSITE URL], but I do not
need every feature it offers.
```

GSD will ask follow-up questions and turn your answers into a structured project definition.

If you do not know how to answer a technical question, say:

```text
I am not sure. Recommend the simplest appropriate option for the first
version and explain the tradeoffs.
```

You do not need to decide the framework, database, hosting platform, or every technical detail yourself. GSD can research and recommend reasonable options.

### Option B: Give GSD an existing project brief

If you already have a scope, proposal, product-requirements document, or detailed notes, save it in the project folder.

For example:

```text
PROJECT-SCOPE.md
```

Then run:

```text
/gsd-new-project --auto @PROJECT-SCOPE.md
```

This tells GSD to use the document as its starting brief.

The file is optional. It is simply a faster starting point for someone who has already documented the project.

## Step 5: Review what GSD creates

Whether GSD interviews you or reads an existing brief, it creates structured files under:

```text
.planning/
```

These normally include:

- `PROJECT.md` — the application’s purpose and overall context
    
- `REQUIREMENTS.md` — the features and requirements that must be implemented
    
- `ROADMAP.md` — the phases in which the application will be built
    
- `STATE.md` — the project’s current status and next action
    
- Research files — supporting technical research when required
    

You do not have to create these files yourself. GSD creates and maintains them.

However, you should review them before approving the roadmap.

Ask GSD:

```text
Explain the generated project requirements and roadmap in plain language.
Show me anything you assumed, anything you excluded, and any decisions that
still require my approval.
```

Confirm that:

- The application solves the intended problem
    
- The correct users are represented
    
- All essential version-one features are included
    
- Features you do not want remain excluded
    
- The roadmap phases are in a logical order
    
- The final phase sequence can produce a complete application
    

If something is wrong, tell GSD to revise the requirements or roadmap before moving forward.

## Starting from an existing application

If the repository already contains an application, do not initialize it as a completely new project.

Run:

```text
/gsd-onboard
```

GSD will inspect the existing codebase and document its current architecture, conventions, and state.

If you are planning a new version or major addition, follow onboarding with:

```text
/gsd-new-milestone "Name of the new version or feature"
```

GSD will ask what you want to add and create the corresponding requirements and roadmap.

## Step 6: Discuss the first roadmap phase

Once you approve the roadmap, begin Phase 1:

```text
/gsd-discuss-phase 1
```

This is the phase-scoping step. GSD identifies unresolved decisions before it creates the implementation plan.

It may ask about:

- Page or component behavior
    
- Authentication methods
    
- User roles
    
- Database decisions
    
- Library preferences
    
- Testing expectations
    
- Error handling
    
- Features that belong in later phases
    

Your answers are saved in a phase-specific `CONTEXT.md` file. Planning and implementation agents use those recorded decisions instead of guessing.

This step is important because the original project interview defines the entire application, while `/gsd-discuss-phase` focuses on the details of one particular phase.

## Step 7: Create a UI specification when needed

If the phase contains user-facing pages or components, run:

```text
/gsd-ui-phase 1
```

This helps define:

- Page structure
    
- Navigation
    
- Forms
    
- Dashboards
    
- Reusable components
    
- Responsive behavior
    
- Visual and interaction patterns
    

You can usually skip this command for a backend-only phase.

If you gave GSD a reference website, this is a good time to clarify what should be similar and what should be different.

## Step 8: Plan the phase

Run:

```text
/gsd-plan-phase 1
```

GSD researches the phase, divides it into executable tasks, and checks the plan before implementation.

For a test-driven MVP, you can use:

```text
/gsd-plan-phase 1 --mvp --tdd
```

The optional flags mean:

- `--mvp` organizes the work around the smallest usable feature slices.
    
- `--tdd` organizes implementation around test-first red-green cycles.
    

Before approving the plan, ask:

```text
Explain this phase plan in plain language. Confirm which requirements it
implements, what tests will be written, and what will remain for later phases.
Do not execute it yet.
```

Check that the plan:

- Covers the correct phase
    
- Contains clear, testable tasks
    
- Follows the approved requirements
    
- Avoids unnecessary features
    
- Includes meaningful verification
    
- Does not silently change earlier decisions
    

## Step 9: Execute the approved plan

When the plan is ready, run:

```text
/gsd-execute-phase 1
```

GSD analyzes task dependencies, organizes the work into execution waves, and assigns focused tasks to subagents.

If you prefer to watch the process and approve work more frequently, run:

```text
/gsd-execute-phase 1 --interactive
```

Interactive mode can be more comfortable when using GSD for the first time.

## Step 10: Verify the completed phase

After execution, run:

```text
/gsd-verify-work 1
```

GSD walks through user-acceptance testing and records what passes or fails.

If it discovers missing or broken functionality, it can diagnose the problems and create repair plans.

Execute those repairs with:

```text
/gsd-execute-phase 1 --gaps-only
```

Then verify again:

```text
/gsd-verify-work 1
```

Repeat until the phase satisfies its requirements.

The verification loop is:

```text
Execute
   ↓
Verify
   ↓
Diagnose failures
   ↓
Create repair plans
   ↓
Execute repairs
   ↓
Verify again
```

Implementation is not complete simply because the agent finished writing code. The functionality must pass verification.

## Step 11: Ship the phase

If the project is connected to GitHub or another supported Git host and you are ready to create a pull request, run:

```text
/gsd-ship 1
```

If you are only working locally, you can stop after verification and review the changes before publishing anything.

## Step 12: Continue through the roadmap

Repeat the workflow for the next phase:

```text
/gsd-discuss-phase 2
/gsd-ui-phase 2
/gsd-plan-phase 2
/gsd-execute-phase 2
/gsd-verify-work 2
/gsd-ship 2
```

Only use `/gsd-ui-phase` for phases that include user-facing interface work.

Continue until every roadmap phase and version-one requirement has been implemented and verified.

## If you do not know what comes next

Run:

```text
/gsd-progress
```

GSD reads the project state and tells you:

- Where the project currently stands
    
- What has been completed
    
- What remains unfinished
    
- Which command should run next
    

You can also tell it to advance to the next appropriate stage:

```text
/gsd-progress --next
```

## The beginner workflow

If you do not want to write a project-scope document, your complete starting workflow is:

```text
Install GSD
    ↓
/gsd-new-project
    ↓
Answer GSD’s questions
    ↓
Review the generated requirements and roadmap
    ↓
/gsd-discuss-phase 1
    ↓
/gsd-ui-phase 1 when needed
    ↓
/gsd-plan-phase 1
    ↓
Review the plan
    ↓
/gsd-execute-phase 1
    ↓
/gsd-verify-work 1
    ↓
Fix and reverify problems
    ↓
/gsd-ship 1
    ↓
Repeat for each phase
    ↓
Complete application
```

You only need to begin with a reasonably clear app idea. GSD can interview you, research the missing details, create the project scope, organize the requirements, generate the roadmap, and guide the application through implementation and verification.