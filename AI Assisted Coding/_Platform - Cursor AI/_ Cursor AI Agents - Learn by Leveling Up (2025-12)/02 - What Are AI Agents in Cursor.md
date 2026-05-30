Required knowledge:
- Know what are AI Agents

AI Agents in many AI apps are specialized workers that automate parts of your development workflow (or sales workflow!). They run in the background, respond to triggers, transform files, and follow structured instructions. First, review what AI Agents are in the broader context of AI apps:
[[_PRIMER - AI Agents - What are they]]

---

## **AI Agents in Cursor**

Cursor AI agents are not truly agents to their full extent. Here's what they are missing:

- **No multi-agent coordination**: Agents cannot work in coordination. One agent is not aware of another agent's state.
- **No agent roles and names**: 
  - In some agentic systems, agents have distinct roles (Summarizer, QA) and identities (named agents). This enables coordination—you can tell Agent 2 to wait until Agent 1 finishes.
  - Cursor doesn't have named, persistent agents. Instead, we use keyphrases that "take over" the chat by applying a specific prompt or rule set. If your keyphrase is "Bob," multiple prompts can trigger Bob, so they're not distinct agents—just different behaviors activated by the same shortcut. This is configured through `AGENTS.md` (which multiple AI IDEs have adopted), superseding the traditional cursor rules files.
- **Triggers and tooling are not mature**: 
  - Telling it to fire when a file exists won't work natively. You must use shell terminal loops to check file existence, leveraging the agent's ability to wait on shell commands. No mature file structure toolset exists.
  - AI cannot change the model (e.g., Opus 4.5 vs 4o) or mode (Local, Working Tree, Cloud). No mature Cursor toolset exists.

---

## **Agents Work With Local Files and GitHub**

Cursor AI agents can work:

* Directly in your **local environment**
* Inside an online **GitHub repo**
* Or both

This flexibility supports solo developers, teams, automation pipelines, and mixed workflows. Wherever your code lives, agents can operate on it.

Local:
![[Pasted image 20251214070619.png]]

Github repo:
- Requirement: Your local github repo must have an origin pointing to an online repo
- It’ll have access to committing, pushing, etc. The tool is implied from selecting Cloud. No need to mention please use Github.
![[Pasted image 20251214070531.png]]

---

## **Agents Run in Parallel — but Not in Coordination**

Cursor allows multiple agents to run simultaneously, each performing its own transformation. As they finish, effects appear—no manual babysitting required.

### **Parallel ≠ Collaborative**

Agents do **not** communicate. There's no built-in mechanism like:

* *"Agent 2, wait until Agent 1 finishes this file."*
* *"This text is already translated—don't rewrite it."*

Each agent independently processes whatever falls inside its rules.

### **Example: When Agents Collide**

* **Translator Agent** converts English → Spanish
* **Personality Agent** rewrites tone

If Personality Agent expects English, it may distort the Spanish result. If their order flips, the tone rewrite might get lost during translation. Agents trigger when applicable—they don't negotiate order.

### **Example: Can Agent 1 Trigger Agent 2?**

You might want:

* **Schema Agent** generates `schema.json`
* **Client Agent** generates API client code based on the schema

Can Schema Agent tell Client Agent "I'm done, your turn"? **No.** There's no direct agent-to-agent messaging or signaling in Cursor.

