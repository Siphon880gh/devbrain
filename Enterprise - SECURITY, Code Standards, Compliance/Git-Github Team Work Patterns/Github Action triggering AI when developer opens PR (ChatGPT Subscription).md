**Uses:** Automated AI Code Reviews, Security Reviews, CI Follow-up, and Repository Automation

GitHub can automatically trigger Codex when repository activity occurs—for example, when a developer opens a pull request.

With the **ChatGPT subscription approach**, Codex Cloud connects directly to your GitHub repository. When a PR is opened, Codex can automatically review the change, identify serious bugs or security problems, and post its findings directly to GitHub.

This uses the Codex usage included with your ChatGPT plan rather than an `OPENAI_API_KEY`. Codex is included with ChatGPT plans, with usage limits depending on your plan. After included usage is exhausted, eligible plans can purchase additional Codex credits.

You can monitor this under:

```text
ChatGPT
→ Codex
→ Settings
→ Usage
```

[Open Codex Usage Dashboard](https://chatgpt.com/codex/cloud/settings/analytics?utm_source=chatgpt.com#usage)

The architecture is:

```text
Developer opens PR
        ↓
GitHub
        ↓
Codex GitHub integration
        ↓
Codex Cloud
        ↓
ChatGPT Codex allowance / credits
        ↓
AI reviews the PR
        ↓
Review posted to GitHub
```

There is no OpenAI API key involved.

---

# Important: This Is Not `openai/codex-action@v1`

It is easy to confuse the two systems.

The ChatGPT-subscription approach uses:

```text
GitHub PR event
        ↓
Codex Cloud GitHub integration
        ↓
ChatGPT account
        ↓
Codex
```

It does **not** use:

```yaml
uses: openai/codex-action@v1
```

and you do not need:

```text
OPENAI_API_KEY
```

or:

```text
.github/workflows/codex-review.yml
```

for Codex's native automatic PR-review feature.

As of August 23, 2026, the released `openai/codex-action@v1` still requires an API/provider key. OpenAI is working on ChatGPT access-token authentication for the Action, but that support currently exists only in a draft pull request and is not part of the released `v1` action.

---

# Step 1: Connect GitHub to Codex Cloud

First, make sure the repository is available to Codex Cloud.

Open Codex and connect your GitHub account.

Then give Codex access to the repository you want it to review.

Conceptually:

```text
ChatGPT account
        ↓
Codex
        ↓
GitHub account
        ↓
Repository
```

OpenAI requires Codex Cloud to be configured for the repository before GitHub code review can be used.

---

# Step 2: Enable Code Review

Open:

```text
ChatGPT
→ Codex
→ Settings
→ Code review
```

Select the repository.

Then enable:

```text
Code review
```

For automatic PR reviews, enable:

```text
Automatic reviews
```

when that option is available for the repository.

OpenAI's documented setup is essentially:

```text
1. Set up Codex Cloud.

2. Connect GitHub.

3. Give Codex access to the repository.

4. Open Codex Settings.

5. Open Code review.

6. Enable Code review.

7. Enable Automatic reviews.
```

You need appropriate GitHub push or administrative permission to configure automatic reviews.

Once enabled:

```text
Developer opens PR
        ↓
Codex automatically starts review
        ↓
Codex examines PR changes
        ↓
Codex posts GitHub review
```

You do not need someone to manually launch Codex first.

OpenAI specifically says Automatic reviews can cause Codex to review a PR when it is opened for review without requiring an `@codex review` comment.

---

# Step 3: Add `AGENTS.md`

This is where you make the review useful for **your specific application**.

Create:

```text
AGENTS.md
```

in the root of the repository.

For example:

```markdown
# Project Instructions

## Code Review Rules

### Security

- Flag authentication bypasses.
- Verify authorization separately from authentication.
- Flag SQL injection, command injection, path traversal, SSRF,
  XSS, insecure deserialization, and exposed credentials.
- Never allow secrets, access tokens, API keys, passwords,
  or session identifiers to be written to logs.

### API

- Flag backwards-incompatible changes to public API responses.
- Existing API fields must not silently change type.
- New authenticated endpoints must enforce both authentication
  and authorization.

### Database

- Flag destructive migrations that can cause data loss.
- Flag migrations that lock large production tables unnecessarily.
- New database queries should avoid obvious N+1 query patterns.

### Error Handling

- Do not expose internal stack traces to users.
- Network and database failures should have explicit error handling.
- Security-sensitive failures should fail closed rather than fail open.

### Tests

- Behavior changes should include appropriate tests.
- Bug fixes should include a regression test when practical.
- Authentication and authorization changes require negative tests.

### Scope

- Focus on consequential bugs, regressions, security issues,
  and architectural problems.
- Do not report formatting issues that should be handled by linting.
```

Codex automatically looks for applicable `AGENTS.md` files and uses the `## Code Review Rules` section when reviewing code. OpenAI recommends keeping deterministic checks such as formatting and linting in conventional CI rather than asking Codex to review them.

Your repository could therefore look like:

```text
my-project/
│
├── AGENTS.md
├── package.json
├── src/
├── tests/
└── .github/
```

---

# Add More Specific Rules for Sensitive Code

You can also put another `AGENTS.md` deeper in the repository.

For example:

```text
my-project/
│
├── AGENTS.md
│
├── src/
│
├── services/
│   │
│   ├── payments/
│   │   ├── AGENTS.md
│   │   └── ...
│   │
│   └── authentication/
│       ├── AGENTS.md
│       └── ...
```

Then:

```markdown
# Payment Service Instructions

## Code Review Rules

### Money

- All monetary values must use integer cents or Decimal.
- Never use floating-point arithmetic for balances or charges.
- Flag any code path capable of charging a customer twice.

### Stripe

- Webhook signatures must always be verified.
- Webhook processing must be idempotent.
- Do not trust price or product information submitted by the browser.

### Authorization

- A user must never be able to access another customer's
  billing information by changing an ID.
```

Codex applies the repository-wide instructions plus more-specific instructions located closer to changed files.

This is much more useful than simply telling an AI:

```text
Review my code.
```

because the repository itself teaches Codex what matters.

---

# Step 4: Test the Integration Manually

Before relying entirely on automatic reviews, open a test pull request.

Then add this comment:

```text
@codex review
```

Codex should react to the comment and post a normal GitHub review.

OpenAI says GitHub code review focuses on serious findings, particularly P0 and P1 issues, rather than filling the PR with low-value style comments.

You can also give Codex a one-time focus:

```text
@codex review for security vulnerabilities
```

or:

```text
@codex review for issues in the database migration
```

or:

```text
@codex review this authentication change carefully
```

This is useful even when automatic reviews are enabled.

---

# Step 5: Enable Automatic Reviews

Once manual review works, enable:

```text
Automatic reviews
```

in:

```text
Codex
→ Settings
→ Code review
```

Now your workflow becomes:

```text
Developer
   │
   │ opens PR
   ▼
GitHub
   │
   ├───────────────────────┐
   │                       │
   ▼                       ▼
Normal CI               Codex Cloud
   │                       │
   │                       ▼
tests                  AI code review
lint                      │
build                     ▼
typecheck            GitHub review
   │
   └──────────┬────────────┘
              ▼
        Human reviewer
              ▼
            Merge
```

This is a useful architecture because **deterministic checks remain deterministic** while Codex handles problems that require reasoning.

---

# Step 6: Keep Normal CI in GitHub Actions

Using the ChatGPT-subscription version of Codex does not mean you should remove normal GitHub Actions.

For example, create:

```text
.github/workflows/ci.yml
```

with:

```yaml
name: CI

on:
  pull_request:
    branches:
      - main

permissions:
  contents: read

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout repository
        uses: actions/checkout@v5

      - name: Set up Node.js
        uses: actions/setup-node@v4
        with:
          node-version: 22
          cache: npm

      - name: Install dependencies
        run: npm ci

      - name: Lint
        run: npm run lint

      - name: Type check
        run: npm run typecheck

      - name: Run tests
        run: npm test

      - name: Build
        run: npm run build
```

Now two independent systems inspect every PR.

GitHub Actions handles:

```text
npm ci
npm run lint
npm run typecheck
npm test
npm run build
```

while Codex handles things such as:

```text
logic bugs
security vulnerabilities
incorrect assumptions
authorization problems
dangerous migrations
race conditions
backwards compatibility
missing edge cases
architectural regressions
```

This separation is preferable to asking an LLM to replace tests or static analysis.

---

# Step 7: Ask Codex to Fix Failed CI

Suppose GitHub Actions runs:

```text
npm test
```

and the PR fails.

Instead of starting a completely new Codex conversation, comment on the PR:

```text
@codex fix the CI failures
```

Codex can start a cloud coding task with the pull request as context.

The workflow becomes:

```text
Developer opens PR
        ↓
GitHub Actions runs
        ↓
Tests fail
        ↓
Comment:

@codex fix the CI failures
        ↓
Codex Cloud
        ↓
Investigates repository + PR
        ↓
Makes fix
        ↓
Pushes changes when permitted
        ↓
GitHub Actions runs again
```

This is one of the more useful combinations of normal CI and an AI coding agent.

---

# Step 8: Ask Codex to Fix Its Own Review Finding

Suppose Codex posts:

```text
[P1] Authorization check can be bypassed
```

You can respond:

```text
@codex fix the P1 issue
```

OpenAI documents this as a supported workflow. Codex starts a cloud task with the PR context and can push a fix back to the branch when it has permission.

So a full cycle might be:

```text
PR opened
    ↓
Codex reviews
    ↓
Codex identifies P1
    ↓
Human checks finding
    ↓
@codex fix the P1 issue
    ↓
Codex changes code
    ↓
CI runs
    ↓
Human reviews
    ↓
Merge
```

---

# Security Review

Codex also has a more security-focused review mode.

You can manually request it with:

```text
@codex security review
```

Security Review performs deeper security-specific analysis than the normal Codex code review. It is currently documented as a research-preview capability, so availability can depend on your account/workspace.

You can therefore use:

```text
@codex review
```

for ordinary code quality and:

```text
@codex security review
```

for higher-risk changes.

For example:

```text
authentication changes
payment processing
file uploads
webhooks
OAuth
permissions
database access
encryption
secrets management
```

---

# Recommended Repository Structure

A practical repository could therefore contain:

```text
repo/
│
├── AGENTS.md
│
├── src/
│
├── tests/
│
├── services/
│   │
│   └── payments/
│       └── AGENTS.md
│
└── .github/
    │
    └── workflows/
        └── ci.yml
```

Notice what is **not** there:

```text
.github/workflows/codex-review.yml
```

You don't need a Codex workflow file because the AI review is being triggered by **Codex Cloud's GitHub integration**.

The `.github/workflows/ci.yml` file is still useful for your normal CI.

---

# Full Architecture

Your final architecture looks like this:

```text
                    Developer
                        │
                        │ push branch
                        ▼
                     GitHub
                        │
                        │ open PR
                        ▼
                ┌───────────────┐
                │ Pull Request  │
                └───────┬───────┘
                        │
           ┌────────────┴────────────┐
           │                         │
           ▼                         ▼
   GitHub Actions                Codex Cloud
           │                         │
           │                         │
     ┌─────┴──────┐          ChatGPT subscription
     │            │                  │
     ▼            ▼                  ▼
   tests         lint          Review PR diff
   build       typecheck              │
     │            │                   ▼
     └─────┬──────┘            Apply AGENTS.md
           │                         │
           ▼                         ▼
      CI Status                AI Review
           │                         │
           └────────────┬────────────┘
                        ▼
                 Pull Request
                        │
                        ▼
                 Human Review
                        │
                        ▼
                      Merge
```

---

# No OpenAI API Key Is Required

For this Codex Cloud integration, you do not create:

```text
OPENAI_API_KEY
```

and you do not need:

```yaml
openai-api-key: ${{ secrets.OPENAI_API_KEY }}
```

Codex access is associated with the ChatGPT/GitHub integration.

Your Codex usage counts against the applicable ChatGPT Codex/agentic usage allowance and, where supported, additional ChatGPT credits after included usage is consumed.

---

# How This Differs from the GitHub Action + API Key Method

See the separate:

```text
[[Github Action triggering AI when developer opens PR (OpenAI API Key)]]
```

guide if you specifically want **your own GitHub Actions workflow to invoke Codex**.

That architecture is:

```text
GitHub event
        ↓
GitHub Actions runner
        ↓
openai/codex-action@v1
        ↓
OPENAI_API_KEY
        ↓
Codex CLI / codex exec
        ↓
OpenAI API
```

For example:

```text
Developer opens PR
        ↓
.github/workflows/codex-review.yml
        ↓
GitHub runner starts
        ↓
openai/codex-action@v1
        ↓
API request
        ↓
Codex reviews code
        ↓
Workflow processes output
```

The released `openai/codex-action@v1` currently requires an API/provider key.

The difference is therefore:

|Approach|What triggers Codex?|Authentication|Billing / allowance|Codex YAML needed?|
|---|---|---|---|---|
|**Codex Cloud automatic review**|GitHub PR event through Codex integration|ChatGPT + GitHub|ChatGPT Codex usage|**No**|
|**Manual Codex GitHub review**|`@codex review`|ChatGPT + GitHub|ChatGPT Codex usage|**No**|
|**Codex GitHub Action**|GitHub Actions workflow|`OPENAI_API_KEY`|OpenAI API|**Yes**|

So the important distinction is no longer simply:

```text
"You prompt Codex"
vs
"GitHub triggers Codex"
```

because **Codex Cloud can also automatically react to a GitHub PR event**.

The more accurate distinction is:

```text
Codex Cloud native GitHub integration
        ↓
ChatGPT authentication
        ↓
No Codex GitHub Action YAML
```

versus:

```text
Your own GitHub Actions workflow
        ↓
openai/codex-action@v1
        ↓
API authentication
```

---

# Which Approach Should You Use?

Use **Codex Cloud + your ChatGPT subscription** when your main goals are:

```text
Automatically review PRs
Review security-sensitive changes
Ask questions about a PR
Ask Codex to fix findings
Ask Codex to fix CI failures
Have Codex push follow-up changes
```

It requires considerably less infrastructure.

Use **`openai/codex-action@v1` + an API key** when you need Codex to be an actual programmable step inside a custom GitHub Actions pipeline.

For example:

```text
Run tests
    ↓
Run Codex
    ↓
Receive machine-readable output
    ↓
Evaluate result in another Action
    ↓
Run another script
    ↓
Pass/fail workflow
    ↓
Deploy
```

The GitHub Action gives you more control, but uses API authentication under the currently released implementation.

---

# Experimental: ChatGPT Authentication Inside the GitHub Action

OpenAI is actively working on adding **ChatGPT access-token authentication directly to `openai/codex-action`**.

There is currently a draft OpenAI pull request adding:

```yaml
codex-access-token: ${{ secrets.CODEX_ACCESS_TOKEN }}
```

instead of:

```yaml
openai-api-key: ${{ secrets.OPENAI_API_KEY }}
```

The proposed configuration looks like:

```yaml
- name: Run Codex with ChatGPT authentication
  uses: openai/codex-action@v1

  with:
    codex-access-token: ${{ secrets.CODEX_ACCESS_TOKEN }}
    permission-profile: ":workspace"
    prompt: Review the public change.
```

The proposed token is a ChatGPT access token beginning with:

```text
at-...
```

and the implementation routes requests through the ChatGPT Codex backend instead of the Platform Responses API.

However, **do not use the above as normal `@v1` configuration yet**. As of August 23, 2026, that change is still a draft PR and has not been merged into the released Action.

Access-token automation is also currently documented primarily for managed ChatGPT workspaces such as Business and Enterprise, rather than as the general Plus/Pro GitHub Action authentication mechanism.

Once that PR or equivalent functionality ships, it could change the architecture to:

```text
GitHub PR
        ↓
GitHub Actions
        ↓
openai/codex-action
        ↓
CODEX_ACCESS_TOKEN
        ↓
ChatGPT Codex backend
        ↓
ChatGPT workspace credits / limits
```

At that point, this will become a true **GitHub Action + ChatGPT subscription** configuration.

Until then, for ordinary ChatGPT subscription users, the supported no-API-key solution is:

```text
Codex Cloud
+
GitHub integration
+
Automatic reviews
```

---

# TL;DR

If the goal is:

```text
Developer opens PR
        ↓
Codex automatically reviews it
        ↓
Uses ChatGPT Codex allowance
        ↓
No separate API billing
```

use:

```text
Codex Cloud
→ GitHub integration
→ Code review
→ Automatic reviews
```

Then add:

```text
AGENTS.md
```

to tell Codex exactly what your project considers important.

Continue using normal GitHub Actions for:

```text
tests
lint
type checking
builds
deterministic security scanners
deployment checks
```

and let Codex handle the reasoning-heavy review layer.

That gives you:

```text
GitHub Actions = deterministic CI
Codex Cloud     = AI review / agent work
```

using your existing ChatGPT Codex usage rather than an `OPENAI_API_KEY`.