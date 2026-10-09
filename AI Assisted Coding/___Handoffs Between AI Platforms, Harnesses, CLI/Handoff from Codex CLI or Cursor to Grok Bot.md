Handing a local codebase from Codex CLI or Cursor to Grok Bot should be simple because Grok Bot only needs to be pointed to the same local project files.

Start the Grok Bot setup with:

```text
You will be my coding assistant. Let's point the codebase path to {/Users/ or C:// path}
```

Replace the placeholder with the full path to the project folder on the computer.

## Choose where Grok Bot implements changes

After connecting the codebase, indicate whether Grok Bot should implement changes in the cloud or directly in the local files.

### Cloud implementation—the default

By default, changes live in the cloud. Grok Bot provides a pull request on GitHub.com that must be reviewed and merged.

If local development continues afterward, pull the merged changes from GitHub into the local repository before doing more work locally. This prevents the local copy and the GitHub repository from drifting apart.

### Local implementation

To have Grok Bot edit the local files instead, finish its setup with this prompt:

```text
Update system instructions for this bot:
All changes are done locally instead of living in the cloud
After every implementation, show me files changed, how many lines, and offer git diff. Do not push to online Github and create PR - I rather do that myself.
```

This keeps implementation on the computer. Review the reported files and optionally request `git diff` before committing or pushing the changes to GitHub yourself.

## Before the handoff

- Save all changes made in Cursor.
- Confirm that Codex CLI or Cursor and Grok Bot are pointed at the same project folder.
- Check `git status` so the receiving bot can distinguish existing work from its own changes.
- Tell Grok Bot what has already been completed, what it should do next, and which constraints it must preserve.
- Avoid editing the same files simultaneously in multiple tools.

The source files preserve the implementation progress, but chat context does not automatically transfer. A short written status update helps Grok Bot continue from the correct point.
