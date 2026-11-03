# SDK vs API vs MCP when prompting an implementation

When you ask an AI to "add Stripe" or "connect Gmail," it has to pick a **surface**. Those three words are not synonyms. The prompt should name the surface, or you get the wrong files, the wrong secrets, and a feature that only works inside the chat.

Short version:

| Surface | Who uses it | What you are really adding |
|---|---|---|
| **API** | Your app, over HTTP | Endpoints, headers, and a secret or OAuth token |
| **SDK** | Your app, in code | A vendor package that wraps that API |
| **MCP** | The **agent** (Cursor, Codex, Claude Code) | A tool server the model can call during a session |

MCP is defined in [[Capabilities and Interoperability]]. An MCP server often still talks to an API behind the scenes, and it may still need a key. The difference is **who holds the key and who makes the call**.

---

## API

The HTTP contract. `GET https://api.example.com/v1/widgets` with a header.

**What the AI must implement**

- Client calls (`fetch`, `axios`, `curl`) from **your** server or a trusted backend
- Base URL, version, query/body shape, error codes, rate limits
- Auth: API key, bearer token, or OAuth code flow

**What you must supply**

1. Create a key (or OAuth app) in the vendor dashboard.
2. Put the secret in `.env` / the host's secret store. Never in the repo, never in browser JS. See [[Code Generation - Build Security into Every AI-Generated App]].
3. Name the env var in the prompt (`STRIPE_SECRET_KEY`, `GEMINI_API_KEY`).
4. Point at the official docs or `@Docs` so the model does not invent paths. See [[Augment Cursor AI with online documentation]].

**Prompt shape**

```text
Call the vendor REST API from the server. Read the key from process.env.NAME.
Do not install an SDK. Do not add an MCP server. Do not put the key in client code.
```

Use this when there is no official SDK for your language, you want a single HTTP call, or you need to see the raw request.

---

## SDK

A library you install (`npm i stripe`, `pip install stripe`) that wraps the API: typed methods, retries, webhooks.

**What the AI must implement**

- Add the package and lockfile change
- Init a client once (`new Stripe(process.env.STRIPE_SECRET_KEY)`)
- Call methods instead of hand-built URLs
- Still: env var, server-side only, webhook signature check if that is in scope

**What you must supply**

1. Same dashboard key or OAuth app as the API. An SDK does **not** remove the key.
2. Language and runtime (`Node 20`, `Python 3.12`) so it picks the right package.
3. "Official SDK only" if you do not want a random wrapper.

**Prompt shape**

```text
Use the official Stripe Node SDK. Install the package. Read STRIPE_SECRET_KEY from env.
Do not raw-fetch the REST API. Do not add an MCP server.
```

Use this when the product itself must charge cards, send mail, or call the vendor at runtime for every user.

---

## MCP

[Model Context Protocol](https://modelcontextprotocol.io). A server that exposes **tools** to the coding harness (or to an agent-first app). The model chooses a tool; the server runs it.

This is usually **developer-time** (Cursor talks to GitHub / Stripe / a docs server while you work). It is **product-time** only if you are building an agent that your users talk to. See [[_PRIMER - Agent-First Apps - Two Modes of Use]].

**What the AI must implement** (or you must click)

- Register the server in the harness: `~/.cursor/mcp.json`, project `.cursor/mcp.json`, or Codex `config.toml` (`[mcp_servers.<name>]`). See [[Codex CLI - MCP servers in config.toml]].
- Start command (`npx -y @…`) or a remote URL
- Auth: OAuth browser login, or an API key in **that server's** env — not in your Next.js `.env` unless the product agent needs it too
- After install: restart / new chat so tools appear

**What you must supply**

1. The server name and install line (`npx …`, or a hosted `https://…/mcp` URL).
2. Whether it uses OAuth (you will get a login prompt) or a key (you paste it into the MCP settings, not into app code).
3. A reminder: MCP does **not** ship the vendor into the user's browser. Connecting Gmail MCP in Cursor is not "the app has Gmail."

**Prompt shape — agent tools only**

```text
Add the Stripe MCP to this Cursor project so you can look up products while we work.
Do not add the Stripe SDK to the app. Do not put a Stripe key in the Next.js env.
```

**Prompt shape — product must call the vendor**

```text
The users will pay in the app. Use the official Stripe SDK and STRIPE_SECRET_KEY on the server.
Do not solve this with an MCP server.
```

If the MCP is missing, the agent should say so and ask before installing. Treat a new MCP like any other skill: some servers want keys and network. See [[Check a skill for malware before installing]].

---

## Side by side

| Step | API | SDK | MCP |
|---|---|---|---|
| Install a package in the app | No | Yes | No (harness config instead) |
| API key or OAuth | Yes, in **app** env | Yes, in **app** env | Often yes, in **MCP** env or a browser login |
| Code in your repo that runs in production | `fetch` / HTTP client | Vendor client | Only if your **product** is an agent that connects to MCP |
| Who calls the vendor | Your server | Your server | The agent process |
| Typical config file | `.env` | `.env` + lockfile | `mcp.json` / `config.toml` |
| Survives a new chat | Yes | Yes | Tools must be connected in that harness |
| Good prompt verb | "call the REST API" | "use the official SDK" | "add/use the MCP server" |

A hosted MCP (OAuth, no key in your files) still does not replace an SDK. The agent can act while you code. The deployed app cannot, unless you wired MCP or the SDK into that app.

---

## What to say in the prompt

Name all three so the model cannot pick the wrong one:

```text
Integrate <vendor> as <API | official SDK | MCP>.
Secret: <ENV_NAME or OAuth>.
Keep the secret off the client.
Do not also add <the other two>.
```

If you are unsure which you need: **users will hit this in production → SDK (or raw API). Only you and the agent need it while coding → MCP.**
