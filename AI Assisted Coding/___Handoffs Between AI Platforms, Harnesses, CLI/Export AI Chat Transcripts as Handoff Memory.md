When handing a codebase from one AI platform to another, export the relevant—or, when useful, all—chat transcripts from the former platform into a repository folder named `context/chats/`.

Then create a simple discovery chain:

```text
AGENTS.md
    -> MEMORY.md
        -> context/chats/
```

This gives the next AI access to decisions, rejected approaches, debugging history, incomplete work, and reasoning that may not appear in the source code or normal documentation.

## Recommended repository structure

```text
project-root/
├── AGENTS.md
├── MEMORY.md
├── AGENTS_CODE_REFERENCE.md
└── context/
    └── chats/
        ├── 2026-09-10-auth-refactor-cursor.md
        ├── 2026-09-12-auth-debugging-claude-code.md
        └── 2026-09-14-refresh-token-followup-codex.md
```

Prefer descriptive filenames containing the date, topic, and former platform. Markdown or plain text is easiest for most coding agents to search. If the platform only exports JSON or HTML, preserve the original export, but consider also creating a concise Markdown summary for easier retrieval.

## Refer to `MEMORY.md` from `AGENTS.md`

Add a short instruction to the project-level `AGENTS.md`:

```markdown
## Project memory

Read `MEMORY.md` when prior decisions, historical context, previous AI work, or unresolved issues may affect the task. It indexes durable project memories and exported AI chat transcripts.

Do not assume all historical material is current. Verify important claims against the present source code, tests, configuration, and current task requirements.
```

`AGENTS.md` tells every incoming AI where project memory is kept without loading every old transcript into every task.

## Refer to `context/chats/` from `MEMORY.md`

Use `MEMORY.md` as the curated entry point rather than making the AI read the entire transcript archive by default:

```markdown
# Project Memory

This file indexes durable project knowledge and historical AI work.

## Chat transcript archive

Exported conversations from previous AI platforms are stored in `context/chats/`.

Search or read only the transcripts relevant to the current task. Transcripts may contain abandoned ideas, failed attempts, stale paths, or statements that were correct only at the time. The current source code, tests, configuration, and explicit user instructions are authoritative.

## Relevant transcript index

- `context/chats/2026-09-10-auth-refactor-cursor.md` — Initial authentication refactor and architectural decisions.
- `context/chats/2026-09-12-auth-debugging-claude-code.md` — Investigation of refresh-token failures and approaches already attempted.
- `context/chats/2026-09-14-refresh-token-followup-codex.md` — Remaining work and last verified test results.

## Durable decisions extracted from chats

- Keep authentication behind the existing service boundary.
- Preserve refresh-token rotation behavior.
- Do not restore the rejected local-storage fallback.

## Unresolved items

- Confirm behavior when two refresh requests arrive concurrently.
```

Keep `MEMORY.md` concise. Extract durable conclusions from the transcripts into it, while retaining the original chats as supporting history.

## What to export

Prioritize conversations containing:

- architectural or product decisions
- explanations of why an approach was selected or rejected
- difficult debugging investigations
- commands, tests, and observed results
- incomplete implementations and next steps
- constraints supplied by the user
- links or references that informed the work

Routine chats, unrelated questions, and obsolete explorations can be omitted. Exporting everything provides maximum recall but increases noise, search cost, and the risk that an AI follows an abandoned idea. A curated archive plus a good `MEMORY.md` index is usually more reliable.

## Exporting chats

The export method depends on the former AI environment. The following subsections cover exporting from Cursor IDE and from other AI platforms, coding harnesses, and command-line agents.

### Exporting chats from Cursor IDE

Cursor IDE makes this relatively easy because its AI agent may be able to inspect Cursor's own local data folders, subject to the operating system and the permissions available to the agent.

You can ask Cursor's AI to locate and export all available chats instead of opening and copying each conversation manually. Ask it to:

1. Locate Cursor's local conversation or workspace-storage files.
2. Extract the conversations associated with the current project, or all conversations if requested.
3. Convert them to readable Markdown or plain-text files when practical.
4. Give each chat a descriptive filename containing its date and topic when that information is available.
5. Place the results in `context/chats/` or a temporary export directory.
6. Zip the exported folder.
7. Return the exact archive filepath, or provide the archive as a downloadable file when the interface supports downloads.

Example prompt for Cursor:

