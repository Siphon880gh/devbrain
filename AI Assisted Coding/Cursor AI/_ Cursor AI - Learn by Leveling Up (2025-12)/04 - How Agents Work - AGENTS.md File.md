Cursor automatically reads `AGENTS.md` from your project root—no need to remind it in your prompt or AI Agent.

Cursor, Windsurf, Copilot, and other AI IDEs have all agreed to read `AGENTS.md` as a standard configuration file for agent behaviors.

This file defines:
- Agent roles and their trigger phrases
- Instructions for how each agent should behave
- Workflow sequences and coordination patterns
- Checkpoints and validation rules

**Example structure:**

```markdown
# Project AI Agents

## How to Use
Say "act as [role name]" to activate a specific agent.

---

## Frontend Developer
**Trigger:** "act as frontend dev"

You are a senior frontend developer. You specialize in:
- React/Next.js architecture
- TypeScript best practices
- Component design patterns

---

## Backend Developer  
**Trigger:** "act as backend dev"

You are a senior backend developer. You specialize in:
- API design
- Database optimization
- Security practices
```

Since `AGENTS.md` is automatically loaded, you simply type the trigger phrase (e.g., "act as frontend dev") and the agent activates with its full instruction set. No manual configuration needed.

---

## **Sequential Workflow Example: Referencing Prompt Files**

For complex multi-step workflows, you can separate transformation logic into individual prompt files and reference them sequentially. This makes workflows maintainable and reusable.

**Folder structure:**

```
project-root/
├── AGENTS.md
└── prompts/
    ├── prompt-1.md
    ├── prompt-2.md
    └── prompt-3.md
```

**Example prompt files:**

`prompts/prompt-1.md`:
```markdown
# Step 1: Data Validation

Read the input file and validate:
- All required fields are present
- Data types are correct
- No malformed entries exist

If validation fails, report errors and STOP.
If validation passes, output: "VALIDATION COMPLETE"
```

`prompts/prompt-2.md`:
```markdown
# Step 2: Data Transformation

Transform the validated data:
- Convert dates to ISO 8601 format
- Normalize text fields (trim whitespace, lowercase)
- Calculate derived fields

Output: "TRANSFORMATION COMPLETE"
```

`prompts/prompt-3.md`:
```markdown
# Step 3: Output Generation

Generate the final output file:
- Format as JSON with proper indentation
- Save to outputs/ directory
- Create a summary report

Output: "PROCESSING COMPLETE"
```

**AGENTS.md configuration:**

```markdown
# Project AI Agents

## How to Use
Say "act as [role name]" to activate a specific agent.

---

## Data Processor
**Trigger:** "act as data processor"

You are a data processing agent that executes a multi-step workflow.

**Workflow:**
Execute the following prompts in STRICT SEQUENTIAL ORDER. Do not proceed to the next step until the current step is complete.

1. **Step 1 - Validation:**
   - Read and execute instructions from `prompts/prompt-1.md`
   - Apply these instructions to the input file
   - Wait for user confirmation before proceeding

2. **Step 2 - Transformation:**
   - Read and execute instructions from `prompts/prompt-2.md`
   - Apply transformations to the validated data
   - Wait for user confirmation before proceeding

3. **Step 3 - Output:**
   - Read and execute instructions from `prompts/prompt-3.md`
   - Generate and save the final output
   - Report completion

**Rules:**
- NEVER skip steps or execute them out of order
- ALWAYS wait for confirmation between steps
- If any step fails, STOP and report the error
- Each step must output its completion message before proceeding

---

## Automated Data Processor
**Trigger:** "act as automated data processor"

You are an automated data processing agent that executes a multi-step workflow without checkpoints.

**Workflow:**
Execute the following prompts in STRICT SEQUENTIAL ORDER without pausing:

1. Read and execute `prompts/prompt-1.md` (validation)
2. Read and execute `prompts/prompt-2.md` (transformation)
3. Read and execute `prompts/prompt-3.md` (output generation)

**Rules:**
- Execute all steps in one continuous workflow
- Only proceed to next step when current step outputs completion message
- If any step fails, STOP immediately and report the error
- Do NOT modify the prompt files themselves
```

**Usage:**

With checkpoints (human-in-the-loop):
```
User: act as data processor
Agent: [Executes Step 1, waits]
User: proceed
Agent: [Executes Step 2, waits]
User: proceed
Agent: [Executes Step 3, completes]
```

Fully automated:
```
User: act as automated data processor
Agent: [Executes all steps sequentially without pausing]
```

**Benefits of this approach:**

- **Separation of concerns**: Transformation logic lives in `prompts/`, orchestration lives in `AGENTS.md`
- **Reusability**: Multiple agents can reference the same prompt files
- **Maintainability**: Update prompts without changing agent definitions
- **Version control**: Team members can track changes to individual prompts
- **Flexibility**: Easy to add, remove, or reorder steps

