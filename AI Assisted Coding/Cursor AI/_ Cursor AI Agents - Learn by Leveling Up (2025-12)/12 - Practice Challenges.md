# Cursor AI Agent Practice Challenges

These progressive challenges help you practice the core concepts of working with Cursor AI agents. Each level builds on the previous one, introducing new coordination patterns and workflow techniques.

---

## Challenge 1: Basic File Watching and Input Processing

This foundational challenge introduces you to simulating file-based triggers in Cursor AI. Create a workflow where an AI agent monitors an `inputs/` folder and automatically processes any new files that appear. **Establish a naming convention**: input files should be named `input1.md`, `input2.md`, `input3.md`, etc., and corresponding output files should be named `output1.md`, `output2.md`, `output3.md`, etc. This convention becomes crucial in later challenges.

**The Transformation Rule**: Each input file should contain a sentence or phrase. The agent must transform it into title case hyphenated text. For example:
- Input: `hello world this is a test`
- Output: `Hello-World-This-Is-A-Test`

Start by setting up an `AGENTS.md` file in your project root that defines a "File Processor" agent role—Cursor automatically reads this file, so you can activate your agent simply by referencing the role name in your prompts. Once you've defined the agent in AGENTS.md, invoke it by typing something like "act as File Processor" or "start File Processor" in the Cursor chat, using whatever name you gave the agent in your AGENTS.md.

Since Cursor cannot natively react to file system events as of December 2025, you'll need to procedurally instruct the agent (through your AGENTS.md configuration) to use shell commands in a loop—polling every ~50ms—to check for new numbered input files. The agent should check which input numbers already have corresponding output files, and process any input files that don't have outputs yet. When a new file is detected, the agent should read that file in the `inputs/` folder, apply the title case hyphenation transformation, and write the result to the `outputs/` folder with the matching number. This means an AI agent is always on running the loop function. You'll want to instruct via the `AGENTS.md` that once an output is finished, it returns back to looping. It shouldn't use up so much tokens because the AI Agent is just waiting for the system to break out of the loop with some shell output (that for example, says there is a new file).

This exercise teaches you both how to structure agent instructions in AGENTS.md and the fundamental pattern of "file gate" coordination, where the presence or absence of a file acts as a trigger mechanism. It also helps you understand how to leverage the agent's ability to execute shell commands and reason over their output, which becomes the building block for more complex automation patterns.

---

## Challenge 2: GitHub Issues as Input Triggers

Building on Challenge 1, this level uses GitHub issues as your input trigger mechanism. You can now close the File Processor agent from Challenge 1 and start fresh with a new agent. Expand your `AGENTS.md` to include a "GitHub Issues Processor" agent that monitors your repository's open issues and processes them as inputs. Invoke this agent by typing "act as GitHub Issues Processor" (or whatever name you defined) in the Cursor chat.

Make sure your local repository is connected to a GitHub remote. Then define clear instructions in your AGENTS.md for how this agent should behave. The agent should use shell commands in a loop to check for open issues (using commands like `gh issue list --state open`). When an open issue is detected, treat that issue as your "new input"—the agent should create a local input file based on the issue content, process it according to your specific transformation rules to create an output file, commit the changes with a timestamp as the commit message (for example, "2025-12-14-15-30-45"), push it back to the remote repository, and then close the issue using `gh issue close <issue-number>`. Once the issue is closed and the push is complete, the agent should resume back to looping and checking for the next open issue. The AI Agent or prompt has access to the issue number from a prior shell loop exit.

This challenge helps you practice working with Cursor's GitHub toolset knowledge, including the GitHub CLI for issue management and standard git operations for commits and pushes. It also introduces the concept of using external triggers (GitHub issues) rather than just file system events, showing how agents can integrate with broader development workflows. You'll need to handle the coordination between issue detection, file creation, processing, and git operations in your agent instructions. By this point, your AGENTS.md file is becoming a central configuration hub for multiple agent behaviors.

---

## Challenge 3: Human-in-the-Loop Checkpoints

This challenge focuses on building confidence and control into your agent workflows by implementing checkpoint patterns. Now you'll break down the transformation process into discrete steps with review points between them. This may mean moving the transformation instructions from `AGENTS.md` out into a `prompts/` folder with separate prompt files.

