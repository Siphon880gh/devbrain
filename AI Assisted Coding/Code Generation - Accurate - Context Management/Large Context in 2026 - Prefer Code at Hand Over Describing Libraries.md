## Large context in 2026 — prefer code at hand over describing libraries

By 2026, frontier coding models routinely support **very large context windows** (often hundreds of thousands to millions of tokens, depending on provider and tier). That changes how you should work with **packages, libraries, and unfamiliar code**.

## What changed

| Old habit (2023–2024) | Better habit (2026) |
| --- | --- |
| Paste API docs or describe how you think a library works | Point the model at **real source**, **your repo**, or **installed dependency trees** |
| Summarize behavior from memory or Stack Overflow | Let the model **read** implementations, tests, and call sites |
| Hope the model “knows” `zod`, `react-query`, or an internal SDK | **Fetch or open** the version you actually ship |

Large context does **not** mean you should dump the entire monorepo into every prompt. It means you can rely on **targeted retrieval**—grep, file reads, dependency source, skills—instead of long prose descriptions that drift from reality.

## Why “code at hand” beats describing

When you only *describe* a library:

- You may describe the **wrong version** (APIs change between majors).
- You omit **edge cases** the types do not document.
- The model fills gaps with **plausible but wrong** behavior.

When the model has **code at hand**:

- It can match **your** lockfile version and **your** usage patterns.
- It can read **tests** as executable specification.
- It can trace **internal** helpers, not just public exports.

**Rule of thumb:** If the task depends on *how something is implemented*, not just *what the public API says*, give the model access to code—not a paragraph about the library.

## Where this fits in your stack

- **Your app repo** — IDE agents (e.g. Cursor) index the workspace and expose read/search tools.
- **Third-party dependencies** — Tools like [opensrc](https://github.com/vercel-labs/opensrc) clone npm/PyPI/crates sources into a cache so agents can `rg` and `cat` real implementations.
- **How new features are shaped in your repo** — The [code-structure](https://github.com/michaelshimeles/skills/tree/main/code-structure) skill pushes a **service layer** so the AI does not recreate the same helpers and stays clear when adding features → [[Service Layer - code-structure Skill (Michael Shimeles)]]

See [[Giving More Code Access to AI - Cursor, opensrc, and bash-tool]] for Cursor, opensrc, and bash-tool.

## Still use high-level maps for huge repos

Even with large context, **whole-repo dumps** are wasteful and can cause sloppy edits. For large apps, keep a living map (e.g. `AGENTS_CODE_REFERENCE.md`) so the model knows *where* to look first:

- [[_Context - Ever-updating High-Level Context that Optimizes Token Usage and Lowers Likelihood of Lines disappearing]]

That pattern complements “code at hand”: map for navigation, source for truth.

## Related

- [[Compact Context and New Chat Threads - IDE Comparison]] — `/summarize`, `/compact`, when to start a new chat
- [[Greptile Code Review and greploop]] — automated PR review and iterate-to-5/5 loop
- [[_PRIMER - Accurate Code Generation Context Management (Shortcut)]]
