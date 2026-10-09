Keep repository-wide AI instructions in an `AGENTS.md` file at the project root when handing a codebase between AI platforms, harnesses, IDEs, or command-line agents.

An AI platform's chat history and personal settings usually do not transfer to another platform. `AGENTS.md` travels with the repository, so a receiving AI can follow the same operating rules without depending on the previous conversation or a vendor-specific configuration screen.

This keeps work consistent because each supporting AI receives the same instructions about:

- how to build, run, test, lint, and verify the project
- coding conventions and architectural boundaries
- which files or generated artifacts should not be edited
- required checks before declaring a task complete
- security, privacy, and dependency constraints
- how documentation and code-reference files must be maintained
- repository-specific workflow, naming, and commit expectations

## Prefer portable instructions

Put cross-platform rules in `AGENTS.md`. Keep vendor-only configuration—such as Cursor-specific rules or a tool-specific command—limited to cases that genuinely require it.

Write instructions as repository facts and observable requirements rather than assumptions about one interface. For example:

```markdown
# AGENTS.md

## Project commands
- Install dependencies with `npm ci`.
- Run checks with `npm run check`.
- Run browser tests with `npm run test:browser`.

## Implementation rules
- Keep database access behind the repository layer.
- Do not edit generated files in `dist/`.
- Preserve existing public API behavior unless the task explicitly changes it.

## Before completion
- Run the checks relevant to the changed files.
- Report any check that could not be run and why.
- Update the applicable `AGENTS_CODE_REFERENCE*.md` after architectural or workflow changes.
```

Avoid instructions such as "click the button in the right sidebar" unless the repository can only be maintained through that specific product. A CLI or cloud agent may have no equivalent interface.

## Handoff prompt for the next AI platform

```text
This repository is being continued from another AI coding platform.

Read and follow AGENTS.md before making changes. Then read AGENTS_CODE_REFERENCE.md and any relevant feature reference files to understand the codebase. Inspect the actual source files involved in the task because the code is authoritative.

Continue with: {task and current status}
```

The handoff prompt can stay short because the durable rules already live in the repository.

## `AGENTS.md` and code references have different jobs

| File | Purpose |
| --- | --- |
| `AGENTS.md` | Explains **how the AI should work** in this repository. |
| `AGENTS_CODE_REFERENCE.md` | Explains **what the codebase is and how it works**. |
| Handoff status or task note | Explains **where the previous AI stopped and what should happen next**. |

Using all three prevents the receiving AI from having to reconstruct process rules, architecture, and current task state from chat history.

## Important limitation

Support for automatically discovering `AGENTS.md` can vary between products and versions. Even when a platform does not load it automatically, explicitly telling the agent to read it provides the same portable source of instructions. Keep the file version-controlled and make the handoff prompt name it directly.