However, you can achieve this indirectly—instruct Client Agent to wait for `schema.json` to exist before proceeding. This "file gate" pattern (covered in [DIY Coordination Techniques](#diy-coordination-techniques)) lets you simulate sequential handoffs without actual agent communication, however you're explicit to the AI agent to use its shell tool to loop.

---

## **How Agents Respond to Triggers**

How do agents know when to act? They activate in response to **triggers**—events that tell the agent "it's time."

### **Common Trigger Types**
* **Chat messages** — Messages in Cursor's chat matching the agent's scope. 
	- Cursor agents can be instructed—via a project-level `AGENTS.md`—to respond to **specific keyphrases or invocation patterns**, effectively routing a request to a predefined behavior or sub-prompt.
	- Cursor, Windsurf, Copilot, etc. all have agreed to read a root-level `AGENTS.md` for such instructions

### **Pseudo Trigger Types**
* **File changes** — Save, create, or modify files matching patterns (e.g., `*.md`, `src/**/*.ts`)
* **Pattern matching** — Content inside a file matching specific rules or keywords

Cursor AI cannot handle file changes and pattern matches natively as of Dec 2025. Cursor agents **cannot natively react to file system events**, such as a file being created or modified, in the way a watcher, CI system, or workflow engine can.

To simulate file-based triggers, you must **procedurally instruct the agent** to run shell commands in a loop—e.g., polling every ~50ms—to check for file existence or changes, then interpret the shell output once the condition is met. You're leveraging the agent's ability to execute shell commands and reason over their output, not declaring a true "when A changes, run B" rule.

**Caveat:**
If you're waiting on a file to exist, is it going to be a file that AI will create, then write to, save, write to, save? This is usually the case when creating like an `app.js`, for example. Then instead you want the AI agent to create `done.temp` when it's truly done.

---

## **Checkpoints for Human-in-the-Loop Control**

Worried an agent might push changes too far? Build **checkpoints** into the workflow.

A checkpoint is a pause where the agent stops, shows what it's done, and waits for approval before continuing. This lets you:

* Review each step
* Approve or revise
* Avoid unintended large-scale changes
* Maintain confidence in the process

You can always insert these "green-light moments" rather than one-shotting a full workflow.

In some systems, you'll have to build a connection to a human in the loop interface (like email, text, whatsapp, etc)

In Cursor AI, since the AI Agents are basically the chat windows, it can just ask for your input when it's time.

---

## **Guided Automation Using Markdown Prompt Files**

Note: This is an **optional** method.

Create multi-step automation by dropping **Markdown (.md) prompt files** into a folder, then tell the agent:

> "Follow the prompts in this folder in order."

The agent will:

1. Read each markdown file as an instruction
2. Execute steps sequentially
3. Apply them to specified files
4. Use checkpoints if included

This builds complex workflows without custom scripts—just give the agent a playbook.

**Examples:**

* Multi-step refactors
* Codebase cleanup workflows
* Linting + tone rewrite + documentation sequences
* Standardized project setup pipelines

### **A Note on Multi-Agent Execution**

When multiple agents run simultaneously, there is **no intelligent orchestration**. Cursor doesn't dynamically coordinate agents, resolve conflicts, or optimize execution order.

Any prioritization is based on simplistic heuristics—not "smart" scheduling that analyzes your workflow.

**Takeaway:** If agent order matters, design it yourself—chain prompts, use checkpoints, or run agents sequentially.

### **DIY Coordination Techniques**

Since Cursor won't coordinate agents for you, here are workarounds:

#### **1. File Existence as a Gate**

You'd think to have one agent wait for a file that another agent creates:

* **Prompt 1:** "Generate the API schema and save to `schema.json`."
* **Prompt 2:** "Wait until `schema.json` exists, then generate client code based on it."

The second agent effectively "blocks" until the first agent's output appears. But the problem is  AI will create, then write to, save, write to, save. Instead you want the AI agent to create `done.temp` when it's truly done:

* **Prompt 1:** "Generate the API schema and save to `schema.json`. After this task is finished, create a `done.temp` empty file."
* **Prompt 2:** "Wait until `done.temp` exists, then generate client code based on it."

This of courses replaces you babysitting for prompt 1 to finish, then entering prompt 2 at a later time. Instead, you enter both prompts simultaneously and they run under the idea of "two AI Agents running concurrently".

#### **2. Shared State File for Pseudo-Parallel Coordination**

Use a shared state file like `cursor-agent-state.json`:

1. Both agents check if the file exists—if not, create it with initial flags
2. **Agent A** performs its task, then sets `"taskA_done": true`
3. **Agent B** is instructed: "When `taskA_done` is true, proceed"

```json
{
  "taskA_done": false,
  "taskB_done": false,
  "data_validated": false
}
```

Each agent reads the file, checks its flag, acts accordingly, and updates its flag when finished.

---

## **Summary**

Cursor AI agents are multitasking assistants that can run in parallel on different tasks, working with GitHub repositories or local files.

You're not locked into a "one-shot" approach. Set up checkpoints—points where the agent pauses and waits for your review before continuing. This ensures everything stays on track.

You can automate workflows by placing sequential prompts in markdown files inside a folder. The agent follows these prompts in order, creating an orchestrated workflow with checkpoints if desired.

**Bottom line:** Flexible, safe, and controllable AI workflows that adapt to your needs.

