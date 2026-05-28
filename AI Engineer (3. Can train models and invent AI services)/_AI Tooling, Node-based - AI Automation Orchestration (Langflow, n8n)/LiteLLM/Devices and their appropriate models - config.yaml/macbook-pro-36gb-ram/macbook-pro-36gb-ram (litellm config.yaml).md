# LiteLLM + Ollama on MacBook Pro 36 GB (M3 Pro / M4 Pro class)

This guide is for a **MacBook Pro** with **36 GB** unified memory. It defines a LiteLLM proxy configuration that routes agent requests to local Ollama models, tuned for laptop workloads (May 2026 benchmarks).

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
ollama pull qwen2.5:14b
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

- Laptop constraints: thermal throttling on sustained 14B+ runs, battery on lid-close,
- and ~8–10 GB reserved for macOS + apps. Treat as portable operator station, not batch farm.
- Do not use qwen2.5:32b / glm-4.7-flash on 36 GB with operator stack running.
- Prefer qwen-mid on battery; reserve qwen-mid-heavy for plugged-in batch windows.

## Approximate latency

Ollama loads **one chat model at a time**. **Cold** = first request after a model swap; **warm** = back-to-back on the same model.

### Short prompt

```text
llama3        cold ~2–5 s      warm ~0.4–0.7 s
mistral-fast  cold ~0.2–15 s   warm ~0.15–0.3 s
qwen-mid      cold ~0.6–6 s    warm ~0.15–0.4 s
qwen-mid-heavy cold ~5–12 s    warm ~0.5–1.2 s  (plugged in recommended)
embed-local   ~0.7–1.0 s per request
```

## Best models by use case

| Use case | Model alias | Ollama model | ~RAM | When to use |
| --- | --- | --- | ---: | --- |
| Fast automation | `llama3` | `llama3:8b-text-q5_0` | 6 GB | battery-friendly default; pair with embed-local |
| Structured / JSON | `mistral-fast` | `mistral:latest` | 4 GB | on-demand tier; short sessions to avoid thermal throttle |
| Sales & member comms | `qwen-mid` | `qwen2.5:7b` | 5 GB | recommended daily-driver; use on battery and AC |
| Heavy reasoning | `qwen-mid-heavy` | `qwen2.5:14b` | 9 GB | AC power batch tier; maps heavy reasoning agents from Studio config |
| Embeddings | `embed-local` | `nomic-embed-text:latest` | 0.3 GB | always-on; ideal for laptop RAG without loading chat tiers |

### Prompt types used in benchmarks

- **short** — "Reply with exactly one word: ok"
- **agent** — ~80-word multi-turn operator scenario
- **bundle** — full agent context bundle (system + identity + tools + memory)

## config.yaml

Copy this entire block into `config.yaml`:

