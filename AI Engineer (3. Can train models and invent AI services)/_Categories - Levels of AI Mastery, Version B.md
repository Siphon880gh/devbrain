Caveat: Weng created these categories, which he believes provide a strong summary of AI professionals, though they may not align with the official categories used by expert bodies and organizations that may emerge with time. He also feels that these categories are intuitive and easy to understand. The AI folders on this tutorial website are broken down into these categories of AI Experts.

---

AI mastery isn’t one skill—it’s a ladder. Each level builds on the previous one, adding more leverage, more technical depth, and more ownership over the final outcome. Here’s a practical framework for thinking about how people progress from “using AI” to “building with AI” to “changing AI.”

---

## Level 1: Prompt Craft (Prompt Engineering)

**What it is:** Getting high-quality results from AI through clear instructions, context, constraints, and iteration.

This is the entry point for most people—and it’s more powerful than it sounds. Prompting is not just “asking questions.” It’s the ability to shape behavior: define goals, provide examples, set boundaries, and refine output through feedback.

**Important nuance:**  
Even “AI app/code generation” often still lives at this level. If an AI generates buggy code, the primary skill isn’t deep engineering—it’s knowing _how to direct the model to fix specific issues_. That does require basic coding literacy (reading errors, recognizing missing pieces, testing assumptions), but the core loop is still prompt → output → critique → prompt.

**Signals you’ve mastered Level 1:**

- You can consistently get usable results from messy or ambiguous tasks
    
- You can debug AI-generated outputs by specifying what’s wrong and what to change
    
- You can produce repeatable prompt patterns (templates) for common work
    

---

## Level 2: Automation & Orchestration

**What it is:** Making AI work in repeatable systems instead of one-off conversations.

Level 2 is where AI becomes a workflow: multi-step processes, tool usage, and pipelines that reduce manual effort. The goal shifts from “get a good answer” to “build a reliable loop.”

Examples include:

- Taking a folder of documents and summarizing each one on a schedule
    
- Extracting structured data from emails and routing it into tools
    
- Chaining steps like “transcribe → summarize → tag → store → notify”
    

**What changes at this level:**  
You need some technical ability—not necessarily full software engineering, but enough to think in systems: inputs/outputs, file formats, APIs, edge cases, retries, and failure modes.

**Signals you’ve mastered Level 2:**

- You can turn a task into a pipeline that runs repeatedly
    
- You understand how to orchestrate steps (and handle what breaks)
    
- You can measure reliability: speed, accuracy, and cost over time
    

---

## Level 3: Building AI Products (Apps + APIs)

**What it is:** Turning AI capabilities into real software people can use.

Level 3 is product engineering. Instead of “a workflow I run,” it becomes “an app someone else can use.” This is where coding becomes non-negotiable: UI, backend, integrations, data storage, authentication, deployment, monitoring, and performance.

Typical Level 3 builds:

- A web app that answers questions over company docs
    
- A customer support assistant integrated into ticketing systems
    
- A mobile app that summarizes voice notes and turns them into tasks
    

**What changes at this level:**  
You’re accountable for the full experience: latency, reliability, cost controls, and evaluation. A prompt is no longer enough—you need an architecture.

**Signals you’ve mastered Level 3:**

- You can ship an AI feature end-to-end
    
- You can integrate models via APIs and manage real constraints
    
- You can evaluate quality systematically, not just by “vibe”
    

---

## Level 4: Training & Customizing Models

**What it is:** Improving models by changing the model itself, not just how you use it.

Level 4 includes fine-tuning, training, dataset construction, evaluation design, and experimentation. This is where AI becomes an engineering and research discipline: you’re not only consuming intelligence—you’re shaping it.

Examples include:

- Fine-tuning a model for a specialized domain or writing style
    
- Training embedding models for search and retrieval quality
    
- Building evaluation suites and improving performance through iteration
    

**What changes at this level:**  
You need strong coding skills _and_ ML understanding: data pipelines, optimization basics, experiment design, and a theory-informed intuition for model behavior.

**Signals you’ve mastered Level 4:**

- You can design datasets and evaluation that reflect real goals
    
- You can run experiments and interpret results correctly
    
- You can improve a system by changing the underlying model behavior
    

---

## A Practical Bridge Into Level 4: Terminal Transcription With Whisper

A fast way to “touch” Level 4 thinking—without needing to train a model from scratch—is to build a tool that runs a model locally and solves a real personal workflow.

One of the best starter projects:

**Transcribe audio into text from the terminal using Whisper.**

Why this project works:

- It turns an everyday input (audio) into a high-leverage output (searchable text)
    
- It teaches the core shape of modern AI systems: ingestion → inference → post-processing → storage
    
- It feels like automation, but it introduces model tooling and evaluation habits
    
- It’s immediately expandable into a product: tagging, summaries, task extraction, knowledge-base indexing
    

A simple use case is converting iPhone Voice Memos into text: drop audio files onto a computer and run a command-line tool that outputs transcripts automatically. That creates a durable second brain from fleeting thoughts—without the friction of manual typing.

From there, Level 4-style extensions come naturally:

- Compare accuracy across different model sizes
    
- Build a dataset of “hard clips” and measure improvements
    
- Add punctuation, summaries, and structured outputs
    
- Evaluate results systematically and iterate
    

---

## The Point of the Ladder

This framework isn’t about gatekeeping. It’s about clarity.

- **Level 1** teaches you to steer intelligence.
    
- **Level 2** teaches you to systematize it.
    
- **Level 3** teaches you to ship it.
    
- **Level 4** teaches you to improve it at the model level.
    

Mastery isn’t a single jump—it’s a progression of ownership. Each level increases what you can build, how reliably you can build it, and how much of the stack you truly control.