Make aWhen moving a codebase from one AI platform or harness to another—such as Google AI Studio to Cursor, Cursor to Claude Code, or Claude Code to Codex CLI—the new AI does not inherit the previous chat's context.

Keep an AI-oriented codebase map such as `AGENTS_CODE_REFERENCE.md` inside the repository. Because the reference travels with the code, the next AI can quickly reconstruct the same high-level understanding instead of guessing from a partial scan of the source.

This makes handoffs more consistent because every platform begins with the same written description of:

- what the application does
- the technology stack and architecture
- the important folders and files
- major workflows and how data moves through them
- where important functions, classes, routes, and components live
- constraints, known risks, and deliberate design decisions
- what was recently changed and what remains unfinished

## Recommended structure

Use `AGENTS_CODE_REFERENCE.md` as the short, high-level map. If it becomes too long, keep the overview in that file and move feature details into files such as:

```text
AGENTS_CODE_REFERENCE.md
AGENTS_CODE_REFERENCE-auth.md
AGENTS_CODE_REFERENCE-api.md
AGENTS_CODE_REFERENCE-ui.md
```

Use stable location cues such as function names, class names, headings, or approximate areas of a file. Avoid relying only on exact line numbers because they shift as code changes.

The source code remains authoritative. A receiving AI should use the references for orientation, then inspect the relevant implementation before making changes. If a reference conflicts with the code, update the reference after verifying the current behavior.

## Keep the references current

Update the relevant code-reference file after completing a feature, architectural change, or substantial refactor. A stale reference can make a handoff worse by giving the new AI confident but outdated assumptions.

Commit these files with the codebase so every local IDE, cloud coding agent, command-line agent, and collaborator receives the same context.

## Handoff prompt for the next AI platform

```text
You are continuing work on an existing codebase from another AI coding platform.

First read AGENTS_CODE_REFERENCE.md and any relevant AGENTS_CODE_REFERENCE-*.md files for a high-level map of the project. Treat the source code as authoritative and verify the files related to this task before editing them.

Current status:
- Completed: {completed work}
- Current objective: {objective}
- Next step: {next step}
- Known issue or constraint: {constraint}

After completing the work, update the relevant AGENTS_CODE_REFERENCE*.md files so they accurately describe the new state of the codebase for the next AI handoff.
```

## Why this works across platforms

Chat history, memory features, and proprietary project context differ between AI products. Plain Markdown stored beside the code is portable. Any platform that can read the repository can consume the same map, whether the interface is a cloud agent, an IDE such as Cursor, or a CLI such as Codex or Claude Code.

The code references preserve **what the codebase is and how it currently works**. Keep behavioral instructions for the AI itself in `AGENTS.md`; the two files serve complementary purposes.
