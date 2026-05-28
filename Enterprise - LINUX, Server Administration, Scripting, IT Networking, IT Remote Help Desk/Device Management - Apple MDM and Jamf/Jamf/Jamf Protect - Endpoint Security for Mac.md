## Jamf Protect — Endpoint Security for Mac

Jamf Protect is Jamf's macOS security analytics and threat detection product. It complements **Jamf Pro** (configuration) by observing runtime behavior on the Mac.

Think of the split as:

| Product | Role |
|---|---|
| **Jamf Pro** | Enforce settings — FileVault, apps, profiles, wipe |
| **Jamf Protect** | Detect suspicious activity — processes, persistence, privilege abuse |

---

## What Jamf Protect Collects

Jamf Protect taps macOS telemetry sources (via Apple's Endpoint Security and related frameworks) to build a unified stream of:

- Process execution and lineage
- Login and authentication events
- Kernel extension / system extension loads (where applicable)
- File and directory operations tied to security rules
- Configuration drift from expected baselines

Data goes to the Jamf Protect cloud console (or can forward to SIEM).

---

## Common Use Cases

| Use case | Example |
|---|---|
| Threat hunting | Find unsigned binaries launching from `/tmp` |
| Compliance reporting | Prove logging and monitoring on all Macs |
| Incident response | Trace how malware persisted after user click |
| CIS / NIST alignment | Monitor controls around privilege and system changes |
| Executive protection | Jamf Executive Threat Protection tier for high-risk users |

Protect does **not** replace a full EDR suite in every environment, but it is a strong fit for Mac-native shops already on Jamf.

---

## Deployment Pattern

Typical rollout:

```text
Jamf Pro policy on enrollment
  → Install Jamf Protect plan (PKG/agent)
  → Agent registers to Jamf Protect tenant
  → Analytics appear in Protect console
```

Scope the install policy to the same smart groups as your Mac baseline. Verify agent check-in before declaring fleet coverage.

---

## Relationship to MDM Baselines

Protect observes; Pro enforces. Example combined posture:

```text
Jamf Pro
  → Block unsigned kernel extensions (profile)
  → Require FileVault
  → Restrict USB storage
  → Deploy browser and OS patches

Jamf Protect
  → Alert on suspicious LaunchAgent/Daemon creation
  → Alert on tampering with security tools
  → Forward events to Splunk / Sentinel
```

For automation-heavy fleets, also review [[PPPC - Pre-Approving macOS Automation Permissions with MDM]] so legitimate LaunchAgents are not flagged as unknown persistence (tune alerts accordingly).

---

## vs. Microsoft Defender for Endpoint on Mac

Organizations on **Intune** often use **Microsoft Defender for Endpoint** on Mac instead of Jamf Protect. Mixed environments sometimes run Jamf Pro for management and Defender for EDR — verify licensing and agent compatibility before stacking agents.

See [[Corporate - Microsoft Intune]] and [[__ REFERENCE - Apple MDM Alternatives (Kandji, Mosyle, Addigy, Intune)]].

---

## Related Notes

- [[__ PRIMER - Jamf Product Suite]]
- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- [[__ PRIMER - Apple Device Management and MDM]]
