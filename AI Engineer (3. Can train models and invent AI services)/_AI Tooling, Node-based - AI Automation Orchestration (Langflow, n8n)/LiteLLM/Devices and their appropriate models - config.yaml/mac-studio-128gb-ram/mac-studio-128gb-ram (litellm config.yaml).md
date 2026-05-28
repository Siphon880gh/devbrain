# LiteLLM + Ollama on Mac Studio 128 GB

This guide is for a **Mac Studio** with **128 GB** unified memory. It defines a LiteLLM proxy configuration that routes agent requests to local Ollama models, tuned for desktop workloads (May 2026 benchmarks).

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
ollama pull qwen2.5:32b
ollama pull qwen2.5:72b
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

- 128 GB headroom: macOS + operator stack + DB can stay resident while swapping 32B models.
- Ollama still loads one chat model at a time by default — batch jobs, not concurrency.
- Optional: run a second Ollama instance on another port for parallel mid + heavy tiers.

## Approximate latency

Ollama loads **one chat model at a time**. **Cold** = first request after a model swap; **warm** = back-to-back on the same model.

### Short prompt

```text
llama3        cold ~1.2–3 s     warm ~0.25–0.35 s
mistral-fast  cold ~0.1–10 s    warm ~0.08–0.15 s
qwen-mid      cold ~0.4–3 s     warm ~0.08–0.18 s
qwen-heavy    cold ~8–11 s      warm ~0.15–0.25 s
glm-heavy     cold ~8–10 s      warm ~1.5–2 s
qwen-ultra    cold ~25–45 s     warm ~0.6–1.2 s   (72B; AC-equivalent always)
embed-local   ~0.5–0.7 s per request
```

## Best models by use case

| Use case | Model alias | Ollama model | ~RAM | When to use |
| --- | --- | --- | ---: | --- |
| Fast automation | `llama3` | `llama3:8b-text-q5_0` | 6 GB | always-on tier; minimal swap pressure with embed-local |
| Structured / JSON | `mistral-fast` | `mistral:latest` | 4 GB | light tier; fast swap even after 32B sessions |
| Sales & member comms | `qwen-mid` | `qwen2.5:7b` | 5 GB | recommended daily-driver; ample headroom for DB + dashboard + 32B |
| Heavy reasoning | `qwen-heavy` | `qwen2.5:32b` | 19 GB | primary heavy tier; schedule batch windows, not hot-swap under load |
| Heavy reasoning (alt) | `glm-heavy` | `glm-4.7-flash:latest` | 19 GB | hot-swap with qwen-heavy; verify output before production |
| Ultra-heavy reasoning | `qwen-ultra` | `qwen2.5:72b` | 42 GB | exclusive to 128 GB; schedule batch windows, never cron |
| Embeddings | `embed-local` | `nomic-embed-text:latest` | 0.3 GB | always-on; negligible RAM vs chat models |

### Prompt types used in benchmarks

- **short** — "Reply with exactly one word: ok"
- **agent** — ~80-word multi-turn operator scenario
- **bundle** — full agent context bundle (system + identity + tools + memory)

## config.yaml

Copy this entire block into `config.yaml`:

