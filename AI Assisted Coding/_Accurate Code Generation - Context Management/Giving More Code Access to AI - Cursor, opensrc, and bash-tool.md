These tools address one problem: **get accurate context from real code** instead of asking the model to guess from descriptions or web searches.

---

## Cursor (IDE)

**What it is:** An AI-native IDE that keeps your **workspace** in scope for the agent.

**How it works (conceptually):**

- The project is on disk; the agent uses **tools** (read file, grep, semantic search, terminal, etc.) to pull only what the task needs.
- You can **@-reference** files, folders, docs, and rules so the model starts from the right surface.
- **Skills** (`.cursor/skills`, `SKILL.md`) add procedural knowledge without stuffing the whole repo into the system prompt. You can ask AI to use a particular skill or invoke it with a command like `/command` inside the prompt.

**Best for:** Day-to-day edits in *your* repository, refactors, and features where call sites and project conventions matter.

**Not a substitute for:** Dependencies that live **outside** the workspace tree (system/site installs, CDN `script src`, etc.)—use opensrc for those; see below.

---

## opensrc (Vercel) — fetch source **outside your repo**

- Repo: https://github.com/vercel-labs/opensrc  
- **Agent skill:** `skills/opensrc/SKILL.md` — fetch and **view** third-party implementation source (not just types/docs).

**What it does:** Clones and caches package **repositories** (npm, PyPI, crates.io, GitHub) at the version your project uses, under `~/.opensrc/` (override with `OPENSRC_HOME`). Gives the agent a stable path to **full upstream source**, not whatever happened to land in your tree.

![[Pasted image 20260527230417.png]]

### Your codebase might already be enough — if packages, libraries, etc are local

| In your workspace | Cursor can… |
| --- | --- |
| **`node_modules/`** (committed or present locally) | `grep` / read files like any project path |
| **Your app code**, vendored copies, monorepo packages | Same — already in context |
| **Lockfiles** (`package-lock.json`, etc.) | Read versions; may still need opensrc if `node_modules` only has `dist/` |

If the dependency is **on disk inside the project** and readable (including most of `node_modules`), start with Cursor. You do **not** need opensrc just because the import comes from npm.

**Caveats where opensrc still helps even with `node_modules`:**

- The published tarball is **`dist/` only** (minified, no `src/`) — opensrc pulls the real repo.
- **`node_modules` is gitignored** and trimmed from agent search (`.cursorignore`, huge trees) — opensrc caches a dedicated, grep-friendly copy.
- You need the **exact tag** from the lockfile without hunting through nested paths.

### opensrc is for what is **not** in the codebase

| Dependency lives… | Why Cursor is not enough | opensrc |
| --- | --- | --- |
| **PyPI / `pip`** (`site-packages`, venv outside repo) | Python deps are often **not checked in**; only `requirements.txt` / `pyproject.toml` is in git | `opensrc path pypi:requests` |
| **System or global install** | No project folder for the agent to open | Same — fetch by package id + version |
| **`<script src="…">` / CDN** (`unpkg`, jsDelivr, cdnjs, `esm.sh`) | URL in HTML/WordPress/theme — **zero** package tree in repo | Parse pkg@version from URL → `opensrc path chart.js@4.4.0` |
| **crates.io** (Rust) | Source under `~/.cargo/registry`, not your app repo | `opensrc path crates:serde` |
| **GitHub dependency** (no npm/PyPI layout in tree) | Only a version pin in config | `opensrc path owner/repo@v1.0.0` |

**Rule:** If the library is **not** represented as readable files in the workspace (or only as a minified CDN URL), use opensrc. If it is already under `node_modules` / project vendor and the agent can read it, use Cursor first.

### How it works

1. `opensrc path <package>` resolves version from lockfiles where applicable (`package-lock.json`, `pnpm-lock.yaml`, `yarn.lock`, or explicit `@version`).
2. Returns a cache path; use normal shell tools:

```bash
opensrc path pypi:requests
rg "timeout" $(opensrc path pypi:flask)

opensrc path zod@3.22.0
cat $(opensrc path zod)/src/types.ts
```

3. Ecosystems: `pypi:…`, `crates:…`, `owner/repo`, npm package names.

**CDN / `script src` workflow** (nothing in repo):

1. From the URL, get **package + version** (e.g. `…/npm/chart.js@4.4.0/…` → `chart.js@4.4.0`).
2. `opensrc path chart.js@4.4.0` then `rg` / `cat` on that path—not the minified `.min.js` URL.

### When to use / skip

**Use:** Implementation detail for **pip/site**, **CDN**, or **non-vendored** deps; debugging “what does this installed package actually do?”; full `src/` when `node_modules` only has build output.

**Skip:** Routine edits where Cursor can already read the package in `node_modules`; simple API questions from docs; first-party repo files (read them directly).

**Skill triggers (examples):** “fetch source for…”, “read the source of…”, “how does this **pypi** package work”, “what does this **script src** load”, `opensrc path`.

---

## bash-tool (Vercel) — filesystem retrieval without filling the prompt

- Repo: https://github.com/vercel-labs/bash-tool  
- Changelog: https://vercel.com/changelog/use-skills-in-your-ai-sdk-agents-via-bash-tool  

**What it does:** Gives AI SDK agents a **sandboxed bash layer** (`find`, `grep`, `jq`, read/write file) over a preloaded filesystem so context is **retrieved on demand**, not pasted wholesale into the model context.

**How it works:**

- Files are mounted in-memory or in an isolated VM (Vercel Sandbox).
- The agent runs shell-style queries; only **relevant slices** enter the conversation.
- Pairs with **Agent Skills** (`SKILL.md` directories) via `experimental_createSkillTool` + `createBashTool` in the AI SDK.

**Best for:** Custom agents and automation where you control the runtime—not a replacement for Cursor’s built-in workspace tools, but the same *pattern*: retrieve, don’t narrate.

Public skill index: https://skills.sh/

---

## Quick comparison

| Tool | Primary job |
| --- | --- |
| **Cursor** | Edit and reason over **your** repo in the IDE |
| **opensrc** | Source for deps **outside the repo** (pip/site, CDN `script src`, crates, etc.); optional when `node_modules` is unreadable or dist-only |
| **bash-tool** | On-demand **grep/cat** over mounted files in custom agents |

---

## Related

- [[Service Layer - code-structure Skill (Michael Shimeles)]]
- [[Large Context in 2026 - Prefer Code at Hand Over Describing Libraries]]
- [[Greptile Code Review and greploop]]
- [[File Architecture for SKILL.md]]
- [[Compact Context and New Chat Threads - IDE Comparison]]
- [[_PRIMER - Accurate Code Generation Context Management (Shortcut)]]
