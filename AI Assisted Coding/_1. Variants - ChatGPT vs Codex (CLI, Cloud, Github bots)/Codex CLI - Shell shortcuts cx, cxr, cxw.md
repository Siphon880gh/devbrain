Add these to `~/.zshrc` so Codex is faster to launch. The read-only and workspace-write shortcuts must call the binary with `command`, because `codex` may already be aliased to `codex --approve-for-me`, which cannot be combined with `--sandbox`.

See [[Codex CLI - Approve-for-me cannot combine with --sandbox]].

```zsh
# >>> Codex convenience shortcuts >>>
# Call the binary directly. `codex` may be aliased to `codex --approve-for-me`,
# which cannot be combined with --sandbox.
alias cx='codex'
alias cxr='command codex --sandbox read-only'
alias cxw='command codex --sandbox workspace-write'

cxhelp() {
  cat <<'EOF'
Codex cheat sheet
-----------------
cx "explain this repo and suggest a plan"
cxr "review this diff for bugs and regressions"
cxw "implement <task>; run focused tests; show the diff"

Useful prompts
  - Find the root cause; don't change files yet.
  - Implement this, preserve existing user changes, then verify it.
  - Review the current diff for correctness, security, and missing tests.
  - Start the app; test this flow on desktop and mobile; inspect screenshots.
  - Summarize the code path and name the smallest safe change.
  - Write a test that fails for this bug, then fix it.

In-session
  /status       inspect active model/configuration
  /permissions  inspect or change the active permission profile
  /init         create or update project instructions
EOF
}
# <<< Codex convenience shortcuts <<<
```

Examples:

```
cx "explain this repo and suggest a plan"
cxr "review this diff for bugs and regressions"
cxw "implement <task>; run focused tests; show the diff"
cxhelp
```

Wrap the block in those `>>>` / `<<<` markers and keep it only once. If an older block with the same markers exists, replace that block rather than appending another one. See [[Advanced - Idempotent delimited blocks in zshrc]].
