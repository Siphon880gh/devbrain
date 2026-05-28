# LiteLLM + Ollama on MacBook Pro 16 GB (base M3 / M4)

This guide is for a **MacBook Pro** with **16 GB** unified memory. It defines a LiteLLM proxy configuration that routes agent requests to local Ollama models, tuned for laptop workloads (May 2026 benchmarks).

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
ollama pull llama3.2:3b
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

- Memory budget: ~6–8 GB macOS + browser + operator stack leaves ~8–10 GB peak for one model.
- Ollama loads one chat model at a time. Close Slack, Chrome, and Xcode before swaps.
- Do not load qwen2.5:14b, 32b, or glm-4.7-flash on this hardware.
- use qwen-mid for drafts in short sessions. Full agent bundles → Mac Studio or cloud.
- Operational rule: one chat tier + embed-local only. Prefer mistral-fast for JSON cron;

## Approximate latency

Ollama loads **one chat model at a time**. **Cold** = first request after a model swap; **warm** = back-to-back on the same model.

### Short prompt

```text
llama3        cold ~1–3 s      warm ~0.2–0.4 s   (llama3.2:3b instruct, ~2 GB)
mistral-fast  cold ~0.3–20 s   warm ~0.25–0.5 s
qwen-mid      cold ~1–10 s     warm ~0.3–0.7 s   (close other apps first)
embed-local   ~0.9–1.5 s per request
```

## Best models by use case

| Use case | Model alias | Ollama model | ~RAM | When to use |
| --- | --- | --- | ---: | --- |
| Fast automation | `llama3` | `llama3.2:3b` | 2 GB | safe always-on chat tier; pair with embed-local |
| Structured / JSON | `mistral-fast` | `mistral:latest` | 4 GB | recommended default with dashboard open; lowest RAM chat tier |
| Sales & member comms | `qwen-mid` | `qwen2.5:7b` | 5 GB | focused draft sessions only; not for concurrent heavy apps |
| Embeddings | `embed-local` | `nomic-embed-text:latest` | 0.3 GB | always-on; primary intelligence path on 16 GB (RAG + small chat) |

### Prompt types used in benchmarks

- **short** — "Reply with exactly one word: ok"
- **agent** — ~80-word multi-turn operator scenario
- **bundle** — full agent context bundle (system + identity + tools + memory)

## config.yaml

Copy this entire block into `config.yaml`:

