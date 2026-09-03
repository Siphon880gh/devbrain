Let's say you want a clear starting scope and a process that prevents the agent from jumping into code too early.

[Superpowers](https://github.com/obra/superpowers) provides that process. It guides an AI coding agent through brainstorming, design approval, implementation planning, test-driven development, code review, and final verification.

Superpowers works in both **Claude Code** and **Cursor**. It is not built into either one, so you must install the plugin first.

## Step 1: Choose Claude Code or Cursor

You only need one of these environments:

- **Claude Code** runs as an AI coding agent from your terminal.
    
- **Cursor** is a code editor with an integrated Agent chat.
    

The Superpowers methodology is essentially the same in both. The installation command is different.

### Install Superpowers in Claude Code

Open Claude Code and run:

```text
/plugin install superpowers@claude-plugins-official
```

### Install Superpowers in Cursor

Open Cursor Agent chat and run:

```text
/add-plugin superpowers
```

![[Pasted image 20260903024220.png]]

Or you can also search for **Superpowers** in the Cursor plugin marketplace.

Superpowers’ skills are designed to activate automatically after installation. You normally do not need a `/superpowers` command. However, explicitly telling the agent which Superpowers stage to use can make the workflow clearer—especially when you are still learning it.

## Step 2: Open or create your project folder

If you already have an application repository, open that folder in Claude Code or Cursor.

For a new application, create an empty project folder and open it in your chosen coding environment. Superpowers may use Git branches and worktrees during implementation, so the folder should eventually become a Git repository.

If you are unfamiliar with Git, tell the agent:

```text
Before implementation begins, check whether this folder is a Git repository.
If it is not, help me initialize it safely.
```

Initializing the repository is project setup. It does not mean you have approved application development.

## Step 3: Create a project-scope document

Inside the project folder, create:

```text
PROJECT-SCOPE.md
```

The document does not need to answer every technical question. Its job is to tell the agent what you are trying to build.

Use this beginner-friendly template:

```markdown
# Project Scope

## Product
What type of application is this?

## Problem
What problem should it solve?

## Users
Who will use it?

## Required Features
What must the first version include?

## Main User Flow
What should a user be able to do from beginning to end?

## Reference Website
What website or application demonstrates the desired design or behavior?

## Changes From the Reference
What should be different or improved?

## Accounts and Permissions
Who can sign in, and what can each type of user do?

## Integrations
Does the application need payments, email, AI, calendars, maps, or other services?

## Technology Preferences
Are there required frameworks, databases, or hosting providers?

## Excluded From Version One
What should not be built yet?

## Completion Criteria
How will we know the application is working?
```

If you want to recreate an existing application, provide its website link, but do not depend on the link alone. A public website may reveal the interface without showing its private business rules, database, administration tools, or error-handling behavior.

## Step 4: Begin with brainstorming—not implementation

Start a new Agent conversation and provide this prompt:

```text
Use the Superpowers brainstorming skill.

Read @PROJECT-SCOPE.md and inspect the existing repository. The reference
website is [PASTE URL HERE].

Do not implement anything yet. Do not create application code.

Ask me questions, identify missing requirements, explore possible approaches,
and help me develop a complete product and technical design. Present the
design for my approval before creating an implementation plan.
```

This establishes an important boundary: the agent may inspect and discuss the project, but it should not begin building the application.

During brainstorming, expect questions about:

- User journeys
    
- Pages and interface components
    
- Database entities
    
- Authentication
    
- User roles and permissions
    
- APIs and integrations
    
- Error and empty states
    
- Security concerns
    
- Testing
    
- Deployment
    
- Features that should be postponed
    

Answer the questions carefully. If you do not know an answer, ask the agent to recommend the simplest reasonable option and explain the tradeoffs.

## Step 5: Review the proposed design

Superpowers should turn the discussion into a written design.

Before approving it, confirm that the design explains:

- What the first version will include
    
- What it will deliberately exclude
    
- How users move through the application
    
- What data must be stored
    
- Which external services are required
    
- How accounts and permissions work
    
- How the major application components fit together
    
- How the finished product will be tested
    

If something is missing, say:

```text
Do not move to implementation planning yet. Revise the design to address
the following issues:

[LIST YOUR ISSUES]
```

Do not say “go,” “build it,” or “start” until you are comfortable with the design.

When the design is correct, say:

```text
I approve the design. Use the Superpowers writing-plans skill to create
the implementation plan. Do not begin implementation until I approve
the plan.
```

## Step 6: Review the implementation plan

The implementation plan translates the approved design into small engineering tasks.

A strong plan should identify:

- The exact order of work
    
- Files that will be created or changed
    
- Dependencies between tasks
    
- Tests required for each behavior
    
- Commands used to verify the work
    
- Completion criteria for every task
    
- The smallest functional version that can be tested
    

Superpowers emphasizes:

- **Red-green-refactor TDD:** write a failing test, make it pass, and then improve the code
    
- **YAGNI:** do not build speculative features that are not currently needed
    
- **DRY:** avoid unnecessary duplication
    
- **Small tasks:** keep each implementation step focused and reviewable
    
- **Evidence:** run tests instead of merely claiming the code works
    

Review the plan as carefully as the design. Make sure every required feature is represented and nothing unnecessary has been introduced.

If the plan is too large or vague, say:

```text
Revise the plan into smaller, independently testable tasks. Preserve the
approved scope and do not add new features.
```

## Step 7: Approve subagent-driven development

When the plan is ready, say:

```text
I approve the implementation plan.

Use Superpowers subagent-driven development to execute it. Follow true
red-green-refactor TDD. Require specification-compliance and code-quality
reviews for every task. Stop and ask me if implementation would require
changing the approved design or scope.
```

Superpowers can now assign each task to a fresh implementation subagent. After a task is completed, separate review agents check:

1. Whether the implementation matches the specification
    
2. Whether the code quality is acceptable
    

Problems should be corrected before the workflow moves forward.

This allows the project to progress for longer periods without one overloaded conversation holding every detail.

## Step 8: Verify the complete application

Individual tasks passing their tests does not automatically mean the complete application works.

After implementation, ask:

```text
Use the Superpowers verification and code-review skills to validate the
complete application against PROJECT-SCOPE.md and the approved design.

Run the full test suite, linting, type checking, and production build.
Start the application and test the main user flows. Report failures,
missing requirements, security concerns, and unfinished work before
declaring the project complete.
```

The final verification should include:

- Automated tests
    
- Production build
    
- Main user journeys
    
- Authentication and permissions
    
- Error handling
    
- Empty and loading states
    
- Mobile or responsive behavior, when applicable
    
- Acceptance criteria from the scope
    
- Final code review
    
- Setup and deployment instructions
    

Do not accept “implementation complete” without test results or other concrete evidence.

## If the agent starts coding during brainstorming

Stop it immediately and say:

```text
Stop implementation. We are still in the Superpowers brainstorming stage.

List any files you changed, explain what was changed, and return to design
discussion. Do not make additional code changes until I approve both the
design and implementation plan.
```

This does not necessarily mean Superpowers is broken. The agent may have interpreted part of your wording as approval to proceed. Clearly naming the current stage and the next approval checkpoint usually prevents the problem.

## The complete workflow

```text
PROJECT-SCOPE.md
        ↓
Superpowers brainstorming
        ↓
Approved product and technical design
        ↓
Detailed implementation plan
        ↓
Your approval
        ↓
Subagent-driven development
        ↓
TDD and task-by-task review
        ↓
Whole-application verification
        ↓
Complete application
```

Your project scope establishes the destination. Superpowers provides the engineering discipline required to reach it without rushing directly from a rough idea into unreviewed code.