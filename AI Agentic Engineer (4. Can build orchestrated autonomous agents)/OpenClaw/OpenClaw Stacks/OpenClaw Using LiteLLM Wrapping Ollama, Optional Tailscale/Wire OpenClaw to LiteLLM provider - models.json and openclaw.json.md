# Wire OpenClaw to LiteLLM provider

This note is the **configuration bridge** between the LiteLLM stack and OpenClaw. Startup order lives in [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]]. LiteLLM aliases and `config.yaml` live under [[Devices and their appropriate models - config.yaml]].

---

## Layered mental model

```text
Ollama (CLI + :11434)
  → pull, serve, and load real model weights

LiteLLM (:4000)
  → wraps Ollama models as OpenAI-compatible aliases (llama3, qwen-mid, …)
  → standardizes requests to /v1/chat/completions

OpenClaw (~/.openclaw)
  → agents call the litellm provider, not Ollama directly
  → gateway, TUI, workspaces, heartbeats, cron stay local

Tailscale serve 4000 (optional)
  → remote clients hit LiteLLM only (Bearer token required)
  → no direct remote entry to OpenClaw gateway (security boundary)
```

OpenClaw does **not** replace Ollama or LiteLLM. It consumes LiteLLM’s model list the same way any OpenAI-compatible client would.

---

## What lives where

| Path | Role |
| --- | --- |
| `~/.openclaw/openclaw.json` | Global defaults: primary model (`litellm/<alias>`), workspaces, auth |
| `~/.openclaw/agents/<agent>/agent/models.json` | Per-agent provider registry (can mirror or override global) |
| `~/litellm/config.yaml` | LiteLLM `model_list` aliases → `ollama/...` backends |
| Ollama | Models referenced inside LiteLLM config only |

Use **LiteLLM alias names** in OpenClaw (`llama3`, `qwen-mid`), not raw Ollama tags (`llama3:8b-text-q5_0`), unless you intentionally bypass LiteLLM.

---

## Prerequisites

1. Ollama is running and models from your device `config.yaml` are pulled — see [[Devices and their appropriate models (Shortcut)]].
2. LiteLLM proxy is up: `litellm --config ~/litellm/config.yaml`
3. Curl test passes — [[_ Common - Interact with model]]
4. `general_settings.master_key` in `config.yaml` is set; use that value as the bearer token everywhere.

List aliases LiteLLM exposes:

```bash
curl http://localhost:4000/v1/models -H "Authorization: Bearer YOUR_PASSWORD"
```

---

## Option A — Onboarding wizard

During `openclaw onboard`:

1. Choose **LiteLLM** as the model/auth provider.
2. **API key** = `master_key` from `~/litellm/config.yaml` (`general_settings.master_key`).
3. **Base URL** = `http://localhost:4000` (default LiteLLM port; OpenClaw uses the OpenAI-compatible `/v1` surface).
4. **Default model** = enter manually as `litellm/<alias>` (e.g. `litellm/qwen-mid`), matching a `model_name` from your LiteLLM `model_list`.

Non-interactive example:

```bash
openclaw onboard --non-interactive --accept-risk \
  --auth-choice litellm-api-key \
  --litellm-api-key "YOUR_PASSWORD" \
  --custom-base-url "http://localhost:4000" \
  --install-daemon --skip-channels --skip-skills
```

Official reference: [OpenClaw LiteLLM provider](https://documentation.openclaw.ai/providers/litellm), [LiteLLM OpenClaw tutorial](https://docs.litellm.ai/docs/tutorials/openclaw_integration).

---

## Option B — Edit `openclaw.json` directly

Add a `litellm` provider and point the default agent at one alias. Expand the `models` array with every alias you defined in LiteLLM `config.yaml`.

```json
{
  "models": {
    "providers": {
      "litellm": {
        "baseUrl": "http://localhost:4000",
        "apiKey": "${LITELLM_API_KEY}",
        "api": "openai-completions",
        "models": [
          {
            "id": "llama3",
            "name": "llama3 (fast tier)",
            "reasoning": false,
            "input": ["text"],
            "contextWindow": 131072,
            "maxTokens": 8192
          },
          {
            "id": "qwen-mid",
            "name": "qwen-mid (daily driver)",
            "reasoning": false,
            "input": ["text"],
            "contextWindow": 131072,
            "maxTokens": 8192
          },
          {
            "id": "qwen-heavy",
            "name": "qwen-heavy (batch reasoning)",
            "reasoning": true,
            "input": ["text"],
            "contextWindow": 131072,
            "maxTokens": 8192
          }
        ]
      }
    }
  },
  "agents": {
    "defaults": {
      "model": {
        "primary": "litellm/qwen-mid"
      }
    }
  }
}
```

Store the real key in the environment instead of the file when possible:

```bash
export LITELLM_API_KEY="YOUR_PASSWORD"
```

Switch the active default without editing the full provider block:

```bash
openclaw models set litellm/qwen-mid
```

After edits, restart the gateway — [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]] step 5.

---

## Per-agent `models.json`

Same provider shape under:

```text
~/.openclaw/agents/<agent_name>/agent/models.json
```

Use this when one agent should use a different LiteLLM alias set than `main`. See [[An Agent and what models it can use - models.json]].

Pattern:

```text
provider key: litellm
baseUrl:      http://localhost:4000
api:          openai-completions
model id:     <LiteLLM model_name alias>
primary:      litellm/<alias>   (in openclaw.json or agent config)
```

---

## Expanding the model list

When you add rows to LiteLLM `model_list` in `config.yaml`:

1. `ollama pull` the backing model.
2. Restart or reload LiteLLM.
3. Confirm with `curl …/v1/models`.
4. Add a matching entry under `models.providers.litellm.models` in OpenClaw.
5. Route agents with `litellm/<new-alias>` — [[_Fundamental - OpenClaw Model Routing - Use the RIght Model for the Right Job]].

Shortcut workflow: [[Devices and their appropriate models (Shortcut)]].

---

## Security boundary (local vs remote)

| Surface | Who reaches it | Notes |
| --- | --- | --- |
| OpenClaw gateway / TUI | Local machine (or SSH tunnel / Remote Desktop) | Admin surface; do not expose publicly — [[_PRIMER - OpenClaw]] |
| LiteLLM `:4000` | Local + optional Tailscale | **Only** exposed inference entry; always pass `Authorization: Bearer` |
| Ollama `:11434` | Local only | Behind LiteLLM; not the public edge |

Remote apps and dashboards should call **LiteLLM**, not the OpenClaw gateway port. OpenClaw remains the on-host operator layer (files, heartbeats, agent workspaces).

Tailscale:

```bash
tailscale serve 4000
```

Test with the Tailscale hostname and the same bearer token — [[_ Common - Interact with model]].

---

## Troubleshooting

| Symptom | Likely cause |
| --- | --- |
| OpenClaw “model not found” | `id` in OpenClaw ≠ `model_name` in LiteLLM `config.yaml` |
| 401 from LiteLLM | Wrong or missing `master_key` / bearer token |
| Tools fail on local model | Model too small or wrong tier — [[_Fundamental - OpenClaw Default Model Must Know How to Use Tools]] |
| Works in curl, fails in OpenClaw | LiteLLM not running before `openclaw gateway restart` |
| Remote works, local fails | Tailscale serve not up or wrong port |

---

## Related

- [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]]
- [[0. _PRIMER - LiteLLM Server vs Python Library]]
- [[Configure Default Model - openclaw.json]]
- [[An Agent and what models it can use - models.json]]
- [[Edge Dashboard - Planned cron orchestration via LiteLLM]]
