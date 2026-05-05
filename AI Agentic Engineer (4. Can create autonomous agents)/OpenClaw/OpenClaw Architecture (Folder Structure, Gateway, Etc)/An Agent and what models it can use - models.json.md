OpenClaw uses a `models.json` file to tell each agent which AI model providers and models it can use.

This file acts like a model registry for an agent. It lists the available providers, their API connection settings, and the individual models that the agent can choose from.

The file is located at:

```bash
~/.openclaw/agents/<agent_name>/agent/models.json
```

For the default `main` agent, that would be:

```bash
~/.openclaw/agents/main/agent/models.json
```

That means each OpenClaw agent can have its own model setup. One agent might use cloud models. Another might use local Ollama models. Another might use a different provider entirely.

---

# Basic Example

Here is a simplified version of a `models.json` file:

```json
{
  "providers": {
    "codex": {
      "baseUrl": "https://chatgpt.com/backend-api/v1",
      "apiKey": "codex-app-server",
      "auth": "token",
      "api": "openai-codex-responses",
      "models": [
        {
          "id": "gpt-5.4",
          "name": "gpt-5.4",
          "api": "openai-codex-responses",
          "reasoning": true,
          "input": ["text", "image"],
          "contextWindow": 272000,
          "maxTokens": 128000,
          "compat": {
            "supportsReasoningEffort": true,
            "supportsUsageInStreaming": true
          }
        }
      ]
    },
    "ollama": {
      "baseUrl": "http://127.0.0.1:11434",
      "apiKey": "OLLAMA_API_KEY",
      "api": "ollama",
      "models": [
        {
          "id": "deepseek-r1:latest",
          "name": "deepseek-r1:latest",
          "api": "ollama",
          "reasoning": true,
          "input": ["text"],
          "contextWindow": 131072,
          "maxTokens": 8192
        },
        {
          "id": "gemma4",
          "name": "gemma4",
          "api": "ollama",
          "reasoning": false,
          "input": ["text"],
          "contextWindow": 128000,
          "maxTokens": 8192
        }
      ]
    }
  }
}
```

This slimmed down example shows the main idea without listing every model or every cost field.

It has two providers:

```text
codex
ollama
```

The `codex` provider points to a cloud/API-based model provider.

The `ollama` provider points to a local model server running on the machine.

---

# What `models.json` Does

The `models.json` file answers a few important questions:

```text
Which model providers are available?

What URL should OpenClaw call?

What API format should OpenClaw use?

Which models can this agent use?

Does the model support reasoning?

Does the model accept text only, or text and images?

How large is the model’s context window?

How much output can the model generate?
```

In plain English, `models.json` tells OpenClaw:

```text
“Here are the models this agent is allowed to use, and here is how to talk to them.”
```

---

# The Top-Level `providers` Object

The file starts with a `providers` object:

```json
{
  "providers": {
    "codex": {},
    "ollama": {}
  }
}
```

Each key inside `providers` is a provider name.

In the example, there are two providers:

```text
codex
ollama
```

Each provider has its own connection settings and its own list of models.

---

# Provider Settings

Each provider usually has fields like this:

```json
"codex": {
  "baseUrl": "https://chatgpt.com/backend-api/v1",
  "apiKey": "codex-app-server",
  "auth": "token",
  "api": "openai-codex-responses",
  "models": []
}
```

## `baseUrl`

The `baseUrl` tells OpenClaw where to send requests.

For a cloud provider, it may look like this:

```json
"baseUrl": "https://chatgpt.com/backend-api/v1"
```

For a local Ollama provider, it may look like this:

```json
"baseUrl": "http://127.0.0.1:11434"
```

That local URL means OpenClaw expects Ollama to be running on the same machine.

---

## `apiKey`

The `apiKey` field tells OpenClaw what credential or key reference to use.

Example:

```json
"apiKey": "codex-app-server"
```

or:

```json
"apiKey": "OLLAMA_API_KEY"
```

Depending on the system, this may be a real API key, an environment variable name, or an internal token reference.

Best practice:

```text
Do not commit real API keys into models.json.
```

Use environment variables, ignored local config files, or a secrets manager when possible.

---

## `auth`

The `auth` field tells OpenClaw what kind of authentication the provider expects.

Example:

```json
"auth": "token"
```

This means the provider uses token-based authentication.

Not every provider needs this field. In the slimmed down example, `codex` has it, while `ollama` does not.

---

## `api`

The `api` field tells OpenClaw which API adapter or format to use.

Example:

```json
"api": "openai-codex-responses"
```

or:

```json
"api": "ollama"
```

