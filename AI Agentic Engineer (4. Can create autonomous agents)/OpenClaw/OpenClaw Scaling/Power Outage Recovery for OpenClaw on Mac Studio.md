# Power Outage Recovery for OpenClaw on Mac Studio

A Mac Studio running OpenClaw is only useful if it comes back online after a power cut, brownout, or accidental unplug. Recovery happens in two layers:

1. **Hardware power recovery** — the Mac turns on again when power returns
2. **Software stack recovery** — Ollama, LiteLLM, OpenClaw, and related services start again after macOS boots

You need both.

---

## Layer 1: Make the Mac Power On After an Outage

### Option A — System Settings (newer desktop Macs)

On supported Mac Studio, Mac mini, and iMac models with recent macOS versions (Tahoe 26.5 or later), Apple provides a setting called **Start up when power is connected**.

Path:

```text
Apple menu → System Settings → Energy → Start up when power is connected → Always
```

![[Pasted image 20260527030334.png]]
Note your OS may differ in settings. For example, Tahoe 26.3.1 looks like:
![[Pasted image 20260527030632.png]]

When this is enabled, the Mac should turn on automatically when:
- power returns after an outage
- the machine is plugged back into power
- an external power switch or smart plug restores power

Apple documents hardware and macOS version requirements for this feature. If the setting is missing, your model or OS build may not support it. Not having an "Energy" option on the left sidebar at System Settings despite having updated the OS means your machine does not support this feature. Here is a left sidebar that does have "Energy" option:
![[Pasted image 20260527030841.png]]

### Option B — `pmset autorestart` (older or alternate setups)

On many Intel and Apple Silicon Macs, you can also enable automatic restart after power loss with:

```bash
sudo pmset autorestart 1
```

Check current values with:

```bash
pmset -g custom
```

Look for `autorestart` set to `1`.

This is a long-standing macOS power-management option and is still useful when the newer Energy setting is unavailable.

---

## Layer 2: Make the OpenClaw Stack Start After Login

Power recovery only gets you to the macOS login screen or desktop. It does not automatically restart Ollama, LiteLLM, or OpenClaw.

For that, use the startup automation pattern already documented in this coder notebook:

- [[Startup Script for Stack OpenClaw-LiteLLM-Ollama (Optional Tailscale)]]
- [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]]
- [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]]

The recommended approach is:

- a shell startup script that opens Terminal tabs
- one tab per major service
- a LaunchAgent that runs the script at login

That gives you visible tabs for Ollama, LiteLLM, optional Tailscale, OpenClaw gateway restart, and OpenClaw TUI management.

---

## Why Visible Terminal Tabs Matter

You could hide everything in background daemons, but for an OpenClaw stack it is usually better to boot into visible Terminal tabs because:

- failed commands are obvious immediately
- you can restart one service without touching the whole stack
- logs stay in the tab where the process was launched
- debugging after an outage is much faster

This matches the approach in [[Startup Script for Stack OpenClaw-LiteLLM-Ollama (Optional Tailscale)]].

---

## Login Timing Matters

LaunchAgents run at user login. That means outage recovery also depends on how the Mac reaches a logged-in session.

Consider:

- **Automatic login** — fastest recovery, but less secure on shared or client-facing machines
- **Standard login** — safer, but something or someone must sign in before the stack starts
- **Remote access** — tools like Chrome Remote Desktop or Tailscale SSH can help you sign in or inspect the machine after it returns online

If OpenClaw must recover unattended, decide intentionally whether the service account should auto-login.

---

## Recommended Recovery Stack

For a Mac Studio intended to run OpenClaw 24/7:

### 1. Enable hardware auto power-on

Use **Start up when power is connected** if available. Otherwise use:

```bash
sudo pmset autorestart 1
```

### 2. Ensure the service account can reach a logged-in session

Pick one:

- dedicated automation user with controlled auto-login
- MDM-managed login policy
- remote access path for manual login after rare outages

### 3. Install the LaunchAgent startup script

Use the drop-in patterns from:

- [[Startup Script for Stack OpenClaw-LiteLLM-Ollama (Optional Tailscale)]]
- [[Loading and Unloading LaunchAgents with launchctl]]

Typical flow:

```text
Login
  → LaunchAgent runs startup script
  → Terminal opens
  → Tab 1: ollama serve
  → Tab 2: litellm --config ...
  → Tab 3: optional tailscale serve
  → Tab 4: openclaw gateway restart
  → Tab 5: openclaw tui
```

### 4. Approve macOS privacy permissions once

On first deploy, accept Accessibility and Automation prompts, or deploy MDM PPPC profiles. See [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]].

### 5. Reboot test and outage simulation test

Run both tests:

**Reboot test**

```bash
sudo reboot
```

After login, confirm every tab came up and OpenClaw responds.

**Outage simulation**

1. Confirm the stack is healthy
2. Unplug power or switch off the outlet
3. Wait briefly
4. Restore power
5. Confirm the Mac powers on, reaches login, and the LaunchAgent restarts the stack

---

## Failure Modes to Watch For

| Symptom | Likely cause |
|---|---|
| Mac stays off after power returns | Hardware auto power-on not enabled, or unsupported model |
| Mac turns on but stack never starts | No user login yet, or LaunchAgent not loaded |
| Terminal opens empty | AppleScript permissions missing |
| Some tabs start, others do not | Startup delays too short, or earlier service failed |
| OpenClaw gateway up but no models | Ollama or LiteLLM tab failed first |

When a service fails early in the chain, later tabs may look fine while the stack is still broken. Always inspect tabs in order.

---

## Optional Hardening

Once basic recovery works, you can add lightweight checks:

- a banner line in the startup script showing reload time
- a health-check curl against LiteLLM before starting OpenClaw
- a final tab that tails OpenClaw or Ollama logs
- external uptime monitoring through Tailscale or another network path

The startup sequence article already suggests echoing a reload timestamp so you can tell whether the latest boot actually ran the script.

---

## Minimum Production Standard

For an OpenClaw Mac Studio that should survive ordinary infrastructure failures, treat these as baseline requirements:

- [ ] automatic power-on after power loss
- [ ] predictable login path after reboot
- [ ] LaunchAgent-based startup script installed
- [ ] privacy permissions approved or MDM-managed
- [ ] successful reboot test
- [ ] successful power-loss simulation test

Without those, a power outage becomes a manual recovery task even if the hardware itself is fine.

---

## Related Articles

- [[Startup Script for Stack OpenClaw-LiteLLM-Ollama (Optional Tailscale)]]
- [[_PRIMER - Openclaw-LiteLLM-Ollama Startup Sequence, Optional Tailscale]]
- [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]]
- [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]]
- [[_PRIMER - OpenClaw Scaling]]