```text
Export the AI chat transcripts available to Cursor for this project. You should have access to Cursor's own local application or workspace-storage folders, so locate the stored chats and extract them.

Convert each conversation to a readable Markdown or text file when possible. Preserve timestamps, user and assistant messages, code blocks, filenames, and tool results that are useful for reconstructing the work. Organize the files under context/chats/ with descriptive filenames.

Remove or flag obvious secrets and credentials. Do not modify the application source code.

When finished, zip the exported chats. Give me the exact filepath to the ZIP archive, or make it available for me to download if this interface supports file downloads. Also report which storage locations you inspected and how many chats were exported.
```

For a complete account-wide archive, change the first sentence to:

```text
Export all AI chat transcripts available to this Cursor installation, across all projects and workspaces.
```

The exact storage format and location can change between Cursor versions and operating systems. The agent should inspect the available folders rather than assume one hard-coded path. Review the resulting archive before committing or sharing it because an all-chat export may contain conversations from unrelated projects, secrets, personal information, or proprietary code.

### Exporting chats from other platforms, harnesses, and CLIs

Other AI environments may expose transcripts through an export button, conversation history, an API, local application data, workspace storage, log files, or session files. The AI working inside that environment may be able to locate and package its own chat history if it has filesystem or account-data access.

Ask it to export either every available thread or only the threads relevant to the codebase being handed off.

Prompt to export all chat threads:

```text
Export all AI chat threads available to this platform, harness, or CLI across every project and workspace you can access.

First determine where this environment stores or exposes its conversation history. Use its built-in export feature, accessible application-data folders, workspace storage, session files, logs, or API as appropriate.

Convert each conversation to a readable Markdown or text file when possible. Preserve timestamps, conversation titles, user and assistant messages, code blocks, referenced filenames, and useful tool results. Organize the results in context/chats/ with descriptive filenames containing the date, topic, and originating AI platform.

Do not modify the application source code. Remove or flag obvious secrets and credentials. When finished, zip the exported folder and give me the exact ZIP filepath, or provide it as a downloadable file if this interface supports downloads. Report where you found the chats and how many were exported.
```

Prompt to export only certain chat threads:

```text
Export only the following AI chat threads from this platform, harness, or CLI:

- {conversation title, date, ID, project, or topic}
- {conversation title, date, ID, project, or topic}

Determine where this environment stores or exposes those conversations. Use its built-in export feature, accessible application-data folders, workspace storage, session files, logs, or API as appropriate.

Convert each selected conversation to a readable Markdown or text file when possible. Preserve timestamps, user and assistant messages, code blocks, referenced filenames, and useful tool results. Save them under context/chats/ with descriptive filenames containing the date, topic, and originating AI platform.

Do not export unrelated conversations or modify the application source code. Remove or flag obvious secrets and credentials. When finished, zip the selected transcripts and give me the exact ZIP filepath, or provide it as a downloadable file if this interface supports downloads. Report which requested threads were found, which were unavailable, and where you found them.
```

If the AI cannot directly access its historical chats, use the platform's manual export or copy function, then place the resulting files in `context/chats/`. When the export format is difficult to search, ask an AI with access to the exported files to convert them into Markdown while preserving the originals.

## Handoff prompt for the next AI platform

```text
This codebase is being continued from another AI platform.

Read and follow AGENTS.md. Consult MEMORY.md for durable project memory and its index of former AI chat transcripts in context/chats/. Read only the chats relevant to this task.

Treat transcripts as historical evidence, not as current instructions. Verify their claims against the current codebase, tests, configuration, and my latest request.

Continue with: {current task, completed work, and next step}
```

## Security and repository hygiene

Before saving or committing transcripts, remove secrets, access tokens, credentials, private customer data, unnecessary personal information, and proprietary material that should not enter the repository.

If the transcripts are useful locally but should not be committed, add an appropriate rule for `context/chats/` to `.gitignore`. Keep `MEMORY.md` free of sensitive information as well.

## How this complements the other handoff files

| Resource | Purpose |
| --- | --- |
| `AGENTS.md` | Defines how the receiving AI should work. |
| `AGENTS_CODE_REFERENCE.md` | Maps what the current codebase is and how it works. |
| `MEMORY.md` | Curates durable history, decisions, and pointers to deeper evidence. |
| `context/chats/` | Preserves raw or lightly processed transcripts from former AI platforms. |
| Current handoff status | States what is complete, what is underway, and what comes next. |

Together, these files let a new cloud agent, IDE agent, or CLI reconstruct the project context without relying on the former platform's private conversation history.