```yaml
# Mac Studio 128 GB — latency benchmarks (LiteLLM → Ollama, May 2026)
#
# Test prompts:
#   short  — "Reply with exactly one word: ok" (~11 input tokens, max 8 output)
#   agent  — ~80-word multi-turn operator scenario (~40–80 output tokens)
#   bundle — full agent context bundle (system + identity + tools + memory)
#
# 128 GB headroom: macOS + operator stack + DB can stay resident while swapping 32B models.
# Ollama still loads one chat model at a time by default — batch jobs, not concurrency.
# Optional: run a second Ollama instance on another port for parallel mid + heavy tiers.
#
# Summary (short prompt, vs 64 GB — similar inference, faster cold loads under memory pressure):
#   llama3        cold ~1.2–3 s     warm ~0.25–0.35 s
#   mistral-fast  cold ~0.1–10 s    warm ~0.08–0.15 s
#   qwen-mid      cold ~0.4–3 s     warm ~0.08–0.18 s
#   qwen-heavy    cold ~8–11 s      warm ~0.15–0.25 s
#   glm-heavy     cold ~8–10 s      warm ~1.5–2 s
#   qwen-ultra    cold ~25–45 s     warm ~0.6–1.2 s   (72B; AC-equivalent always)
#   embed-local   ~0.5–0.7 s per request
#
# qwen-heavy agent bundle: warm ~25–40 s; cold ~45–90 s (less swap thrashing than 64 GB).
# qwen-ultra agent bundle: warm ~70–120 s — use for executive analysis, not cron.

model_list:
  # ---------------------------------------------------------------------------
  # Tier 1 — Fast (~6 GB). High-volume ops automation; safe always-on with embed.
  # 128 GB: can leave llama3 resident while developing; still one Ollama chat slot.
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
        mac_studio_128gb: "always-on tier; minimal swap pressure with embed-local"
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
        mac_studio_128gb: "light tier; fast swap even after 32B sessions"
        dashboard_purposes:
          - HEARTBEAT_PLANNING
        business_use_cases:
          - facilities issue severity scoring and vendor routing
          - Wi-Fi/AV diagnostic flowcharts with structured next steps
          - escalation metadata extraction (aligned with operator stack Zod schemas)
          - local model fitness eval (structured triage scenarios)
          - cron heartbeat planning from heartbeat schedule files

  # ---------------------------------------------------------------------------
  # Tier 3 — Mid / daily driver (~5 GB). Default for most agent agents.
  # 128 GB: comfortable co-residency with heavy tier in unified memory between swaps.
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
        proposal scaffolding without 32B load times.
      metadata:
        category: sales_and_member_comms
        ram_gb_estimate: 5
        mac_studio_128gb: "recommended daily-driver; ample headroom for DB + dashboard + 32B"
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
  # Tier 4 — Heavy reasoning (~19 GB). Primary 32B tier; same models as 64 GB Studio.
  # 128 GB: cold loads less likely to evict DB/cache; batch multiple heavy agents in sequence.
  # ---------------------------------------------------------------------------
  - model_name: qwen-heavy
    litellm_params:
      model: ollama/qwen2.5:32b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Heaviest local reasoning tier for complex sales/revenue workflows, long
        document analysis, multilingual tasks, and local agent gateway default chat.
        On 128 GB, swap from qwen-mid without starving the operator stack.
      metadata:
        category: heavy_reasoning
        ram_gb_estimate: 19
        mac_studio_128gb: "primary heavy tier; schedule batch windows, not hot-swap under load"
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
  # Tier 4 alt — Heavy reasoning (~19 GB). Hot-swap with qwen-heavy.
  # ---------------------------------------------------------------------------
  - model_name: glm-heavy
    litellm_params:
      model: ollama/glm-4.7-flash:latest
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Alternative 32B-class model for long-context document analysis and
        complex reasoning when qwen-heavy is busy or underperforming on a task.
        Same memory budget as qwen-heavy — treat as hot-swap, not concurrent.
      metadata:
        category: heavy_reasoning_alt
        ram_gb_estimate: 19
        mac_studio_128gb: "hot-swap with qwen-heavy; verify output before production"
        business_use_cases:
          - long SOP and contract document analysis
          - executive reporting with dense tabular context
          - partnership research briefs with citation-style output
          - finance operator briefs when qwen-heavy queue is saturated

  # ---------------------------------------------------------------------------
  # Tier 5 — Ultra-heavy (~42 GB). Only viable on 128 GB-class unified memory.
  # Reserve for executive analysis, deep multi-doc reasoning, and "best quality"
  # passes where qwen-heavy plateaus. Schedule batch windows; do not hot-swap.
  # ---------------------------------------------------------------------------
  - model_name: qwen-ultra
    litellm_params:
      model: ollama/qwen2.5:72b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Highest-quality local reasoning tier available on 128 GB Mac Studio. Use
        for board-level memos, full-quarter executive briefs, and local agent runtime deep
        research where qwen-heavy quality is insufficient. Long cold loads — keep
        loaded across a batch window rather than swapping per request.
      metadata:
        category: ultra_reasoning
        ram_gb_estimate: 42
        mac_studio_128gb: "exclusive to 128 GB; schedule batch windows, never cron"
        business_use_cases:
          - board-level executive memos and quarterly leadership briefs
          - full SOP library diff with policy reasoning
          - partnership and M&A research dossiers
          - deep billing reconciliation and revenue narrative
          - flagship proposal rewrites for high-ACV deals
          - long-context multilingual reasoning beyond qwen-heavy quality

  # ---------------------------------------------------------------------------
  # Embeddings (~0.3 GB). Always-on alongside any chat tier.
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
        mac_studio_128gb: "always-on; negligible RAM vs chat models"
        business_use_cases:
          - semantic search over SOP library and agent resources
          - RAG for lead/member context retrieval
          - agent memory and workspace recall
          - deduplication and CRM hygiene similarity matching

general_settings:
  master_key: YOUR_PASSWORD
```
