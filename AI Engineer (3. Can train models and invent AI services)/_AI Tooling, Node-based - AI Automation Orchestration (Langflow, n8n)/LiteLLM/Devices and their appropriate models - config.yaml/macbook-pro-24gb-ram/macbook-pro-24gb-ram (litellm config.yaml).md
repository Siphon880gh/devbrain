# LiteLLM + Ollama on MacBook Pro 24 GB (base M3 Pro / M4 Pro)

This guide is for a **MacBook Pro** with **24 GB** unified memory. It defines a LiteLLM proxy configuration that routes agent requests to local Ollama models, tuned for laptop workloads (May 2026 benchmarks).

## Prerequisites

- [Ollama](https://ollama.com) installed and running at `http://localhost:11434`
- LiteLLM proxy: `pip install 'litellm[proxy]'` or `uv tool install 'litellm[proxy]'`
- Pull the Ollama models listed in the config before starting the proxy

## Where to place this file

Save the configuration below as **`config.yaml`** in your LiteLLM directory—for example:

```text
~/litellm/config.yaml
```

If you already run LiteLLM for an operator stack or dashboard, replace or merge with your existing proxy config. Keep one active `config.yaml` per machine; use the file from this folder that matches your hardware.

## How to run LiteLLM

1. Pull models referenced in the config:

```bash
ollama pull llama3:8b-text-q5_0
ollama pull mistral:latest
ollama pull nomic-embed-text:latest
ollama pull qwen2.5:7b
```

2. Start the proxy:

```bash
litellm --config config.yaml
```

The proxy listens at **`http://0.0.0.0:4000`** by default. Use the `master_key` from `general_settings` as your bearer token. Point OpenAI-compatible clients at `http://localhost:4000` and select models by their LiteLLM alias (`llama3`, `qwen-mid`, etc.).

```bash
litellm --config config.yaml --port 8080
litellm --config config.yaml --detailed_debug
```

## Memory and operational notes

- Memory budget: ~8–10 GB macOS + browser + operator stack leaves ~12–14 GB for one chat model.
- Do not load qwen2.5:14b or 32b on this hardware with the dashboard stack running.
- qwen-mid (7B) is the practical ceiling for quality work; llama3 for light cron only.
- Offload full heavy-reasoning bundle runs to a Mac Studio when possible.
- On battery: prefer llama3 + embed for cron; swap to qwen-mid only for draft sessions.
- Offload full heavy-reasoning bundle runs to a Mac Studio when possible.

## Approximate latency

Ollama loads **one chat model at a time**. **Cold** = first request after a model swap; **warm** = back-to-back on the same model.

### Short prompt

```text
llama3        cold ~2–6 s      warm ~0.5–0.9 s
mistral-fast  cold ~0.2–18 s   warm ~0.2–0.4 s
qwen-mid      cold ~0.8–8 s    warm ~0.2–0.5 s
embed-local   ~0.8–1.2 s per request
```

## Best models by use case

| Use case | Model alias | Ollama model | ~RAM | When to use |
| --- | --- | --- | ---: | --- |
| Fast automation | `llama3` | `llama3:8b-text-q5_0` | 6 GB | cron/notification tier; unload before loading qwen-mid |
| Structured / JSON | `mistral-fast` | `mistral:latest` | 4 GB | on-demand only; close heavy browser tabs before swap |
| Sales & member comms | `qwen-mid` | `qwen2.5:7b` | 5 GB | recommended daily-driver and effective heavy tier on 24 GB |
| Embeddings | `embed-local` | `nomic-embed-text:latest` | 0.3 GB | always-on; pair with qwen-mid or llama3, never with 14B+ |

### Prompt types used in benchmarks

- **short** — "Reply with exactly one word: ok"
- **agent** — ~80-word multi-turn operator scenario
- **bundle** — full agent context bundle (system + identity + tools + memory)

## config.yaml

Copy this entire block into `config.yaml`:

```yaml
# MacBook Pro 24 GB (base M3 Pro / M4 Pro) — laptop guidance (LiteLLM → Ollama, May 2026)
#
# Test prompts (same methodology as Mac Studio configs):
#   short  — "Reply with exactly one word: ok"
#   agent  — ~80-word multi-turn operator scenario
#   bundle — full agent context bundle
#
# Memory budget: ~8–10 GB macOS + browser + operator stack leaves ~12–14 GB for one chat model.
# Do not load qwen2.5:14b or 32b on this hardware with the dashboard stack running.
# qwen-mid (7B) is the practical ceiling for quality work; llama3 for light cron only.
#
# Summary (short prompt, estimated):
#   llama3        cold ~2–6 s      warm ~0.5–0.9 s
#   mistral-fast  cold ~0.2–18 s   warm ~0.2–0.4 s
#   qwen-mid      cold ~0.8–8 s    warm ~0.2–0.5 s
#   embed-local   ~0.8–1.2 s per request
#
# On battery: prefer llama3 + embed for cron; swap to qwen-mid only for draft sessions.
# Offload full heavy-reasoning bundle runs to a Mac Studio when possible.

model_list:
  # ---------------------------------------------------------------------------
  # Tier 1 — Fast (~6 GB). Cron/SOP when qwen-mid is unloaded.
  # 24 GB: do not keep loaded alongside qwen-mid — Ollama holds one chat model.
  # ---------------------------------------------------------------------------
  - model_name: llama3
    litellm_params:
      model: ollama/llama3:8b-text-q5_0
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Fastest local chat model for high-volume business automation: routing,
        templated notifications, and light summarization. On 24 GB laptops, use
        for background cron only; swap to qwen-mid for any quality-sensitive draft.
      metadata:
        category: fast_automation
        ram_gb_estimate: 6
        macbook_pro_24gb: "cron/notification tier; unload before loading qwen-mid"
        business_use_cases:
          - lead intake triage and first-reply drafts
          - tour slot confirmations and calendar nudges
          - front-desk FAQ and issue logging
          - daily opening/closing SOP checklists
          - escalation email routing by issue type
          - Slack/email send confirmation parsing
          - package pickup notifications
          - next-day room staging reminders

  # ---------------------------------------------------------------------------
  # Tier 2 — Structured (~4 GB). JSON triage; short sessions only.
  # ---------------------------------------------------------------------------
  - model_name: mistral-fast
    litellm_params:
      model: ollama/mistral:latest
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Compact model tuned for structured automation: JSON triage payloads,
        severity labels, schema-constrained outputs, and deterministic SOP
        steps. Preferred over llama3 when the agent must return parseable JSON.
      metadata:
        category: structured_automation
        ram_gb_estimate: 4
        macbook_pro_24gb: "on-demand only; close heavy browser tabs before swap"
        dashboard_purposes:
          - HEARTBEAT_PLANNING
        business_use_cases:
          - facilities issue severity scoring and vendor routing
          - Wi-Fi/AV diagnostic flowcharts with structured next steps
          - escalation metadata extraction (aligned with operator stack Zod schemas)
          - local model fitness eval (structured triage scenarios)
          - cron heartbeat planning from heartbeat schedule files

  # ---------------------------------------------------------------------------
  # Tier 3 — Mid / daily driver (~5 GB). Top chat tier on 24 GB MacBook Pro.
  # Maps heavy agents from Studio config — accept lower quality vs qwen-heavy.
  # ---------------------------------------------------------------------------
  - model_name: qwen-mid
    litellm_params:
      model: ollama/qwen2.5:7b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Primary and maximum practical chat tier on 24 GB laptop hardware. Handles
        sales drafts, rewrites, onboarding copy, and simplified executive summaries.
        For long bundle runs, prefer a Mac Studio or cloud fallback.
      metadata:
        category: sales_and_member_comms
        ram_gb_estimate: 5
        macbook_pro_24gb: "recommended daily-driver and effective heavy tier on 24 GB"
        dashboard_purposes:
          - AGENT_SUGGESTION
        business_use_cases:
          - sales lead qualification summaries and handoff notes
          - tour booking negotiation and reminder copy
          - member onboarding email sequences and welcome messaging
          - retention outreach drafts and engagement briefs
          - marketing/SEO copy drafts for human editorial review
          - social/reputation response drafts (de-escalation tone)
          - proposal and offer language scaffolding
          - faithful rewrite and summarization
          - event run-of-show and vendor comms templates
          - SOP quiz generation for operator training
          - dashboard agent-run content recommendations
          - shortened executive KPI notes (full runs → Studio)
          - billing anomaly triage summaries (full runs → Studio)
          - SOP diff highlights (full runs → Studio)
          - agent gateway TUI / default agent conversations

  # ---------------------------------------------------------------------------
  # Embeddings (~0.3 GB). Always-on; lowest RAM footprint on this device.
  # ---------------------------------------------------------------------------
  - model_name: embed-local
    litellm_params:
      model: ollama/nomic-embed-text:latest
      api_base: http://localhost:11434
    model_info:
      mode: embedding
      description: >
        Local embedding model for semantic search, RAG over SOPs/resources, and
        agent memory search. Best always-on tier on 24 GB — avoids chat swaps.
      metadata:
        category: embedding
        ram_gb_estimate: 0.3
        macbook_pro_24gb: "always-on; pair with qwen-mid or llama3, never with 14B+"
        business_use_cases:
          - semantic search over SOP library and agent resources
          - RAG for lead/member context retrieval
          - agent memory and workspace recall
          - deduplication and CRM hygiene similarity matching

general_settings:
  master_key: YOUR_PASSWORD
```
