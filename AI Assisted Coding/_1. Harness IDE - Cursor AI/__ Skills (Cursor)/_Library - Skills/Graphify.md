# Graphify

Skill name: `graphify`

Publisher: Graphify Labs

Source: [Graphify-Labs/graphify](https://github.com/Graphify-Labs/graphify)

Directory: [skills.sh/graphify-labs/graphify](https://www.skills.sh/graphify-labs/graphify) (about 12,300 installs as of 2 November 2026)

PyPI package: `graphifyy` (two y's). The CLI command is still `graphify`. Other `graphify*` packages on PyPI are not this project.

Graphify turns a codebase, Markdown notes, SQL schemas, configs, and (optionally) PDFs, images, and video into a **real knowledge graph**: nodes for concepts, files, and functions; edges for calls, imports, inheritance, and doc links. Later questions walk that graph instead of making the agent reread the tree.

It is not a vector store. There is no embedding index. You query `graph.json`. Each edge is tagged `EXTRACTED` (explicit in the source) or `INFERRED` (resolved by Graphify), so you can tell what was read from what was guessed.

This is the automated form of the hand-maintained map in [[_Context - Ever-updating High-Level Context that Optimizes Token Usage and Lowers Likelihood of Lines disappearing]]. You build the graph once, then each turn pulls a token-budgeted subgraph instead of grepping and opening files again.

Code is parsed locally with tree-sitter AST. Nothing leaves the machine for a code-only run. Docs, PDFs, and images use the assistant's model (or a configured API key) for a semantic pass. Needs Python 3.10+.

Docs: [docs.graphify.com](https://docs.graphify.com/open-source/quickstart). Cursor-specific: [Graphify for Cursor](https://docs.graphify.com/integrations/cursor).

---

## Install

Two ways. The command is the precise one. Asking the agent is enough if you do not want to run the CLI yourself.

Review the skill before you rely on it. A skill runs with the agent's permissions. See [[Check a skill for malware before installing]], [[Skill Security Check]], and [[Recommended Setup on Mac - Npx skills]].

### Precise: `npx skills`

```bash
npx skills add graphify-labs/graphify
```

If the skills CLI is not installed yet, `npx` will ask to install it. Answer the wizard. That copies the skill into the shared `~/.agents/skills` folder, which Cursor already reads. You do not need `--agent cursor` for Cursor to see it.

To name the skill and the agent explicitly:

```bash
npx skills add Graphify-Labs/graphify --skill graphify --global --agent cursor
```

`--global` plus an agent whose global path is `~/.agents/skills` (`codex` is one) keeps it in the shared user namespace. See [[Recommended Setup on Mac - Npx skills]].

### Ask the AI to install it

In Cursor (or another harness that can run shell):

```text
Install the Graphify skill from graphify-labs/graphify with npx skills.
Put it in ~/.agents/skills.
```

Or shorter:

```text
Add the graphify skill using npx skills
```

The agent should run the same `npx skills add graphify-labs/graphify` command. After it finishes, start a new chat or restart the agent so `/graphify` shows up.

### Official CLI (optional, fuller setup)

The skill is the instructions. The `graphify` command is the extractor. If `/graphify .` fails because `graphify` is missing, install the package, then register the skill for Cursor:

```bash
uv tool install graphifyy
graphify install --platform cursor
```

or `graphify cursor install`. `graphify install` with no flag targets Claude Code. `graphify install --platform agents` writes to `~/.agents/skills` for any harness that reads that folder.

Python 3.10+ is required. On a Mac: `brew install python@3.12 uv`.

---

## What you ask it to do

In the project, after the skill is loaded:

```text
/graphify .
```

That builds `graphify-out/`. Code is parsed locally. Markdown and other docs go through the session model.

Then query instead of rereading files:

```text
/graphify query "how does authentication reach the database"
/graphify query "how does authentication reach the database" --budget 1500
/graphify path "AuthModule" "Database"
/graphify explain "SessionStore"
```

`--budget` caps the subgraph the agent is allowed to pull. That is the token save: a few thousand tokens of nodes and edges instead of the whole repo.

Keep it current:

```text
/graphify . --update
```

Plain-language works too, once `graphify-out/` exists. The skill says a codebase question should be treated as a graphify query first:

```text
Use Graphify to explain the authentication flow. Cite the source files and distinguish EXTRACTED edges from INFERRED ones.
```

---

## What you get

```text
graphify-out/
├── graph.html       clickable graph in a browser
├── GRAPH_REPORT.md  god nodes, communities, suggested questions
└── graph.json       the graph you query on later turns
```

| Command | What it returns |
|---|---|
| `/graphify .` | Build or rebuild the graph |
| `/graphify . --update` | Re-extract only changed files |
| `/graphify query "..."` | BFS subgraph for a question, optional `--budget` |
| `/graphify query "..." --dfs` | DFS, for a specific path |
| `/graphify path A B` | Shortest path between two concepts |
| `/graphify explain "Name"` | One node, its source file, and neighbors |

`graphify query` and the MCP `query_graph` tool take a token budget (default around 2000). That is how the agent stops rereading Markdown maps and source files on every turn.

Commit `graph.json` and `GRAPH_REPORT.md` if the team should share one graph. Keep `graphify-out/cache/` out of git.

The same graph can be served over MCP (`graphify-mcp`) with `query_graph`, `get_node`, `get_neighbors`, `shortest_path`, and `god_nodes`. Hosted Graphify Cloud is a different product: they index the repo for you and claim about 80% fewer agent tokens. The open-source skill is the local graph in `graphify-out/`.
