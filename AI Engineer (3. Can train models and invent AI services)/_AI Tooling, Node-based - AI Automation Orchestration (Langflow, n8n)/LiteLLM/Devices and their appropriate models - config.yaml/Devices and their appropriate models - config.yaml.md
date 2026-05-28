# LiteLLM device guides for Mac

These guides are **LiteLLM proxy configurations** tuned for Apple Silicon Macs. Each one maps a roster of local Ollama models to LiteLLM aliases so your proxy can route requests to the right model for your hardware—maximizing accuracy where it matters without sacrificing responsiveness.

Ollama loads one chat model at a time. Loading a model that is too large for your unified memory causes slow cold starts, swap pressure, and timeouts. Loading one that is too small wastes quality on tasks that need more reasoning. These configs strike that balance: fast tiers for cron and JSON automation, mid tiers for daily drafts, and heavy tiers only where your RAM can support them.

## Pick your guide

| Device | RAM | Guide |
| --- | ---: | --- |
| MacBook Pro | 16 GB | [macbook-pro-16gb-ram.md](macbook-pro-16gb-ram%20(litellm%20config.yaml).md) |
| MacBook Pro | 24 GB | [macbook-pro-24gb-ram.md](macbook-pro-24gb-ram%20(litellm%20config.yaml).md) |
| MacBook Pro | 36 GB | [macbook-pro-36gb-ram.md](macbook-pro-36gb-ram%20(litellm%20config.yaml).md) |
| MacBook Pro | 48 GB | [macbook-pro-48gb-ram.md](macbook-pro-48gb-ram%20(litellm%20config.yaml).md) |
| Mac Studio | 32 GB | [mac-studio-32gb-ram.md](mac-studio-32gb-ram%20(litellm%20config.yaml).md) |
| Mac Studio | 64 GB | [mac-studio-64gb-ram.md](mac-studio-64gb-ram%20(litellm%20config.yaml).md) |
| Mac Studio | 128 GB | [mac-studio-128gb-ram.md](mac-studio-128gb-ram%20(litellm%20config.yaml).md) |

Open the guide that matches your machine. Copy the `config.yaml` block into your LiteLLM project, pull the listed Ollama models, and start the proxy with `litellm --config config.yaml`.

## Before you run

Replace **`YOUR_PASSWORD`** in `general_settings.master_key` with a secure value before starting the proxy. Use that same value as the bearer token when clients connect to LiteLLM.

```yaml
general_settings:
  master_key: YOUR_PASSWORD   # change this
```

## What each guide includes

- Where to save `config.yaml` and how to run LiteLLM with Ollama
- Memory and operational notes for your specific hardware
- Approximate cold/warm latency by model and use case
- A ready-to-copy `config.yaml` with model aliases (`llama3`, `qwen-mid`, `qwen-heavy`, etc.)

## Customize with an AI prompt

Use the prompt below when you want a tailored `config.yaml` for your stack—not just the default guide. Attach or paste your inputs (SOPs, agent definitions, cron jobs, dashboard purposes, sample prompts) and fill in the placeholders.

**Replace these placeholders:**

| Placeholder | What to put |
| --- | --- |
| `YOUR_INPUTS` | SOPs, agent markdown, heartbeat schedules, tool schemas, or any docs that describe what your agents actually do |
| `YOUR_DEVICE` | e.g. `Mac Studio`, `MacBook Pro` |
| `YOUR_RAM` | Unified memory in GB, e.g. `64` |
| `YOUR_PASSWORD` | The `master_key` value you will use for LiteLLM (do not use a real secret in shared chats) |

**Optional:** add `YOUR_BUSINESS_AUTOMATION` and `YOUR_SALES_AUTOMATION` bullets if you want the model explicitly to weigh those workflows.

```
Looking at our inputs below, determine for our YOUR_DEVICE with YOUR_RAM GB RAM what Ollama models we should expose through LiteLLM.

Consider:
- Business automation (cron, SOP agents, structured JSON, notifications, triage)
- Sales automation (drafts, outreach, member comms, proposals, rewrites)
- Responsiveness: Ollama loads one chat model at a time—prefer tiers that fit OUR_RAM without cold-load timeouts
- Accuracy: use heavier models only where inputs show tasks that need long context or deep reasoning

Inputs:
YOUR_INPUTS

Then produce a complete LiteLLM config.yaml that:
1. Maps each model to a clear alias (e.g. llama3, mistral-fast, qwen-mid, qwen-heavy, embed-local)
2. Sets api_base to http://localhost:11434 and model paths as ollama/<model>
3. Includes model_info.description for each entry explaining which agents should use it
4. Includes metadata.business_use_cases listing concrete business use cases from our inputs
5. Uses master_key: YOUR_PASSWORD in general_settings

For each model, note approximate cold/warm latency expectations on OUR_DEVICE + YOUR_RAM GB and when to swap tiers vs keep embed-local always on.
```

If your hardware matches an existing guide, start from that guide’s `config.yaml` and ask the model to adjust aliases, descriptions, and `business_use_cases` to match `YOUR_INPUTS` rather than generating from scratch.