```yaml
# MacBook Pro 36 GB (M3 Pro / M4 Pro class) — laptop guidance (LiteLLM → Ollama, May 2026)
#
# Test prompts (same methodology as Mac Studio configs):
#   short  — "Reply with exactly one word: ok"
#   agent  — ~80-word multi-turn operator scenario
#   bundle — full agent context bundle
#
# Laptop constraints: thermal throttling on sustained 14B+ runs, battery on lid-close,
# and ~8–10 GB reserved for macOS + apps. Treat as portable operator station, not batch farm.
# Do not use qwen2.5:32b / glm-4.7-flash on 36 GB with operator stack running.
#
# Summary (short prompt, estimated):
#   llama3        cold ~2–5 s      warm ~0.4–0.7 s
#   mistral-fast  cold ~0.2–15 s   warm ~0.15–0.3 s
#   qwen-mid      cold ~0.6–6 s    warm ~0.15–0.4 s
#   qwen-mid-heavy cold ~5–12 s    warm ~0.5–1.2 s  (plugged in recommended)
#   embed-local   ~0.7–1.0 s per request
#
# Prefer qwen-mid on battery; reserve qwen-mid-heavy for plugged-in batch windows.

model_list:
  # ---------------------------------------------------------------------------
  # Tier 1 — Fast (~6 GB). Cron/SOP and notifications when docked or on AC.
  # Laptop: default tier on battery to limit heat and swap churn.
  # ---------------------------------------------------------------------------
  - model_name: llama3
    litellm_params:
      model: ollama/llama3:8b-text-q5_0
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Fastest local chat model for high-volume business automation: routing,
        templated notifications, and light summarization. Best laptop tier for
        background cron agents when minimizing power draw.
      metadata:
        category: fast_automation
        ram_gb_estimate: 6
        macbook_pro_36gb: "battery-friendly default; pair with embed-local"
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
  # Tier 2 — Structured (~4 GB). JSON triage; swap in for structured JSON agents on demand.
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
        macbook_pro_36gb: "on-demand tier; short sessions to avoid thermal throttle"
        dashboard_purposes:
          - HEARTBEAT_PLANNING
        business_use_cases:
          - facilities issue severity scoring and vendor routing
          - Wi-Fi/AV diagnostic flowcharts with structured next steps
          - escalation metadata extraction (aligned with operator stack Zod schemas)
          - local model fitness eval (structured triage scenarios)
          - cron heartbeat planning from heartbeat schedule files

  # ---------------------------------------------------------------------------
  # Tier 3 — Mid / daily driver (~5 GB). Primary laptop workhorse.
  # Use for sales drafts, rewrites, and most markdown-based agents.
  # ---------------------------------------------------------------------------
  - model_name: qwen-mid
    litellm_params:
      model: ollama/qwen2.5:7b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Primary workhorse for sales automation and member-facing draft quality on
        laptop hardware. Best balance of quality, latency, and thermals for
        day-to-day operator and road workflows.
      metadata:
        category: sales_and_member_comms
        ram_gb_estimate: 5
        macbook_pro_36gb: "recommended daily-driver; use on battery and AC"
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

  # ---------------------------------------------------------------------------
  # Tier 4 — Heavy reasoning (~9 GB). Laptop cap; replaces Studio 32B tiers.
  # Run only when plugged in; unload before long video calls or Xcode builds.
  # ---------------------------------------------------------------------------
  - model_name: qwen-mid-heavy
    litellm_params:
      model: ollama/qwen2.5:14b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Top reasoning tier for MacBook Pro 36 GB. Use for executive memos, long
        SOP analysis, and local agent runtime sessions that need more than qwen-mid. Not a
        substitute for Studio qwen-heavy — offload 32B batch jobs to a Mac Studio.
      metadata:
        category: heavy_reasoning
        ram_gb_estimate: 9
        macbook_pro_36gb: "AC power batch tier; maps heavy reasoning agents from Studio config"
        business_use_cases:
          - multi-plan proposal comparisons and discount risk flags
          - retention signal blending across check-ins, events, and tickets
          - billing anomaly briefs and reconciliation summaries
          - executive KPI narratives and week-over-week leadership memos
          - SOP version diff summaries and coverage gap analysis
          - partnership dossiers and stakeholder maps
          - complex escalation reasoning with long CRM context
          - agent gateway TUI / default agent conversations
          - local model fitness eval (prose + long-context scenarios)

  # ---------------------------------------------------------------------------
  # Embeddings (~0.3 GB). Always-on; low thermal cost.
  # ---------------------------------------------------------------------------
  - model_name: embed-local
    litellm_params:
      model: ollama/nomic-embed-text:latest
      api_base: http://localhost:11434
    model_info:
      mode: embedding
      description: >
        Local embedding model for semantic search, RAG over SOPs/resources, and
        agent memory search. Safe to keep loaded during travel and battery use.
      metadata:
        category: embedding
        ram_gb_estimate: 0.3
        macbook_pro_36gb: "always-on; ideal for laptop RAG without loading chat tiers"
        business_use_cases:
          - semantic search over SOP library and agent resources
          - RAG for lead/member context retrieval
          - agent memory and workspace recall
          - deduplication and CRM hygiene similarity matching

general_settings:
  master_key: YOUR_PASSWORD
```
