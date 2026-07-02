## May 2026 Forward

In May 2026, the AI agent conversation changed.

Before then, most people still framed AI progress around the model:

```text
Which model is smarter?
Which model writes better?
Which model reasons longer?
Which model has better benchmarks?
```

But by May 2026 forward, the more important question became:

```text
What system is wrapped around the model?
```

That system is the real difference between a chatbot and an agent.

A chatbot is mostly:

```text
User asks → AI answers
```

An agent is closer to:

```text
User gives goal → AI gathers context → uses tools → checks progress →
asks for approval → acts → verifies → follows up
```

This is why two terms started becoming more important in AI engineering circles:

```text
Harness Engineering
Loop Engineering
```

They describe the next layer of AI work.

Prompt engineering was about how to talk to the model.
Context engineering was about what information to give the model.
Harness engineering is about the system that lets the model act.
Loop engineering is about the recurring workflow that lets the agent keep working toward a goal.

The progression looks like this:
```text
Prompt → Context → Harness → Loop
```

And the product progression looks like this:
```text
Chatbot → Assistant → Agent → Delegated worker → Managed loop
```

## Who Made These Terms Popular

The term **Harness Engineering** appears to have entered mainstream AI-developer discussion largely through the agent-building ecosystem, especially LangChain’s early-2026 writing about agent harnesses.

LangChain’s February 2026 post on “Improving Deep Agents with harness engineering” argued that improving the harness around a coding agent could dramatically improve performance without changing the underlying model. Its March 2026 post, “The Anatomy of an Agent Harness,” gave the clean formula:

```text
Agent = Model + Harness
```

That framing made the idea easier for engineers to understand: the model contains intelligence, but the harness turns that intelligence into useful work.

The term **Loop Engineering** became popular a little later, especially through **Addy Osmani**, an engineering leader at Google Cloud. In June 2026, Osmani published “Loop Engineering,” explaining that the next step after prompting agents manually is designing systems that prompt, check, and steer agents repeatedly. O’Reilly republished the piece later that month, helping spread the term further.

Business Insider also helped push “loop engineering” into broader AI-industry vocabulary. Its June 2026 article described loop engineering as a growing trend among AI developers, citing Anthropic’s Boris Cherny, OpenAI engineer Peter Steinberger, Claire Vo, and Addy Osmani. The common idea was that developers are moving away from manually prompting agents step by step and toward designing recurring systems that keep agents working until a task is complete.

So the simplest attribution is:

```text
Harness Engineering:
Popularized in developer circles by LangChain and agent-runtime builders.

Loop Engineering:
Popularized by Addy Osmani and amplified by AI developer discourse,
Business Insider coverage, and coding-agent users.
```

It is connected to Google, but not exactly because it came from a formal Google convention.

The Google connection is that Addy Osmani works at Google Cloud, and Google I/O 2026 heavily emphasized agentic systems, Gemini Spark, Antigravity, managed agents, and long-horizon background work. Google described Gemini Spark as a 24/7 personal AI agent built on the Google Antigravity platform, and said Antigravity lets Spark perform long-horizon tasks in the background.

## The Personal Agent Was the Consumer Story

The consumer-facing story was easy to understand:

```text
AI is becoming a personal agent.
```

Google’s Gemini Spark made that idea concrete. Google described Spark as a 24/7 personal AI agent that can help users navigate digital life, take action on their behalf, and work under their direction. It runs in the background and is integrated with Google tools like Gmail, Docs, and Slides.

That is the user-friendly version of the story.

But for engineers and builders, the deeper story is architectural.

A personal agent is not just a better chatbot. It needs a system around it that handles:

```text
Tools
Memory
Files
Permissions
Approvals
Scheduling
Background execution
Verification
Logs
Recovery
Escalation
```

That system is the harness.

## What Harness Engineering Means

Harness engineering is the work of designing the environment around the model so the agent can act reliably.

A model by itself can generate text, reason through problems, and call tools if given the right setup.

But the model alone does not know:

```text
Which files it can access
Which tools it can use
Which actions are safe
When to ask permission
How to verify the result
Where to store memory
How to recover from failure
When to stop
How to log what happened
```

The harness answers those questions.

A basic harness includes:

```text
Tool access
File access
Memory
Task state
Permissions
Sandboxing
Observability
Verification
Human approval gates
Error handling
```

This is why model performance is no longer the whole story.

Two agents can use the same model but perform very differently if one has a better harness.

