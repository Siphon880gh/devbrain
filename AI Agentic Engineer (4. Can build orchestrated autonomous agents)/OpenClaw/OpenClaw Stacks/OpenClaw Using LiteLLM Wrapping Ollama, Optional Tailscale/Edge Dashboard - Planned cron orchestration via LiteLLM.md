## Intent

The edge dashboard will be a Node.js (and Dockerized Postgres) wrapper in front of LiteLLM. It becomes the **cron / scheduling brain** for operator workflows: which agent runs when, against which LiteLLM alias, with what payload—without exposing OpenClaw’s gateway to the network.

 If you choose to have OpenClaw TUI running, the OpenClaw's cronjobs/heart beats can just deal with improving skills and md files over time. That way there is a separation of concern. If you distribute the dashboard to other people in your organization, you can abstract away the OpenClaw complexity and have the dashboard as the scheduler and management place for your agents and automations. 

```text
Edge Dashboard (cron + UI)
        ↓ HTTP + Bearer token
LiteLLM :4000  (only remote-safe inference edge)
        ↓
Ollama models

OpenClaw (the central local machine only)
  → TUI, gateway, workspaces, HEARTBEAT.md, native cron as backup
```

---

## Division of responsibility

| Component          | Responsibility                                                                                                                       |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------------------ |
| **Edge Dashboard** | Schedules, dashboards, Postgres job history, human-facing “which agent now”. Think business automation.                              |
| **LiteLLM**        | Model routing, OpenAI-compatible API, auth at port 4000                                                                              |
| **OpenClaw**       | Agent runtime on the Mac: tools, memory files, channels, gateway cron, heartbeats. Think under-the-hood agent and skills management. |
| **Tailscale**      | Optional exposure of **4000 only**; token required                                                                                   |

OpenClaw’s built-in cron (Gateway scheduler) can still run local housekeeping. The dashboard is the **external orchestration layer** for cross-app and remote-triggered work—aligned with [[Caveat - OpenClaw Needs an Orchestration Layer]].

---

## Security rule

Outside clients must **not** talk directly to OpenClaw. They call LiteLLM (or the dashboard, which calls LiteLLM). OpenClaw stays reachable via localhost, SSH tunnel, or remote desktop for admin work — [[Wire OpenClaw to LiteLLM provider - models.json and openclaw.json]].

---

## Startup script reminder

When the dashboard exists, extend the agentic stack echo — see [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]] — to include `docker compose up` and `npm run dev` checks for dashboard agents.

---

## Related

- [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]]
- [[Wire OpenClaw to LiteLLM provider - models.json and openclaw.json]]
- [[Caveat - OpenClaw Needs an Orchestration Layer]]
- [[Heart Beats in OpenClaw]]
- [[_PRIMER - OpenClaw]] (cron vs heartbeat)
