# LiteLLM + Ollama on Mac Studio 64 GB

This guide is for a **Mac Studio** with **64 GB** unified memory. It defines a LiteLLM proxy configuration that routes agent requests to local Ollama models, tuned for desktop workloads (May 2026 benchmarks).

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

- Batch heavy agents back-to-back to pay the cold-load cost once.

## Approximate latency

Ollama loads **one chat model at a time**. **Cold** = first request after a model swap; **warm** = back-to-back on the same model.

### Short prompt

```text
llama3        cold ~1.5–3.6 s   warm ~0.3 s
mistral-fast  cold ~0.1–13 s    warm ~0.1 s   (* cold high only when swapping in)
qwen-mid      cold ~0.5–4 s     warm ~0.1–0.2 s
qwen-heavy    cold ~11–13 s     warm ~0.2 s   ← feels slow; load tax, not inference
glm-heavy     cold ~10–11 s     warm ~1.8 s   (returned empty text in tests — use with caution)
embed-local   ~0.6–0.8 s per request (768-dim vector)
```

### Agent prompt (warm model)

```text
llama3 ~1.5 s   mistral-fast ~0.6–1.5 s   qwen-mid ~0.8–4 s
qwen-heavy ~2–2.5 s   glm-heavy ~1.8–12 s
```

## Best models by use case

| Use case | Model alias | Ollama model | ~RAM | When to use |
| --- | --- | --- | ---: | --- |
| Fast automation | `llama3` | `llama3:8b-text-q5_0` | 6 GB | default-always-on tier; pair with embed-local |
| Structured / JSON | `mistral-fast` | `mistral:latest` | 4 GB | light tier; swap in when JSON reliability matters |
| Sales & member comms | `qwen-mid` | `qwen2.5:7b` | 5 GB | recommended daily-driver; leaves headroom for DB + dashboard |
| Heavy reasoning | `qwen-heavy` | `qwen2.5:32b` | 19 GB | batch/heavy tier; unload other large models first |
| Heavy reasoning (alt) | `glm-heavy` | `glm-4.7-flash:latest` | 19 GB | hot-swap with qwen-heavy only |
| Embeddings | `embed-local` | `nomic-embed-text:latest` | 0.3 GB | always-on; negligible RAM vs chat models |

### Prompt types used in benchmarks

- **short** — "Reply with exactly one word: ok"
- **agent** — ~80-word multi-turn operator scenario
- **bundle** — full agent context bundle (system + identity + tools + memory)

## config.yaml

Copy this entire block into `config.yaml`:

