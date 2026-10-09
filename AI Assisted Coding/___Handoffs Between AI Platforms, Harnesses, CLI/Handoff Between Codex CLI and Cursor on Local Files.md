Handoff between Codex CLI and Cursor is simple when both tools are working with files stored locally on the same computer. There is no need to export, upload, or copy the project: both tools can open the same folder and edit the same files.

The main requirement is to point Codex CLI and Cursor at the correct project folder.

See [[_Why Hand Off to Another Platform]] for common reasons to switch tools while continuing the same work.

## Open the folder in Cursor

In Cursor, choose **File → Open Folder**, then select the project folder.

If the Cursor shell command is installed, open the folder from a terminal with:

```bash
cursor "/path/to/project"
```

From inside the project folder, use:

```bash
cursor .
```

## Open the folder in Codex CLI

In a terminal, change to the same project folder and start Codex:

```bash
cd "/path/to/project"
codex
```

The current working directory is the project Codex can inspect and edit. Before starting work, confirm the location with:

```bash
pwd
```

## A simple handoff workflow

1. Save all edited files in the tool currently being used.
2. Open the same project folder in the other tool.
3. Tell the receiving AI what was completed, what remains, and which files matter.
4. Ask it to inspect the current files before continuing.

Example handoff prompt:

```text
Continue this project from the current local files. First inspect the repository and the files related to this task.

Completed: {what was completed}
Next task: {what to do next}
Relevant files: {file paths}
Known issues or constraints: {anything important}
```

## Important details

- Saved changes appear to both Codex CLI and Cursor because they are reading the same files.
- Unsaved changes in Cursor exist only in its editor buffer, so save them before handing work to Codex.
- Avoid asking both tools to edit the same file at the same time; one change could conflict with or overwrite the other.
- Git is useful for checking the shared state. Run `git status` and review the diff before and after a handoff.
- Chat history does not automatically transfer. Store durable instructions and codebase context in repository files such as `AGENTS.md` and `AGENTS_CODE_REFERENCE.md`.

The handoff is therefore mostly a change of interface: Cursor provides an editor-centered workflow, while Codex CLI provides a terminal-centered workflow. The underlying local project remains the same.