This matters because different providers expect different request formats.

Ollama does not use the exact same API format as an OpenAI-style responses endpoint. OpenClaw needs to know which adapter to use so it can send the request correctly.

---

# The `models` Array

Each provider has a `models` array.

Example:

```json
"models": [
  {
    "id": "deepseek-r1:latest",
    "name": "deepseek-r1:latest",
    "api": "ollama",
    "reasoning": true,
    "input": ["text"],
    "contextWindow": 131072,
    "maxTokens": 8192
  }
]
```

Each object inside the `models` array describes one model that the agent can use.

---

# Model Fields Explained

## `id`

The `id` is the machine-readable model identifier.

Example:

```json
"id": "deepseek-r1:latest"
```

This is usually the value OpenClaw sends to the provider when choosing a model.

For Ollama, the `id` should usually match the model name shown by:

```bash
ollama list
```

If the model name does not match, OpenClaw may not be able to use it.

---

## `name`

The `name` is the human-readable model label.

Example:

```json
"name": "deepseek-r1:latest"
```

Sometimes `id` and `name` are the same. Other times, `name` may be cleaner for display in a UI or dashboard.

---

## `api`

The model-level `api` field tells OpenClaw which API adapter this specific model uses.

Example:

```json
"api": "ollama"
```

Most of the time, this matches the provider-level `api`.

---

## `reasoning`

The `reasoning` field tells OpenClaw whether the model is meant for reasoning-heavy work.

Example:

```json
"reasoning": true
```

A reasoning model is better for:

```text
planning
debugging
code review
tool use
multi-step coding
architecture decisions
complex problem solving
```

A non-reasoning model may be better for:

```text
rewriting
summaries
simple chat
classification
light utility tasks
```

For example:

```json
{
  "id": "deepseek-r1:latest",
  "reasoning": true
}
```

This tells OpenClaw that `deepseek-r1:latest` can be used for reasoning tasks.

Meanwhile:

```json
{
  "id": "gemma4",
  "reasoning": false
}
```

This suggests `gemma4` is better suited for general text work instead of deeper agent planning.

---

## `input`

The `input` field tells OpenClaw what kind of input the model accepts.

Example:

```json
"input": ["text", "image"]
```

This means the model can accept both text and images.

Another example:

```json
"input": ["text"]
```

This means the model only accepts text.

This matters for agents that need to inspect screenshots, UI images, diagrams, or uploaded visual assets.

A text-only model should not be used for image tasks.

---

## `contextWindow`

The `contextWindow` field tells OpenClaw how much input the model can handle.

Example:

```json
"contextWindow": 131072
```

A larger context window helps when an agent needs to read:

```text
source files
logs
terminal output
documentation
task history
previous messages
tool results
```

A small context window means the agent needs more focused prompts and should read fewer files at once.

---

## `maxTokens`

The `maxTokens` field tells OpenClaw the maximum output size the model can generate.

Example:

```json
"maxTokens": 8192
```

This does not mean every response will be that long. It means the configured output ceiling is 8,192 tokens.

For coding agents, a higher output limit can help when the model needs to produce longer patches, explanations, or full-file updates.

---

## `compat`

Some models include a `compat` section:

```json
"compat": {
  "supportsReasoningEffort": true,
  "supportsUsageInStreaming": true
}
```

This describes special features supported by that model or API.

### `supportsReasoningEffort`

This means OpenClaw can likely send a reasoning-effort setting to the model.

A simple task might use lower reasoning effort.

A hard debugging task might use higher reasoning effort.

### `supportsUsageInStreaming`

This means usage information can be returned while the response is streaming.

That can help OpenClaw track usage, token counts, or cost while the model is still generating.

---

# Cloud Models vs Local Models

The example `models.json` shows two model strategies.

## Cloud/API Models

The `codex` provider uses a remote base URL:

```json
"baseUrl": "https://chatgpt.com/backend-api/v1"
```

Cloud models are useful for:

```text
strong reasoning
large context windows
vision support
high-quality coding
complex planning
```

The tradeoff is that they may require authentication, internet access, usage limits, or billing.

---

## Local Ollama Models

The `ollama` provider uses a local base URL:

```json
"baseUrl": "http://127.0.0.1:11434"
```

Local models are useful for:

```text
privacy
offline use
low-cost repeated tasks
fast local experiments
background jobs
custom model testing
```

The tradeoff is that quality and speed depend heavily on your hardware and the model size.

A tiny local model may be fine for simple summaries, but weak for serious coding or complex reasoning.

---

# Example Model Mix

Using the slimmed down example, the agent has access to three models:

