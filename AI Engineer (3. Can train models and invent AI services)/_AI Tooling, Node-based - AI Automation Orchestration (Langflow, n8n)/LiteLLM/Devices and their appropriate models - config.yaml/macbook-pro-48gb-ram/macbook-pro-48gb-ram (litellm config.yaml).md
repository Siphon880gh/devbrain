# LiteLLM + Ollama on MacBook Pro 48 GB (M3 Max / M4 Max class)

This guide is for a **MacBook Pro** with **48 GB** unified memory. It defines a LiteLLM proxy configuration that routes agent requests to local Ollama models, tuned for laptop workloads (May 2026 benchmarks).

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
ollama pull glm-4.7-flash:latest
ollama pull llama3:8b-text-q5_0
ollama pull mistral:latest
ollama pull nomic-embed-text:latest
ollama pull qwen2.5:14b
ollama pull qwen2.5:32b
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

- 48 GB unified memory supports 32B models when plugged in and thermals are managed.
- Ollama still loads one chat model at a time — batch heavy agents back-to-back.
- Reserve qwen-heavy for AC power; use qwen-mid-heavy or qwen-mid on battery.

## Approximate latency

Ollama loads **one chat model at a time**. **Cold** = first request after a model swap; **warm** = back-to-back on the same model.

### Short prompt

```text
llama3        cold ~1.8–4.5 s   warm ~0.35–0.6 s
mistral-fast  cold ~0.1–14 s    warm ~0.12–0.28 s
qwen-mid      cold ~0.5–5 s     warm ~0.12–0.35 s
qwen-mid-heavy cold ~4–10 s     warm ~0.4–1.0 s
qwen-heavy    cold ~12–18 s     warm ~0.2–0.4 s   (AC, fans audible)
embed-local   ~0.6–0.9 s per request
```

## Best models by use case

| Use case | Model alias | Ollama model | ~RAM | When to use |
| --- | --- | --- | ---: | --- |
| Fast automation | `llama3` | `llama3:8b-text-q5_0` | 6 GB | cron tier; swap out before qwen-heavy batch windows |
| Structured / JSON | `mistral-fast` | `mistral:latest` | 4 GB | light tier; fast swap after 32B sessions when plugged in |
| Sales & member comms | `qwen-mid` | `qwen2.5:7b` | 5 GB | recommended daily-driver; battery-safe default |
| Mid-heavy reasoning | `qwen-mid-heavy` | `qwen2.5:14b` | 9 GB | AC-power mid tier; use instead of qwen-heavy for travel days |
| Heavy reasoning | `qwen-heavy` | `qwen2.5:32b` | 19 GB | AC batch tier; Studio-parity for heavy reasoning bundles |
| Heavy reasoning (alt) | `glm-heavy` | `glm-4.7-flash:latest` | 19 GB | hot-swap with qwen-heavy; verify output before production |
| Embeddings | `embed-local` | `nomic-embed-text:latest` | 0.3 GB | always-on; safe on battery and AC |

### Prompt types used in benchmarks

- **short** — "Reply with exactly one word: ok"
- **agent** — ~80-word multi-turn operator scenario
- **bundle** — full agent context bundle (system + identity + tools + memory)

## config.yaml

Copy this entire block into `config.yaml`:

