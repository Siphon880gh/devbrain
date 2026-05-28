# OpenClaw Scaling: From One Mac Studio to Many

As your business clients or internal automation workloads grow, a single Mac Studio running OpenClaw may stop being enough. You may need more local inference capacity, more isolated agent environments, or dedicated machines for different teams or workflows.

Scaling OpenClaw on Apple hardware usually means adding more Mac Studios (or Mac minis) rather than turning one machine into a giant shared server farm. Each machine can run its own OpenClaw gateway, Ollama instance, LiteLLM proxy, and supporting stack.

---

## When Scaling Makes Sense

Consider adding another Mac when you hit one or more of these limits:

- **Model capacity** — One machine cannot comfortably run the models you need at the same time.
- **Agent isolation** — Different clients or teams need separate workspaces, credentials, and uptime guarantees.
- **Operational separation** — Production agents should not share CPU, RAM, or disk with experimental agents.
- **Geographic or network placement** — You want inference closer to a user group, office, or integration endpoint.
- **Failure isolation** — One outage or bad deploy should not take down every agent.

OpenClaw scales horizontally at the machine level: more hosts, more gateways, more stacks.

---

## Typical Scaling Pattern

A practical pattern looks like this:

```text
Mac Studio A
  → Ollama
  → LiteLLM
  → OpenClaw gateway + agents for Team A

Mac Studio B
  → Ollama
  → LiteLLM
  → OpenClaw gateway + agents for Team B

Optional cloud APIs
  → Frontier models for tasks local hardware cannot handle
```

Each machine follows the same general architecture described in:

- [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]]
- [[Startup Script for Stack OpenClaw-LiteLLM-Ollama (Optional Tailscale)]]
- [[Multiple Agents in Gateway - Single Gateway vs Separate Gateways]]

On a single host, you can often run multiple agents inside one gateway. When you scale to multiple Macs, you usually give each machine its own gateway and stack.

---

## What Changes When You Add Machines

Copying config files is the easy part. The harder parts are:

1. **macOS privacy permissions** — Startup scripts that open Terminal tabs and control other apps do not port cleanly. Each Mac needs its own permission approvals, or MDM-managed privacy profiles. See [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]].

2. **Power and boot recovery** — A Mac Studio only helps if it turns back on and relaunches your stack after an outage. See [[Power Outage Recovery for OpenClaw on Mac Studio]].

3. **Network access** — Decide whether LiteLLM, Tailscale, or another entry point exposes inference to other machines. See [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]].

4. **Remote administration** — Plan how you will reach each machine for logs, restarts, and debugging without exposing the OpenClaw dashboard publicly.

---

## Deployment Checklist for Each New Mac

Use this checklist when onboarding another Mac Studio:

- [ ] Install macOS and create the service user account
- [ ] Install Ollama, LiteLLM, OpenClaw, and any stack dependencies
- [ ] Copy or regenerate config (`openclaw.json`, LiteLLM config, agent workspaces)
- [ ] Set up startup automation with LaunchAgents and AppleScript
- [ ] Grant macOS privacy permissions manually, or deploy MDM Privacy Preferences Policy Control profiles
- [ ] Enable automatic power-on after outage where hardware supports it
- [ ] Test full stack boot after reboot
- [ ] Test full stack boot after simulated power loss
- [ ] Document hostname, Tailscale name, ports, and which agents live on the machine

---

## Related Articles

- [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]]
- [[Loading and Unloading LaunchAgents with launchctl]]
- [[Directory - Frontier-level reasoning model online providers]]
- [[_PRIMER - OpenClaw]]