Create a `prompts/` directory and define your transformation as a multi-step sequence:
- **prompts/prompt1.md**: Instructions for title casing the text (convert each word's first letter to uppercase)
- **prompts/prompt2.md**: Instructions for hyphenating the text (replace spaces with hyphens)

Update your `AGENTS.md` to define a "Supervised Processor" agent that:
1. Reads the input file
2. Applies `prompts/prompt1.md` (title casing)
3. **Pauses and shows you the result**, outputting "PHASE 1 COMPLETE: Title casing done" and waits for your approval
4. After you approve, applies `prompts/prompt2.md` (hyphenation)
5. **Pauses again and shows you the result**, outputting "PHASE 2 COMPLETE: Hyphenation done" and waits for your approval
6. After you approve, saves the final result to the output file

This "green-light moment" pattern is crucial for avoiding unintended large-scale changes and maintaining confidence in automated processes. You can review the title-cased text before hyphenation is applied, and review the hyphenated text before it's saved. If something looks wrong at any checkpoint, you can stop the process and adjust the prompts or input.

This challenge reinforces the importance of deliberate workflow design—rather than one-shotting a full workflow, you can insert review points wherever uncertainty or risk exists. It also demonstrates how separating transformation logic into `prompts/` files makes your workflow more maintainable and your AGENTS.md more focused on orchestration rather than implementation details.

---

## Challenge 4: Concurrent Processing with State-Based Coordination

This is where things get sophisticated. Now you'll run multiple File Processor agents simultaneously, each processing different input files without stepping on each other's toes. Create several input files (`input1.md`, `input2.md`, `input3.md`, `input4.md`, `input5.md`) and run multiple agents at the same time (for example, 3 agents concurrently).

Expand your `AGENTS.md` to include coordination logic using a shared state file called `processing-state.json`. This file tracks which input numbers are currently being processed and by which agent. The structure should look like:

```json
{
  "processing": [1, 3, 5],
  "completed": [2, 4]
}
```

Each agent must:
1. **Check the state file** before claiming an input to process
2. **Claim an input number** by adding it to the "processing" array (this prevents other agents from picking the same file)
3. **Process the file** (read input, transform, write output)
4. **Update the state file** by moving the number from "processing" to "completed"
5. **Loop back** to find the next unclaimed input

The key challenge here is avoiding race conditions where two agents try to claim the same input number simultaneously. You'll need to encode careful state-checking logic in your AGENTS.md instructions. Since Cursor agents don't communicate directly to each other as of December 2025, the state file becomes your coordination mechanism. You'll also confront the important reality that Cursor applies edits incrementally—meaning the state file might appear to exist while it's still being written by another agent. Your AGENTS.md instructions should include stability checks (like reading the state file twice with a small delay to ensure it hasn't changed) before trusting its contents.

Invoke multiple agents by opening several Agent Editor panels and typing "act as File Processor" in each one. This challenge teaches you how to coordinate parallel agents working on independent tasks, which is a powerful pattern for batch processing workflows.

---

## Challenge 5: Parallel Feature Development with Working Tree Mode

The final challenge explores Cursor's Working Tree mode for true parallel development, building on the file processing system you've created in Challenges 1-4. Now you'll add a web interface to view your processed outputs. You'll use separate AI agents running simultaneously to add new features to the codebase: a **backend API** and a **frontend interface**, each developed on its own branch. The branches don't need to pre-exist—Cursor can create them as needed using git commands.

**The Goal**: Build two features in parallel:
1. **Backend API** (`api.php`): A PHP endpoint that scans the `outputs/` folder and returns a JSON list of all output files with their content
2. **Frontend Interface** (`index.html`): An HTML page using Tailwind Play CDN for styling and vanilla JavaScript to fetch and display the list from `api.php`

Create a comprehensive `AGENTS.md` that defines two feature-specific agents—"Backend Developer" and "Frontend Developer"—each with clear instructions about which files they should create and how to work within git branches. Each agent should be instructed to check if their designated branch exists (using `git branch --list <branch-name>`), and if not, create it with `git checkout -b <branch-name>` before beginning work.

Set up a scenario where you activate both agents simultaneously in Working Tree mode, each working on their feature in its own git branch. **Both features should be completed before merging** - this is a coordinated release where the backend API and frontend interface form a cohesive feature set that should be deployed together. Don't merge the backend branch until the frontend is also ready, and vice versa. This simulates a team development environment where different features are built simultaneously without interfering with each other, then integrated together as a complete release. Since the Backend Developer works only on `api.php` and the Frontend Developer works only on `index.html`, there will be no file conflicts when merging both branches into main at the end.

**You have two options for handling the merge:**

### Option 1: Automated State-Based Merge (Advanced)
Use an `integration-state.json` file to track completion status, similar to Challenge 4's approach. Each feature agent updates this file when done, and a Merge Agent loops until both are ready, then automatically merges. This builds on your state coordination skills from Challenge 4.

### Option 2: Manual Merge (Simpler)
Manually verify both agents have finished in the Agent Editor, then either merge the branches yourself with git commands or invoke an Integration Coordinator agent to handle the merge for you.

You'll practice encoding separation boundaries in your AGENTS.md, structuring your code to minimize merge conflicts, and managing the complexity of multiple concurrent AI agents that have no awareness of each other. This challenge reveals both the power and limitations of Cursor's approach: while you can run agents in parallel and leverage git's branching to keep work separate, there's no intelligent orchestration or conflict resolution—the quality of your results depends entirely on how well you've designed the separation of concerns in your AGENTS.md configuration and codebase structure. By the end of this challenge, your AGENTS.md becomes a shareable team asset that can be version-controlled and works across multiple AI-powered IDEs (Cursor, Windsurf, Cline, etc.).

### Sample AGENTS.md for Challenge 5

```markdown
# Project AI Agents

## How to Use
Say "act as [role name]" to activate a specific agent.
Say "show me all agents" to see available roles.

---

## Backend Developer
**Trigger:** "act as Backend Developer"

You are a backend developer creating an API to list output files. Follow these steps:

1. **Branch Setup:**
   - Check if branch `feature/backend-api` exists: `git branch --list feature/backend-api`
   - If branch doesn't exist, create it: `git checkout -b feature/backend-api`
   - If branch exists, switch to it: `git checkout feature/backend-api`

2. **File Scope:**
   - Work ONLY on: `api.php`
   - Do NOT touch frontend files, state files, or other feature files

3. **Implementation:**
   - Create `api.php` that scans the `outputs/` directory
   - Return a JSON response with structure:
     ```json
     {
       "outputs": [
         {"filename": "output1.md", "content": "Hello-World-This-Is-A-Test"},
         {"filename": "output2.md", "content": "Another-Example-Text"}
       ]
     }
     ```
   - Add proper CORS headers to allow frontend access
   - Handle errors gracefully if `outputs/` directory doesn't exist
   - Sort output files by number (output1, output2, output3, etc.)

4. **Completion:**
   - Commit your changes with descriptive message
   - Push branch to remote: `git push -u origin feature/backend-api`
   - **If using Option 1 (Automated)**: Update `integration-state.json` to add "backend" to the "implemented" array
   - **If using Option 2 (Manual)**: Report completion and wait for manual merge

---

## Frontend Developer
**Trigger:** "act as Frontend Developer"

You are a frontend developer creating the user interface. Follow these steps:

1. **Branch Setup:**
   - Check if branch `feature/frontend-ui` exists: `git branch --list feature/frontend-ui`
   - If branch doesn't exist, create it: `git checkout -b feature/frontend-ui`
   - If branch exists, switch to it: `git checkout feature/frontend-ui`

2. **File Scope:**
   - Work ONLY on: `index.html`
   - Do NOT touch backend API, state files, or other feature files

3. **Implementation:**
   - Create `index.html` with Tailwind Play CDN for styling:
     ```html
     <script src="https://cdn.tailwindcss.com"></script>
     ```
   - Use vanilla JavaScript to fetch from `api.php`
   - Display the list of outputs in a clean, responsive layout
   - Show each output filename and content in cards or a table
   - Add loading state while fetching
   - Handle errors if API is unavailable
   - Style with Tailwind classes for a modern look

4. **Completion:**
   - Commit your changes with descriptive message
   - Push branch to remote: `git push -u origin feature/frontend-ui`
   - **If using Option 1 (Automated)**: Update `integration-state.json` to add "frontend" to the "implemented" array
   - **If using Option 2 (Manual)**: Report completion and wait for manual merge

---

---

### Merge Agent (Option 1: Automated)
**Trigger:** "act as Merge Agent"

You automatically monitor the integration state and merge when both features are ready. Follow these steps:

1. **State Monitoring Loop:**
   - Check if `integration-state.json` exists; if not, create it with:
     ```json
     {
       "implemented": []
     }
     ```
   - Use a shell command loop (polling every ~50ms) to check the "implemented" array
   - Wait until the array contains both "backend" AND "frontend"
   - When both are present, break out of the loop and proceed to merge

2. **Merge Process (Coordinated Release):**
   - Switch to main branch: `git checkout main`
   - Pull latest: `git pull origin main`
   - Merge both feature branches together:
     - `git merge feature/backend-api`
     - `git merge feature/frontend-ui`
   - Resolve any conflicts if they arise (should be none since each works on separate files)
   - Note: Both features are merged together because they form a cohesive release

3. **Completion:**
   - Push merged main branch: `git push origin main`
   - Delete merged feature branches if desired: `git branch -d feature/backend-api feature/frontend-ui`
   - Report: "Integration complete! Test at http://localhost:8000/index.html (run: php -S localhost:8000)"

---

### Integration Coordinator (Option 2: Invoke when you know all branches finished)
**Trigger:** "act as Integration Coordinator"

**Important**: Only invoke this agent after you've manually verified that both the Backend Developer and Frontend Developer have completed their work and pushed their branches. Check the Agent Editor to confirm both agents have finished and reported completion.

Once both features are complete, invoke the Integration Coordinator to merge them:

1. **Merge Process (Coordinated Release):**
   - Switch to main branch: `git checkout main`
   - Pull latest: `git pull origin main`
   - Merge both feature branches together:
     - `git merge feature/backend-api`
     - `git merge feature/frontend-ui`
   - Resolve any conflicts if they arise (should be none since each works on separate files)
   - Note: Both features are merged together because they form a cohesive release

2. **Completion:**
   - Push merged main branch: `git push origin main`
   - Delete merged feature branches if desired: `git branch -d feature/backend-api feature/frontend-ui`
   - Report: "Integration complete! Test at http://localhost:8000/index.html (run: php -S localhost:8000)"

3. **Completion:**
   - Push merged main branch: `git push origin main`
   - Delete merged feature branches if desired
   - Report integration complete
```