```yaml
# Mac Studio 64 GB — latency benchmarks (LiteLLM → Ollama, May 2026)
#
# Test prompts:
#   short  — "Reply with exactly one word: ok" (~11 input tokens, max 8 output)
#   agent  — ~80-word multi-turn operator scenario (~40–80 output tokens)
#   bundle — full agent context bundle (system + identity + tools + memory)
#
# Two phases matter — Ollama loads one chat model at a time:
#   cold — first request after swapping from another model (includes ~19 GB load for 32B)
#   warm — back-to-back on the same model (true inference speed)
#
# Summary (short prompt):
#   llama3        cold ~1.5–3.6 s   warm ~0.3 s
#   mistral-fast  cold ~0.1–13 s    warm ~0.1 s   (* cold high only when swapping in)
#   qwen-mid      cold ~0.5–4 s     warm ~0.1–0.2 s
#   qwen-heavy    cold ~11–13 s     warm ~0.2 s   ← feels slow; load tax, not inference
#   glm-heavy     cold ~10–11 s     warm ~1.8 s   (returned empty text in tests — use with caution)
#   embed-local   ~0.6–0.8 s per request (768-dim vector)
#
# Summary (agent prompt, warm model):
#   llama3 ~1.5 s   mistral-fast ~0.6–1.5 s   qwen-mid ~0.8–4 s
#   qwen-heavy ~2–2.5 s   glm-heavy ~1.8–12 s
#
# qwen-heavy agent "Run now" (full bundle + JSON, typical):
#   cold start (Ollama on another model): ~1–4+ min
#   warm (qwen-heavy already loaded):     ~30–45 s
# Batch heavy agents back-to-back to pay the cold-load cost once.

model_list:
  # ---------------------------------------------------------------------------
  # Tier 1 — Fast (~6 GB). High-volume ops automation; keep loaded for cron/SOP
  # agents. Safe to run alongside embed-local on 64 GB Mac Studio.
  #
  # Latency: short cold ~1.5–3.6 s | short warm ~0.3 s | agent warm ~1.5 s
  # Caveat: llama3:8b-text-q5_0 is a base text model — poor instruction following.
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
        mac_studio_64gb: "default-always-on tier; pair with embed-local"
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
  # Tier 2 — Structured (~4 GB). Strong instruction-following and JSON output
  # for triage, severity scoring, and dashboard heartbeat planning.
  #
  # Latency: short cold ~0.1–13 s | short warm ~0.1 s | agent warm ~0.6–1.5 s
  # Cold spike (~13 s) only when Ollama swaps in from another model.
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
        mac_studio_64gb: "light tier; swap in when JSON reliability matters"
        dashboard_purposes:
          - HEARTBEAT_PLANNING
        business_use_cases:
          - facilities issue severity scoring and vendor routing
          - Wi-Fi/AV diagnostic flowcharts with structured next steps
          - escalation metadata extraction (aligned with operator stack Zod schemas)
          - local model fitness eval (structured triage scenarios)
          - cron heartbeat planning from heartbeat schedule files

  # ---------------------------------------------------------------------------
  # Tier 3 — Mid / daily driver (~5 GB). Best balance of quality and speed for
  # sales, member experience, and content drafts. Recommended default for most
  # markdown-based agents on 64 GB hardware.
  #
  # Latency: short cold ~0.5–4 s | short warm ~0.1–0.2 s | agent warm ~0.8–4 s
  # Best quality/speed tradeoff — prefer over qwen-heavy for drafts and SOP runs.
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
        proposal scaffolding without 32B load times. Matches agent
        rewrite/summary workflows and LM Studio guidance (qwen2.5-7b class).
      metadata:
        category: sales_and_member_comms
        ram_gb_estimate: 5
        mac_studio_64gb: "recommended daily-driver; leaves headroom for DB + dashboard"
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
  # Tier 4 — Heavy reasoning (~19 GB). Load one heavy model at a time on 64 GB.
  # Use for revenue analysis, executive reporting, and complex multi-doc reasoning.
  #
  # Latency: short cold ~11–13 s | short warm ~0.2 s | agent warm ~2–2.5 s
  # Full agent bundle (2k–8k input + JSON): warm ~30–45 s; cold ~1–4+ min.
  # Slowness is almost always Ollama loading 19 GB after another model was active.
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
        Unload glm-heavy before loading — only one ~32B model fits comfortably
        alongside macOS and operator stack on 64 GB unified memory.
      metadata:
        category: heavy_reasoning
        ram_gb_estimate: 19
        mac_studio_64gb: "batch/heavy tier; unload other large models first"
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
  # Tier 4 alt — Heavy reasoning (~19 GB). Swap with qwen-heavy; do not load both.
  #
  # Latency: short cold ~10–11 s | short warm ~1.8 s | agent warm ~1.8–12 s
  # Returned empty assistant text in benchmark runs — verify before production use.
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
        mac_studio_64gb: "hot-swap with qwen-heavy only"
        business_use_cases:
          - long SOP and contract document analysis
          - executive reporting with dense tabular context
          - partnership research briefs with citation-style output
          - finance operator briefs when qwen-heavy queue is saturated

  # ---------------------------------------------------------------------------
  # Embeddings (~0.3 GB). Always-on; safe alongside any chat tier.
  #
  # Latency: ~0.6–0.8 s per input string (768-dim vector). Not for chat.
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
        mac_studio_64gb: "always-on; negligible RAM vs chat models"
        business_use_cases:
          - semantic search over SOP library and agent resources
          - RAG for lead/member context retrieval
          - agent memory and workspace recall
          - deduplication and CRM hygiene similarity matching

general_settings:
  master_key: YOUR_PASSWORD
```