|Provider|Model|Reasoning|Input|Context Window|Best Use|
|---|---|--:|---|--:|---|
|`codex`|`gpt-5.4`|Yes|Text, image|272,000|Heavy reasoning, coding, vision|
|`ollama`|`deepseek-r1:latest`|Yes|Text|131,072|Local reasoning tasks|
|`ollama`|`gemma4`|No|Text|128,000|General local text tasks|

This gives the agent options.

For example:

```text
Use the cloud model for difficult coding or vision work.

Use the local reasoning model for private reasoning tasks.

Use the non-reasoning local model for summaries, rewrites, and simple text jobs.
```

---

# Why This File Matters

The `models.json` file matters because AI agents do not need the same model for every job.

One task may need a large reasoning model.

Another task may only need a small local model.

Another task may need image input.

Another task may need a long context window.

Instead of hardcoding one model into OpenClaw, `models.json` gives each agent a menu of available models.

That makes OpenClaw more flexible.

---

# Practical Agent Workflow

A practical OpenClaw setup might use models like this:

```text
Planner agent:
Use a strong reasoning model.

Coder agent:
Use a coding-capable cloud model.

Reviewer agent:
Use a reasoning model.

Summarizer agent:
Use a cheaper local model.

Background utility agent:
Use a small local model.
```

This is where `models.json` becomes useful.

It lets OpenClaw route different tasks to different models based on the job.

---

# Best Practices

## Keep Secrets Out of the File

Avoid putting real API keys directly inside `models.json`.

Use:

```text
environment variables
local ignored config files
secret managers
OS keychains
agent-specific auth files
```

This is especially important if the OpenClaw directory is backed up, synced, or shared.

---

## Match the Model to the Job

Do not use the biggest model for every task.

A good pattern is:

|Task Type|Recommended Model Type|
|---|---|
|Complex coding|Large reasoning model|
|Debugging|Reasoning model|
|Code review|Reasoning model|
|Simple rewrite|Small local model|
|Summarization|Local or cheaper model|
|Image analysis|Vision-capable model|
|Background utility task|Lightweight local model|

This keeps the system faster, cheaper, and easier to scale.

---

## Be Honest About Context Windows

Do not assume every model can read a whole codebase.

A model with:

```json
"contextWindow": 4096
```

needs very focused input.

A model with:

```json
"contextWindow": 131072
```

can handle much more context.

A model with:

```json
"contextWindow": 272000
```

can handle very large tasks, but you still should not dump unnecessary files into the prompt.

Good agents should read only what they need.

---

# Troubleshooting

## Ollama Models Do Not Work

Check that Ollama is running:

```bash
ollama list
```

Check the local API:

```bash
curl http://127.0.0.1:11434/api/tags
```

Make sure the model `id` in `models.json` matches the model name shown by Ollama.

---

## Model Name Is Wrong

If OpenClaw cannot find a model, check the `id`.

For Ollama, this usually needs to match the installed model name exactly.

Example:

```json
"id": "deepseek-r1:latest"
```

If Ollama shows a different tag, update the file.

---

## Vision Does Not Work

Check the `input` field.

A model with only this:

```json
"input": ["text"]
```

should not be expected to handle images.

For image support, the model should list:

```json
"input": ["text", "image"]
```

---

## Reasoning Settings Do Not Work

Check whether the model has:

```json
"reasoning": true
```

Also check compatibility:

```json
"compat": {
  "supportsReasoningEffort": true
}
```

If the model or API does not support reasoning effort, OpenClaw may need to ignore that setting.

---

# Simple Mental Model

Think of `models.json` like this:

|Section|Meaning|
|---|---|
|`providers`|Where the models live|
|`baseUrl`|The endpoint OpenClaw calls|
|`apiKey`|The credential or key reference|
|`api`|How OpenClaw talks to that provider|
|`models`|The model menu for that provider|
|`reasoning`|Whether the model is good for deep thinking|
|`input`|Whether the model accepts text, images, or both|
|`contextWindow`|How much input the model can read|
|`maxTokens`|How much output the model can write|
|`compat`|Special features the model/API supports|

---

# Final Takeaway

The OpenClaw `models.json` file is the model menu for a specific agent.

It lives at:

```bash
~/.openclaw/agents/<agent_name>/agent/models.json
```

For the main agent:

```bash
~/.openclaw/agents/main/agent/models.json
```

This file tells OpenClaw which cloud and local models are available, how to connect to them, what they can do, and when they should be used.

A good `models.json` setup lets your agents use the right model for the right job: large cloud reasoning models for serious coding, local Ollama models for private or low-cost work, and lightweight models for simple background tasks.