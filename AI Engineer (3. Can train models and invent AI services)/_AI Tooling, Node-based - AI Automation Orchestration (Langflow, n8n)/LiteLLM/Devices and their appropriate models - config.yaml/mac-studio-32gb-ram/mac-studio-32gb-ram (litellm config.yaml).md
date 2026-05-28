# LiteLLM + Ollama on Mac Studio 32 GB

This guide is for a **Mac Studio** with **32 GB** unified memory. It defines a LiteLLM proxy configuration that routes agent requests to local Ollama models, tuned for desktop workloads (May 2026 benchmarks).

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

- Memory budget: ~8–10 GB macOS + operator stack leaves ~20–22 GB for one large model.
- Do not load qwen2.5:32b / glm-4.7-flash (~19 GB each) alongside the dashboard stack.
- Use qwen-mid-heavy (14B class) as the top reasoning tier on this hardware.

## Approximate latency

Ollama loads **one chat model at a time**. **Cold** = first request after a model swap; **warm** = back-to-back on the same model.

### Short prompt

```text
llama3        cold ~1.5–4 s    warm ~0.3–0.5 s
mistral-fast  cold ~0.1–14 s   warm ~0.1–0.2 s
qwen-mid      cold ~0.5–5 s    warm ~0.1–0.3 s
qwen-mid-heavy cold ~4–8 s     warm ~0.3–0.8 s
embed-local   ~0.6–0.9 s per request
```

## Best models by use case

| Use case | Model alias | Ollama model | ~RAM | When to use |
| --- | --- | --- | ---: | --- |
| Fast automation | `llama3` | `llama3:8b-text-q5_0` | 6 GB | default-always-on tier; pair with embed-local |
| Structured / JSON | `mistral-fast` | `mistral:latest` | 4 GB | light tier; swap in when JSON reliability matters |
| Sales & member comms | `qwen-mid` | `qwen2.5:7b` | 5 GB | recommended daily-driver; unload before mid-heavy batch jobs |
| Heavy reasoning | `qwen-mid-heavy` | `qwen2.5:14b` | 9 GB | batch tier only; replaces qwen-heavy/glm-heavy from 64 GB config |
| Embeddings | `embed-local` | `nomic-embed-text:latest` | 0.3 GB | always-on; negligible RAM vs chat models |

### Prompt types used in benchmarks

- **short** — "Reply with exactly one word: ok"
- **agent** — ~80-word multi-turn operator scenario
- **bundle** — full agent context bundle (system + identity + tools + memory)

## config.yaml

Copy this entire block into `config.yaml`:

```yaml
# Mac Studio 32 GB — latency guidance (LiteLLM → Ollama, May 2026)
#
# Test prompts (same methodology as 64 GB Studio):
#   short  — "Reply with exactly one word: ok" (~11 input tokens, max 8 output)
#   agent  — ~80-word multi-turn operator scenario (~40–80 output tokens)
#   bundle — full agent context bundle (system + identity + tools + memory)
#
# Memory budget: ~8–10 GB macOS + operator stack leaves ~20–22 GB for one large model.
# Do not load qwen2.5:32b / glm-4.7-flash (~19 GB each) alongside the dashboard stack.
# Use qwen-mid-heavy (14B class) as the top reasoning tier on this hardware.
#
# Summary (short prompt, estimated):
#   llama3        cold ~1.5–4 s    warm ~0.3–0.5 s
#   mistral-fast  cold ~0.1–14 s   warm ~0.1–0.2 s
#   qwen-mid      cold ~0.5–5 s    warm ~0.1–0.3 s
#   qwen-mid-heavy cold ~4–8 s     warm ~0.3–0.8 s
#   embed-local   ~0.6–0.9 s per request
#
# Full agent bundle on qwen-mid-heavy: warm ~45–90 s; avoid cold swaps during runs.

model_list:
  # ---------------------------------------------------------------------------
  # Tier 1 — Fast (~6 GB). Cron/SOP automation; pair with embed-local.
  # 32 GB: keep as default always-on chat tier when not running mid-heavy jobs.
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
        cron-driven SOP agents and bulk operator tasks.
      metadata:
        category: fast_automation
        ram_gb_estimate: 6
        mac_studio_32gb: "default-always-on tier; pair with embed-local"
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
        mac_studio_32gb: "light tier; swap in when JSON reliability matters"
        dashboard_purposes:
          - HEARTBEAT_PLANNING
        business_use_cases:
          - facilities issue severity scoring and vendor routing
          - Wi-Fi/AV diagnostic flowcharts with structured next steps
          - escalation metadata extraction (aligned with operator stack Zod schemas)
          - local model fitness eval (structured triage scenarios)
          - cron heartbeat planning from heartbeat schedule files

  # ---------------------------------------------------------------------------
  # Tier 3 — Mid / daily driver (~5 GB). Primary workhorse on 32 GB Studio.
  # Prefer this over mid-heavy for most markdown-based agents.
  # ---------------------------------------------------------------------------
  - model_name: qwen-mid
    litellm_params:
      model: ollama/qwen2.5:7b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Primary workhorse for sales automation and member-facing draft quality.
        Handles rewrite/summary, outreach copy, onboarding sequences, and
        proposal scaffolding without 14B+ load times.
      metadata:
        category: sales_and_member_comms
        ram_gb_estimate: 5
        mac_studio_32gb: "recommended daily-driver; unload before mid-heavy batch jobs"
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
  # Tier 4 — Heavy reasoning (~9 GB). Top tier on 32 GB; replaces 32B models.
  # Unload qwen-mid and llama3 before batch runs. Do not use qwen2.5:32b here.
  # ---------------------------------------------------------------------------
  - model_name: qwen-mid-heavy
    litellm_params:
      model: ollama/qwen2.5:14b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Maximum practical reasoning tier on 32 GB unified memory. Use for
        revenue analysis, executive reporting, and long-document workflows that
        would use qwen-heavy on 64 GB+ hardware. Unload other chat models first.
      metadata:
        category: heavy_reasoning
        ram_gb_estimate: 9
        mac_studio_32gb: "batch tier only; replaces qwen-heavy/glm-heavy from 64 GB config"
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
  # Embeddings (~0.3 GB). Always-on; safe alongside llama3 or qwen-mid.
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
        mac_studio_32gb: "always-on; negligible RAM vs chat models"
        business_use_cases:
          - semantic search over SOP library and agent resources
          - RAG for lead/member context retrieval
          - agent memory and workspace recall
          - deduplication and CRM hygiene similarity matching

general_settings:
  master_key: YOUR_PASSWORD
```
