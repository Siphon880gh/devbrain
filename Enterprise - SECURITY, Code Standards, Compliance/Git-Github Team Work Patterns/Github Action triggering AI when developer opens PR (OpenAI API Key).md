**Uses**: Automated AI Code Reviews, CI Tasks, and Repository Automation

GitHub can launch an AI agent whenever a repository event occurs—for example, when a pull request is opened, new commits are pushed to a PR, or a release workflow runs. That AI agent can run AI-assisted tasks like checking for security vulnerabilities on a new PR. That AI Agent can be Codex

**This approach requires an API key from ChatGPT**. So you have to pay top-up at the API dashboard. If you have a subscription already, it may be cheaper to use the monthly Codex credits (unless you're vibe coding a lot on Codex already). If want to be using the subscription, refer to the other guide at [[Github Action triggering AI when developer opens PR (ChatGPT Subscription)]]

The official action is:

```text
openai/codex-action@v1
```

Under the hood, the action installs Codex CLI, starts a Responses API proxy when an OpenAI API key is supplied, and runs `codex exec` with the permissions and configuration you specify.

In other words, the simplest mental model is:

```text
Codex CLI + GitHub Actions automation
                =
        Codex GitHub Action
```

---

# What Can the Codex GitHub Action Do?

One of the most obvious uses is automatic pull-request review.

The workflow can look like this:

```text
Developer opens or updates PR
          │
          ▼
GitHub Actions starts
          │
          ▼
Repository is checked out
          │
          ▼
openai/codex-action@v1 starts
          │
          ▼
Codex reads the repository and PR state
          │
          ▼
Prompt:
"Review this PR for bugs and security issues"
          │
          ▼
Codex analyzes the code
          │
          ▼
Codex returns its final response
          │
          ▼
GitHub posts it as a PR comment
```

OpenAI specifically describes the action as useful for:

- automatic PR or release feedback
    
- Codex-powered CI quality checks
    
- code review
    
- release preparation
    
- migrations
    
- repeatable repository tasks
    
- applying patches
    

So prompts could be as simple as:

```text
Review this PR for bugs.
```

Or substantially more specific:

```text
Review this pull request.

Look for:
- logic bugs
- security vulnerabilities
- breaking API changes
- regressions
- race conditions
- missing error handling
- unnecessary complexity
- missing tests

Identify the relevant files and explain how each issue
should be corrected.
```

You aren't limited to reviews either. You could create workflows for tasks such as:

```text
"Check whether this release introduces breaking API changes."

"Run the test suite and investigate failures."

"Find deprecated APIs that should be migrated."

"Review database migrations for dangerous operations."

"Inspect this change for security vulnerabilities."

"Prepare the repository for the next framework version."

"Check whether documentation needs updating after this change."
```

---

# Codex GitHub Action vs Codex CLI vs Codex IDE

They are closely related, but what launches Codex is different.

|Tool|Started by|Runs where|
|---|---|---|
|Codex CLI|You|Your computer/server|
|Codex IDE integration|You|Your IDE|
|**Codex GitHub Action**|**GitHub event**|**GitHub Actions runner**|

The GitHub Action is therefore useful when you want Codex to become part of your **CI/CD process** instead of something that only runs when you manually ask it to.

---

# What You Need

A basic setup needs three things:

```text
Your repository
│
├── .github/
│   │
│   ├── workflows/
│   │   └── codex-review.yml
│   │
│   └── codex/
│       └── prompts/
│           └── review.md
│
└── GitHub Actions Secret
    └── OPENAI_API_KEY
```

OpenAI's current prerequisites are:

1. Store an OpenAI API key as a GitHub secret.
    
2. Check out the repository before running Codex.
    
3. Run on Linux or macOS unless you configure the Windows-specific safety behavior.
    
4. Supply either an inline `prompt` or a `prompt-file`.
    

---

# Step 1: Create an OpenAI API Key

You need an OpenAI **API key** for the documented GitHub Action setup.

It will look roughly like:

```text
sk-...
```

Do **not** paste the key directly into your workflow YAML.

For example, do not do this:

```yaml
openai-api-key: sk-abc123...
```

That could expose your API credentials in Git history.

Instead, save the key as a GitHub Actions secret.

---

# Step 2: Add `OPENAI_API_KEY` to GitHub

In your GitHub repository, open:

```text
Repository
→ Settings
→ Secrets and variables
→ Actions
→ New repository secret
```

Create the following secret:

```text
Name:

OPENAI_API_KEY
```

And use your OpenAI API key as the secret value.

Your GitHub workflow can then safely reference it with:

```yaml
${{ secrets.OPENAI_API_KEY }}
```

The Codex action receives it like this:

```yaml
with:
  openai-api-key: ${{ secrets.OPENAI_API_KEY }}
```

OpenAI's documentation explicitly recommends storing the key as a GitHub secret such as `OPENAI_API_KEY`.

---

# Step 3: Create a Codex Review Prompt

Create:

```text
.github/codex/prompts/review.md
```

For example:

```markdown
# Pull Request Review

Review this pull request carefully.

Look for:

- logic bugs
- security vulnerabilities
- incorrect assumptions
- regressions
- breaking changes
- missing error handling
- concurrency issues
- unnecessary complexity
- missing tests

For every significant problem:

1. Identify the relevant file or code.
2. Explain why it is a problem.
3. Explain how it should be corrected.
4. Classify its severity when appropriate.

Avoid commenting on trivial formatting unless it affects correctness
or maintainability.

If you do not find significant problems, clearly say that the pull
request looks good.
```

Keeping the prompt in a separate file makes it much easier to improve your review instructions over time.

OpenAI supports either:

```yaml
prompt-file: .github/codex/prompts/review.md
```

or an inline:

```yaml
prompt: |
  Review this pull request...
```

You should use **one or the other**, not both.

---

# Step 4: Create the GitHub Action

Create:

```text
.github/workflows/codex-review.yml
```

A complete PR review workflow based on OpenAI's documented example looks like this:

```yaml
name: Codex pull request review

on:
  pull_request:
    types:
      - opened
      - synchronize
      - reopened

jobs:
  codex:
    runs-on: ubuntu-latest

    permissions:
      contents: read

    outputs:
      final_message: ${{ steps.run_codex.outputs.final-message }}

    steps:
      - name: Checkout pull request
        uses: actions/checkout@v5
        with:
          ref: refs/pull/${{ github.event.pull_request.number }}/merge
          fetch-depth: 0
          persist-credentials: false

      - name: Run Codex
        id: run_codex
        uses: openai/codex-action@v1
        with:
          openai-api-key: ${{ secrets.OPENAI_API_KEY }}
          prompt-file: .github/codex/prompts/review.md
          output-file: codex-output.md

  post_feedback:
    runs-on: ubuntu-latest

    needs: codex

    if: needs.codex.outputs.final_message != ''

    permissions:
      issues: write
      pull-requests: write

    steps:
      - name: Post Codex feedback
        uses: actions/github-script@v7

        with:
          github-token: ${{ github.token }}

          script: |
            await github.rest.issues.createComment({
              owner: context.repo.owner,
              repo: context.repo.repo,
              issue_number: context.payload.pull_request.number,
              body: process.env.CODEX_FINAL_MESSAGE,
            });

        env:
          CODEX_FINAL_MESSAGE: ${{ needs.codex.outputs.final_message }}
```

This follows the structure of OpenAI's current documented PR review example.

---

# What Each Part of the Workflow Does

## Trigger

This:

```yaml
on:
  pull_request:
    types:
      - opened
      - synchronize
      - reopened
```

means Codex runs when a pull request is:

```text
opened
updated with new commits
reopened
```

So you don't manually launch Codex every time.

---

# Checkout the Repository

This step:

```yaml
- uses: actions/checkout@v5
```

downloads the repository onto the GitHub Actions runner.

The important part is:

```yaml
ref: refs/pull/${{ github.event.pull_request.number }}/merge
```

which lets the workflow inspect the PR's merge state.

And:

```yaml
fetch-depth: 0
```

fetches full Git history rather than only a shallow checkout.

Codex needs the repository checkout because otherwise there would be no local code for it to inspect. OpenAI explicitly lists checking out the repository as a prerequisite.

---

# Run Codex

The core of the workflow is:

```yaml
- name: Run Codex
  id: run_codex
  uses: openai/codex-action@v1
```

This launches the official Codex GitHub Action.

Then:

```yaml
openai-api-key: ${{ secrets.OPENAI_API_KEY }}
```

provides authentication without exposing the actual key in your repository.

And:

```yaml
prompt-file: .github/codex/prompts/review.md
```

tells Codex what task to perform.

Finally:

```yaml
output-file: codex-output.md
```

writes Codex's final message to a file on the GitHub runner.

The action also exposes the final Codex response through an output named:

```text
final-message
```

which is why the workflow can later use:

```yaml
${{ steps.run_codex.outputs.final-message }}
```

---

# Post the Review Back to GitHub

The second job receives the response:

```yaml
needs:
  codex
```

and then uses:

```yaml
actions/github-script@v7
```

to call GitHub's API and create a PR comment.

Conceptually:

```text
Codex
  ↓
final-message
  ↓
GitHub Action
  ↓
GitHub API
  ↓
PR comment
```

The permissions:

```yaml
permissions:
  issues: write
  pull-requests: write
```

give this job permission to post the feedback.

---

# You Can Put the Prompt Directly in the Workflow

A separate prompt file isn't required.

Instead of:

```yaml
prompt-file: .github/codex/prompts/review.md
```

you could use:

```yaml
- name: Run Codex
  id: run_codex
  uses: openai/codex-action@v1

  with:
    openai-api-key: ${{ secrets.OPENAI_API_KEY }}

    prompt: |
      Review this pull request.

      Look for:
      - bugs
      - security problems
      - regressions
      - breaking changes
      - missing tests

      Give specific and actionable recommendations.

    output-file: codex-output.md
```

For small workflows, this is perfectly reasonable.

For larger setups, keeping prompts under something like:

```text
.github/codex/prompts/
```

is cleaner.

OpenAI specifically suggests that directory as a reasonable place for reusable prompt files.

---

# Codex Can Be More Than a Read-Only Reviewer

The Action exposes Codex's sandbox configuration.

Supported sandbox modes documented by OpenAI include:

```text
read-only
workspace-write
danger-full-access
```

These make a substantial difference.

## `read-only`

Codex can inspect the repository but can't modify files through the sandbox.

Good for:

```text
PR reviews
security reviews
architecture reviews
release checks
code explanations
```

For a basic PR reviewer, this is generally the appropriate starting point.

Example:

```yaml
with:
  openai-api-key: ${{ secrets.OPENAI_API_KEY }}
  sandbox: read-only
  prompt-file: .github/codex/prompts/review.md
```

---

# `workspace-write`

This allows Codex to modify repository files inside its permitted workspace.

That opens the door to workflows such as:

```text
Find lint failures
        ↓
Codex fixes files
        ↓
Run tests
        ↓
Generate patch
```

Or:

```text
Framework upgrade
        ↓
Codex changes deprecated APIs
        ↓
Updates tests
        ↓
Creates patch
```

However, allowing an automated AI agent to modify files requires considerably more care than a read-only reviewer.

---

# `danger-full-access`

This gives Codex much broader access.

It should not be the default for ordinary code review.

OpenAI recommends using the narrowest sandbox permissions that still allow the task to complete.

---

# Other Codex GitHub Action Options

The Action can configure more than the prompt.

OpenAI currently documents options including:

```text
prompt
prompt-file
codex-args
model
effort
sandbox
output-file
codex-version
codex-home
```

For example:

```yaml
with:
  openai-api-key: ${{ secrets.OPENAI_API_KEY }}

  prompt-file: .github/codex/prompts/review.md

  sandbox: read-only

  effort: low

  output-file: codex-output.md
```

`model` and `effort` allow you to control the Codex agent configuration, while `codex-args` lets you pass additional `codex exec` options. OpenAI says leaving `model` or `effort` empty uses the applicable defaults.

---

# What Actually Runs Behind the Scenes?

The architecture is approximately:

```text
GitHub Event
     │
     ▼
GitHub Actions Runner
     │
     ├── Checkout repository
     │
     ▼
openai/codex-action@v1
     │
     ├── Install Codex CLI
     │
     ├── Configure security
     │
     ├── Start Responses API proxy
     │       when API key is supplied
     │
     └── Execute:
             codex exec
                 │
                 ▼
             Your prompt
                 │
                 ▼
             Repository
                 │
                 ▼
             Codex reasoning
                 │
                 ▼
             final-message
                 │
                 ▼
          Additional GitHub steps
```

So the GitHub Action isn't a completely different Codex implementation.

It is essentially a convenient GitHub-native way of running **Codex CLI non-interactively in CI/CD**.

---

# Important: `OPENAI_API_KEY` Means API Billing

This is one of the most important things to understand.

The documented GitHub Action configuration uses:

```yaml
openai-api-key: ${{ secrets.OPENAI_API_KEY }}
```

That is an **OpenAI API credential**.

API billing and normal ChatGPT subscription billing are separate systems. OpenAI's current Plus documentation specifically states that API usage is separate and billed independently, and OpenAI's billing documentation likewise distinguishes ChatGPT billing from API Platform billing.

So conceptually:

```text
Codex using your ChatGPT account
             │
             ▼
ChatGPT plan / Codex allowance
and eligible ChatGPT Codex credits
```

is different from:

```text
Codex GitHub Action
+
OPENAI_API_KEY
             │
             ▼
OpenAI API Platform
             │
             ▼
API usage
API rate limits
API billing
```

This distinction matters.

Having ChatGPT Plus does **not** mean arbitrary API usage is included in the $20/month subscription. OpenAI states that API usage is separately billed.

Likewise, ChatGPT Codex credits are not the same thing as API credits. OpenAI currently describes ChatGPT credits as an add-on for supported ChatGPT features such as Codex after included plan usage is exhausted.

Therefore, if you have:

```text
ChatGPT Plus
+
$20 of API credit
```

you effectively have two separate pools/systems:

```text
ChatGPT Plus Codex usage
```

and:

```text
OpenAI API usage
```

The GitHub Action configuration discussed in this guide uses the **API side**.

---

# Why This Is Useful

Without the Action:

```text
PR created
   ↓
You notice PR
   ↓
Open terminal
   ↓
Start Codex
   ↓
Ask Codex to review it
   ↓
Read answer
```

With GitHub Actions:

```text
PR created
   ↓
GitHub automatically starts workflow
   ↓
Codex automatically reviews PR
   ↓
Review appears in GitHub
```

That makes Codex part of your development infrastructure rather than just an interactive coding assistant.

---

# Example: Use Codex as a Required Quality Gate

You could take the idea further.

For example:

```text
Developer pushes code
        ↓
Unit tests
        ↓
Type checking
        ↓
Lint
        ↓
Codex review
        ↓
Security check
        ↓
Merge
```

OpenAI specifically lists using Codex to **gate changes on Codex-driven quality checks** as a GitHub Action use case.

You could prompt it with something like:

```text
Determine whether this pull request is safe to merge.

Check for:

- obvious logic errors
- security vulnerabilities
- authentication mistakes
- authorization mistakes
- destructive database operations
- backwards-incompatible API changes
- missing tests for critical behavior

End the response with exactly one of:

PASS
FAIL
```

Then another GitHub Actions step could parse the structured result and decide whether the CI job should succeed.

For more reliable machine-readable workflows, OpenAI also supports passing an output schema through `codex-args`.

---

# Example: Automatic Codex Fixes

You could eventually create a separate workflow using:

```yaml
sandbox: workspace-write
```

and tell Codex something such as:

```text
Run the test suite.

Investigate any failures caused by the current changes.

Fix the underlying problem.

Do not alter tests simply to make failing behavior pass.

After making changes, rerun the relevant tests.
```

This changes the architecture from:

```text
Codex finds problem
      ↓
Human fixes problem
```

to:

```text
Codex finds problem
      ↓
Codex edits workspace
      ↓
Codex validates fix
      ↓
Patch can be inspected
      ↓
Human reviews it
```

For automated write workflows, Git and GitHub permissions should be deliberately restricted rather than simply giving Codex maximum access.

---

# Security Considerations

Putting an AI coding agent inside CI deserves the same security thinking as any other privileged automation.

OpenAI's current recommendations include:

- restrict who can trigger Codex workflows
    
- prefer trusted GitHub events or explicit approvals
    
- sanitize untrusted content inserted into prompts
    
- watch for prompt injection in PR descriptions, commit messages, issue bodies, and hidden HTML
    
- protect `OPENAI_API_KEY`
    
- use the default safer privilege strategy instead of `unsafe` where possible
    
- give Codex the narrowest sandbox permissions it needs
    
- rotate your API key immediately if you believe it may have been exposed
    

OpenAI's action defaults to a `drop-sudo` safety strategy on supported runners, which removes `sudo` before Codex executes.

A sensible PR reviewer therefore looks more like:

```text
contents: read
+
sandbox: read-only
+
OPENAI_API_KEY stored as secret
+
trusted triggers
```

rather than:

```text
write everything
+
danger-full-access
+
untrusted triggers
```

---

# Common Problems

## `OPENAI_API_KEY` isn't available

Check:

```text
Repository
→ Settings
→ Secrets and variables
→ Actions
```

Make sure the secret is named exactly:

```text
OPENAI_API_KEY
```

And that your YAML references:

```yaml
${{ secrets.OPENAI_API_KEY }}
```

OpenAI notes that the Responses API proxy only starts when `openai-api-key` is actually supplied.

---

# Both `prompt` and `prompt-file` Are Set

Don't do:

```yaml
prompt: |
  Review this PR

prompt-file: .github/codex/prompts/review.md
```

Choose one.

OpenAI lists supplying both as a configuration error.

---

# Codex Can't Modify Files

If you're intentionally asking Codex to edit code while using:

```yaml
sandbox: read-only
```

then the restriction is doing its job.

For an editing workflow you would normally need something like:

```yaml
sandbox: workspace-write
```

along with appropriate filesystem and GitHub permissions.

---

# A Good Starting Configuration

For your first Codex workflow, keep it simple:

```text
Trigger:
PR opened or updated

Repository permission:
read

Codex sandbox:
read-only

Prompt:
review.md

Output:
PR comment
```

In other words:

```text
                        ┌──────────────────┐
                        │  Pull Request    │
                        └────────┬─────────┘
                                 │
                                 ▼
                        ┌──────────────────┐
                        │ GitHub Actions   │
                        └────────┬─────────┘
                                 │
                                 ▼
                        ┌──────────────────┐
                        │ Checkout Repo    │
                        └────────┬─────────┘
                                 │
                                 ▼
                    ┌──────────────────────────┐
                    │ openai/codex-action@v1  │
                    └────────────┬─────────────┘
                                 │
                       OPENAI_API_KEY
                                 │
                                 ▼
                        ┌──────────────────┐
                        │   Codex CLI      │
                        │   codex exec     │
                        └────────┬─────────┘
                                 │
                                 ▼
                        ┌──────────────────┐
                        │ Analyze PR       │
                        └────────┬─────────┘
                                 │
                                 ▼
                        ┌──────────────────┐
                        │ final-message    │
                        └────────┬─────────┘
                                 │
                                 ▼
                        ┌──────────────────┐
                        │ PR Comment       │
                        └──────────────────┘
```

Once that works reliably, you can experiment with more powerful workflows.

---

# Where Codex GitHub Actions Fit

Codex now gives you several ways of using essentially the same coding agent concept:

```text
Interactive development
        │
        ├── Codex CLI
        └── Codex IDE
```

versus:

```text
Automated development
        │
        └── Codex GitHub Action
```

The GitHub Action is particularly useful for tasks that should happen **every time some predictable GitHub event occurs**.

For example:

```text
Every PR → code review

Every release → release audit

Every dependency upgrade → compatibility review

Every database migration → migration review

Every security-sensitive PR → security analysis
```

You define the trigger, permissions, and prompt once, and GitHub repeatedly runs the same Codex task.

---

# TL;DR

The Codex GitHub Action lets GitHub automatically run Codex against your repository.

The core piece is:

```yaml
uses: openai/codex-action@v1
```

You authenticate it with an OpenAI API key stored securely as:

```text
OPENAI_API_KEY
```

and reference it as:

```yaml
openai-api-key: ${{ secrets.OPENAI_API_KEY }}
```

Then give Codex either:

```yaml
prompt: |
  Review this PR...
```

or:

```yaml
prompt-file: .github/codex/prompts/review.md
```

A typical setup becomes:

```text
PR opened
   ↓
GitHub Action
   ↓
Checkout repository
   ↓
Codex GitHub Action
   ↓
OPENAI_API_KEY
   ↓
codex exec
   ↓
Review code
   ↓
final-message
   ↓
Post review to PR
```

And because this documented setup authenticates using an **OpenAI API key**, its API usage and billing are separate from your normal ChatGPT Plus subscription usage.

For most repositories, the safest first implementation is:

```text
Automatic Codex PR review
+
read-only sandbox
+
minimal GitHub permissions
+
OPENAI_API_KEY stored as a GitHub secret
```

Once that works, the same system can be expanded into automatic fixes, migration work, release checks, structured CI gates, and other repeatable Codex-powered repository automation.