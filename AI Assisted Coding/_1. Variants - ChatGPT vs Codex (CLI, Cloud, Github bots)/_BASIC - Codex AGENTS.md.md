### 1. How to Configure It

`AGENTS.md` is a Markdown file that Codex reads automatically before executing commands or generating code.

- **Project-Level (Team/Repo):** Place an `AGENTS.md` file in your repository root or specific subdirectories. Codex crawls from the repo root down to the working directory.
- **Global-Level (Personal):** Place it in `~/.codex/AGENTS.md` to apply user-wide defaults across all repositories.
- **Local Overrides:** If you need personal or machine-specific rules in a repository without modifying the shared team file, Codex looks for `AGENTS.override.md` first; if present in a folder, it takes precedence over `AGENTS.md`.

### 2. What You Can Do With It

It serves as an operational runbook and working agreement for the agent:

- **Enforce Workflows:** Define standard commands (e.g., _"Always run `pnpm test` after modifying TypeScript files"_, _"Use `uv` instead of standard `pip`"_).
- **Code Style & Architecture:** Outline preferred patterns, formatting rules, library choices, and directory conventions.
- **Guardrails & Boundaries:** Specify files or folders Codex should never edit directly (e.g., `.env`, migration files, lockfiles), or require confirmation before adding external dependencies.
- **Context & Domain Logic:** Explain non-obvious architecture, environment prerequisites, and API usage patterns so Codex doesn't hallucinate conventions.

### 3. How It Interacts With System Instructions

#### Context Precedence & Hierarchy

Codex layers instructions in this order:

1. **Built-in System Prompt / Tool Protocol** (Base agent instructions and safety limits)
2. **Global Rules** (`~/.codex/AGENTS.md`)
3. **Project Rules** (`AGENTS.md` or `AGENTS.override.md` from root down to subdirectories)
4. **Active User Session Prompts** (Your current conversation turn)

#### What It **Can** Override:

- **Default coding patterns and assumptions:** It overrides Codex's out-of-the-box defaults for package managers, formatting styles, test frameworks, and file handling.
- **Broader parent rules:** A subdirectory `AGENTS.md` overrides conflicting guidelines set in parent directories or your global `~/.codex/AGENTS.md`.
- **Direct sibling files:** An `AGENTS.override.md` directly suppresses and replaces `AGENTS.md` in the same directory.

#### What It **Cannot** Override:

- **Core Safety & Model Boundaries:** It cannot bypass OpenAI/Codex safety filters, privacy policies, or ethical constraints.
- **Tool & Sandbox Capabilities:** It cannot grant the model system capabilities or permissions outside what the CLI/app environment supports (e.g., modifying read-only sandbox boundaries or network access rules).
- **Base Protocol / App Invariants:** It injects developer guidance into the prompt context rather than replacing the underlying platform system prompt that dictates how Codex parses tool calls and operates its runtime.