```yaml
# MacBook Pro 48 GB (M3 Max / M4 Max class) — laptop guidance (LiteLLM → Ollama, May 2026)
#
# Test prompts (same methodology as Mac Studio configs):
#   short  — "Reply with exactly one word: ok"
#   agent  — ~80-word multi-turn operator scenario
#   bundle — full agent context bundle
#
# 48 GB unified memory supports 32B models when plugged in and thermals are managed.
# Ollama still loads one chat model at a time — batch heavy agents back-to-back.
# Reserve qwen-heavy for AC power; use qwen-mid-heavy or qwen-mid on battery.
#
# Summary (short prompt, estimated):
#   llama3        cold ~1.8–4.5 s   warm ~0.35–0.6 s
#   mistral-fast  cold ~0.1–14 s    warm ~0.12–0.28 s
#   qwen-mid      cold ~0.5–5 s     warm ~0.12–0.35 s
#   qwen-mid-heavy cold ~4–10 s     warm ~0.4–1.0 s
#   qwen-heavy    cold ~12–18 s     warm ~0.2–0.4 s   (AC, fans audible)
#   embed-local   ~0.6–0.9 s per request
#
# qwen-heavy agent bundle: warm ~35–55 s plugged in; avoid on battery.

model_list:
  # ---------------------------------------------------------------------------
  # Tier 1 — Fast (~6 GB). Cron/SOP automation; pair with embed-local.
  # ---------------------------------------------------------------------------
  - model_name: llama3
    litellm_params:
      model: ollama/llama3:8b-text-q5_0
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Fastest local chat model for high-volume business automation: routing,
        templated notifications, and light summarization. Lowest latency for
        cron-driven SOP agents on laptop hardware.
      metadata:
        category: fast_automation
        ram_gb_estimate: 6
        macbook_pro_48gb: "cron tier; swap out before qwen-heavy batch windows"
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
  # Tier 2 — Structured (~4 GB). JSON triage and heartbeat planning.
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
        macbook_pro_48gb: "light tier; fast swap after 32B sessions when plugged in"
        dashboard_purposes:
          - HEARTBEAT_PLANNING
        business_use_cases:
          - facilities issue severity scoring and vendor routing
          - Wi-Fi/AV diagnostic flowcharts with structured next steps
          - escalation metadata extraction (aligned with operator stack Zod schemas)
          - local model fitness eval (structured triage scenarios)
          - cron heartbeat planning from heartbeat schedule files

  # ---------------------------------------------------------------------------
  # Tier 3 — Mid / daily driver (~5 GB). Primary laptop workhorse on battery.
  # ---------------------------------------------------------------------------
  - model_name: qwen-mid
    litellm_params:
      model: ollama/qwen2.5:7b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Primary workhorse for sales automation and member-facing draft quality.
        Best default on battery; swap to qwen-mid-heavy or qwen-heavy when docked.
      metadata:
        category: sales_and_member_comms
        ram_gb_estimate: 5
        macbook_pro_48gb: "recommended daily-driver; battery-safe default"
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
  # Tier 3b — Mid-heavy (~9 GB). Intermediate tier on AC power without full 32B load.
  # ---------------------------------------------------------------------------
  - model_name: qwen-mid-heavy
    litellm_params:
      model: ollama/qwen2.5:14b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Intermediate reasoning tier for laptop use when 32B is overkill or thermals
        are a concern. Good for long drafts and local agent runtime on AC without qwen-heavy swap.
      metadata:
        category: heavy_reasoning_mid
        ram_gb_estimate: 9
        macbook_pro_48gb: "AC-power mid tier; use instead of qwen-heavy for travel days"
        business_use_cases:
          - proposal comparisons and discount risk flags (shorter context)
          - retention outreach with moderate context windows
          - partnership dossier drafts before Studio polish
          - local model fitness eval (prose scenarios)

  # ---------------------------------------------------------------------------
  # Tier 4 — Heavy reasoning (~19 GB). Studio-parity 32B tier; AC power batch only.
  # Unload other chat models first; expect fan noise and heat on sustained bundles.
  # ---------------------------------------------------------------------------
  - model_name: qwen-heavy
    litellm_params:
      model: ollama/qwen2.5:32b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Full 32B reasoning tier for MacBook Pro 48 GB when plugged in. Matches
        Mac Studio qwen-heavy agent mapping. Not recommended on battery or with
        many background apps — close browsers and Xcode builds before loading.
      metadata:
        category: heavy_reasoning
        ram_gb_estimate: 19
        macbook_pro_48gb: "AC batch tier; Studio-parity for heavy reasoning bundles"
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
  # Tier 4 alt — Heavy reasoning (~19 GB). Hot-swap with qwen-heavy; AC only.
  # ---------------------------------------------------------------------------
  - model_name: glm-heavy
    litellm_params:
      model: ollama/glm-4.7-flash:latest
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Alternative 32B-class model for long-context analysis when qwen-heavy is
        busy or underperforming. Same RAM and thermal profile — hot-swap only.
      metadata:
        category: heavy_reasoning_alt
        ram_gb_estimate: 19
        macbook_pro_48gb: "hot-swap with qwen-heavy; verify output before production"
        business_use_cases:
          - long SOP and contract document analysis
          - executive reporting with dense tabular context
          - partnership research briefs with citation-style output
          - finance operator briefs when qwen-heavy queue is saturated

  # ---------------------------------------------------------------------------
  # Embeddings (~0.3 GB). Always-on.
  # ---------------------------------------------------------------------------
  - model_name: embed-local
    litellm_params:
      model: ollama/nomic-embed-text:latest
      api_base: http://localhost:11434
    model_info:
      mode: embedding
      description: >
        Local embedding model for semantic search, RAG over SOPs/resources, and
        agent memory search. Keep loaded alongside qwen-mid or llama3.
      metadata:
        category: embedding
        ram_gb_estimate: 0.3
        macbook_pro_48gb: "always-on; safe on battery and AC"
        business_use_cases:
          - semantic search over SOP library and agent resources
          - RAG for lead/member context retrieval
          - agent memory and workspace recall
          - deduplication and CRM hygiene similarity matching

general_settings:
  master_key: YOUR_PASSWORD
```