One agent may simply produce a draft.

Another agent may:

```text
Read the project files
Create a plan
Make changes
Run tests
Review errors
Fix failures
Summarize what changed
Ask before merging
Log the work
```

That second system is not smarter only because of the model.

It is more useful because of the harness.

## Why Harness Engineering Matters

Harness engineering matters because agents are moving from “answering” to “acting.”

When AI only answers questions, mistakes are annoying.

When AI edits files, sends emails, changes schedules, purchases items, or deploys code, mistakes become operational risks.

That means the harness needs to control action.

A safe harness separates work by risk:

```text
Low risk:
Summarize, search, organize, remind.

Medium risk:
Draft emails, prepare documents, suggest calendar changes.

High risk:
Send emails, share files, spend money, delete files, deploy code.
```

The higher the risk, the more the agent should ask for human approval.

A good harness does not just make the agent powerful.

It makes the agent governable.

## What Loop Engineering Means

Loop engineering is the next layer.

A harness gives the agent a controlled environment.

A loop gives the agent a recurring process.

A one-shot task looks like this:

```text
Write this email.
```

A loop looks like this:

```text
Check for new client replies every morning.
Update the project brief.
Draft a response if needed.
Ask me before sending.
Remind me if there is no reply by Friday.
```

The difference is repetition, state, and follow-through.

Loop engineering is about designing the system that keeps the agent moving through a workflow without the human needing to prompt every step.

A useful loop usually has:

```text
Trigger:
When does it start?

Goal:
What is it trying to accomplish?

Context:
What information should it use?

Tools:
What systems can it touch?

Verifier:
How does it know the work is correct?

Stopping rule:
When is it done?

Memory:
What should it remember next time?

Escalation:
When should it ask the human?
```

A loop is not just automation.

It is automation plus judgment, context, tools, memory, and verification.

## Why Loop Engineering Matters

Most real work is not a single prompt.

Real work is repetitive:

```text
Check this every day.
Watch for changes.
Compare today against yesterday.
Follow up if nobody replies.
Keep improving the draft.
Run tests until they pass.
Review the output.
Escalate exceptions.
```

This is why loop engineering matters.

The more agents become useful, the less users want to manually prompt them every step of the way.

Instead of:

```text
Prompt the agent.
Read the result.
Prompt again.
Correct it.
Prompt again.
Ask it to check.
Prompt again.
```

The user wants:

```text
Give the agent a goal.
Let the loop run.
Review the important checkpoints.
Approve the risky actions.
```

That is the shift from AI as a tool to AI as a delegated worker.

## The Risk: Bad Loops Scale Bad Work

Loops are powerful, but they are also dangerous.

A bad one-shot prompt creates one bad output.

A bad loop can create bad output repeatedly.

That means loop engineering needs strong verification.

A weak verifier says:

```text
Did the agent produce something?
```

A better verifier says:

```text
Is it correct?
Is it useful?
Is it current?
Is it sourced?
Is it safe?
Is it aligned with the user’s goal?
Does it need human approval?
```

The more autonomous the loop, the stronger the verifier needs to be.

This is where a lot of future AI failure will happen. Not because the model cannot generate an answer, but because the loop keeps running with weak checks.

## The Builder’s New Job

For AI engineers, consultants, and developers, the job is changing.

The old skill was:

```text
Write better prompts.
```

Then it became:

```text
Provide better context.
```

Now it is becoming:

```text
Build better harnesses.
Design better loops.
```

That means the valuable work is moving toward system design:

```text
What tools should the agent access?
What should be in memory?
What should be temporary?
What should be sandboxed?
What requires approval?
What should be logged?
What triggers the workflow?
What counts as done?
What catches mistakes?
What stops the agent?
```

This is why AI implementation work is becoming less like copywriting and more like operations architecture.

The builder is not just writing prompts.

The builder is designing a controlled worker.

## The May 2026 Forward Focus

May 2026 forward, the AI agent race is no longer only about who has the best model.

The real competition is moving into three layers:

```text
1. Model
The intelligence layer.

2. Harness
The action, tool, memory, permission, and safety layer.

3. Loop
The recurring workflow, verification, and follow-through layer.
```

The public sees personal agents.

Developers see harnesses and loops.

That is the deeper shift.

The agent of the future is not just something you chat with.

It is something you assign work to.

And the quality of that work will depend less on one perfect prompt and more on the system around it:

```text
Prompt → Context → Harness → Loop
```

That is the new AI engineering stack.