```yaml
# MacBook Pro 16 GB (base M3 / M4) — laptop guidance (LiteLLM → Ollama, May 2026)
#
# Test prompts (same methodology as other device configs):
#   short  — "Reply with exactly one word: ok"
#   agent  — ~80-word multi-turn operator scenario
#   bundle — full agent context bundle (often impractical on 16 GB — use Studio)
#
# Memory budget: ~6–8 GB macOS + browser + operator stack leaves ~8–10 GB peak for one model.
# Ollama loads one chat model at a time. Close Slack, Chrome, and Xcode before swaps.
# Do not load qwen2.5:14b, 32b, or glm-4.7-flash on this hardware.
#
# Summary (short prompt, estimated):
#   llama3        cold ~1–3 s      warm ~0.2–0.4 s   (llama3.2:3b instruct, ~2 GB)
#   mistral-fast  cold ~0.3–20 s   warm ~0.25–0.5 s
#   qwen-mid      cold ~1–10 s     warm ~0.3–0.7 s   (close other apps first)
#   embed-local   ~0.9–1.5 s per request
#
# Operational rule: one chat tier + embed-local only. Prefer mistral-fast for JSON cron;
# use qwen-mid for drafts in short sessions. Full agent bundles → Mac Studio or cloud.

model_list:
  # ---------------------------------------------------------------------------
  # Tier 1 — Fast (~2 GB). Smallest instruction-tuned tier; safest 16 GB default.
  # llama3.2:3b replaces the 64 GB config's llama3:8b-text-q5_0 — too large and
  # not instruction-tuned for this hardware. 3B fits alongside embed-local and
  # a browser without swapping.
  # ---------------------------------------------------------------------------
  - model_name: llama3
    litellm_params:
      model: ollama/llama3.2:3b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Instruction-tuned small model for routing, templated notifications, and
        light summarization on 16 GB hardware. Safe to keep loaded with embed-local
        while the dashboard and browser stay open.
      metadata:
        category: fast_automation
        ram_gb_estimate: 2
        macbook_pro_16gb: "safe always-on chat tier; pair with embed-local"
        business_use_cases:
          - package pickup notifications
          - daily opening/closing checklist pings
          - Slack/email send confirmation parsing
          - next-day room staging reminders
          - templated tour slot nudges (no negotiation copy)

  # ---------------------------------------------------------------------------
  # Tier 2 — Structured (~4 GB). Best default for JSON agents on 16 GB RAM.
  # Lowest swap risk while operator stack dashboard is open.
  # ---------------------------------------------------------------------------
  - model_name: mistral-fast
    litellm_params:
      model: ollama/mistral:latest
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Compact model for structured automation on memory-constrained laptops.
        Preferred 16 GB default for structured triage and heartbeat JSON when the
        dashboard and browser must stay open.
      metadata:
        category: structured_automation
        ram_gb_estimate: 4
        macbook_pro_16gb: "recommended default with dashboard open; lowest RAM chat tier"
        dashboard_purposes:
          - HEARTBEAT_PLANNING
        business_use_cases:
          - facilities issue severity scoring and vendor routing
          - Wi-Fi/AV diagnostic flowcharts with structured next steps
          - escalation metadata extraction (aligned with operator stack Zod schemas)
          - lead intake triage with JSON payloads
          - cron heartbeat planning from heartbeat schedule files
          - local model fitness eval (structured triage scenarios)

  # ---------------------------------------------------------------------------
  # Tier 3 — Mid (~5 GB). Quality drafts in short, focused sessions only.
  # Unload mistral-fast/llama3 first; quit heavy apps; avoid full agent bundles.
  # ---------------------------------------------------------------------------
  - model_name: qwen-mid
    litellm_params:
      model: ollama/qwen2.5:7b
      api_base: http://localhost:11434
    model_info:
      mode: chat
      description: >
        Quality tier for sales and member-facing drafts on 16 GB hardware. Use in
        short AC-powered sessions with minimal background apps. Full heavy-reasoning bundle runs should run on Mac Studio or cloud — qwen-mid here
        handles shortened drafts and handoff notes only.
      metadata:
        category: sales_and_member_comms
        ram_gb_estimate: 5
        macbook_pro_16gb: "focused draft sessions only; not for concurrent heavy apps"
        dashboard_purposes:
          - AGENT_SUGGESTION
        business_use_cases:
          - sales lead qualification summaries (short context)
          - tour booking reminder copy
          - member welcome message drafts
          - retention outreach drafts (human review required)
          - marketing copy drafts for editorial review
          - faithful rewrite and summarization (short documents)
          - SOP quiz questions (single module, not full library ingest)
          - dashboard agent-run content recommendations
          - agent gateway TUI / default (keep threads short)

  # ---------------------------------------------------------------------------
  # Embeddings (~0.3 GB). Always-on; primary RAG tier on 16 GB laptops.
  # ---------------------------------------------------------------------------
  - model_name: embed-local
    litellm_params:
      model: ollama/nomic-embed-text:latest
      api_base: http://localhost:11434
    model_info:
      mode: embedding
      description: >
        Local embedding model for semantic search and RAG. On 16 GB, keep this loaded
        and use retrieval + mistral-fast or qwen-mid for answers instead of large chat
        context windows.
      metadata:
        category: embedding
        ram_gb_estimate: 0.3
        macbook_pro_16gb: "always-on; primary intelligence path on 16 GB (RAG + small chat)"
        business_use_cases:
          - semantic search over SOP library and agent resources
          - RAG for lead/member context retrieval (chunk + small model)
          - agent memory and workspace recall
          - deduplication and CRM hygiene similarity matching

general_settings:
  master_key: YOUR_PASSWORD
```
