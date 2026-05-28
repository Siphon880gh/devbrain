## Jamf Product Suite

Jamf is an Apple-focused management and security vendor. Organizations pick one or more products depending on fleet size, budget, and security requirements.

High-level business overview: [[Corporate - Jamf (Apple Devices)]].

---

## Products at a Glance

| Product | Best for | Main job |
|---|---|---|
| **Jamf Pro** | Mid-size to enterprise Mac/iOS fleets | Full MDM: enrollment, policies, apps, patching, inventory |
| **Jamf Now** | Small business, few devices | Simplified MDM without Jamf Pro complexity |
| **Jamf School** | K–12 and education | Classroom device management, teacher/student workflows |
| **Jamf Connect** | Mac login + identity | SSO at login screen; sync local accounts with cloud IdP |
| **Jamf Protect** | Security operations | EDR-style telemetry, macOS threat detection, compliance analytics |
| **Jamf Safe Internet** | Web filtering | DNS/content filtering for managed Apple devices |
| **Jamf Executive Threat Protection** | High-risk users | Advanced threat protection for executives |

Most IT admins in corporate environments work primarily in **Jamf Pro**, with **Jamf Connect** and **Jamf Protect** added as the org matures.

---

## Jamf Pro — Core MDM Console

Jamf Pro is the flagship platform. Key building blocks:

| Concept | What it is |
|---|---|
| **Computer / mobile device records** | Inventory object for each enrolled Mac, iPhone, iPad, Apple TV |
| **Smart groups** | Dynamic collections based on criteria (OS version, app installed, department, etc.) |
| **Static groups** | Manually curated device lists |
| **Configuration profiles** | Settings payloads (Wi‑Fi, restrictions, PPPC, FileVault, etc.) |
| **Policies** | Triggered actions: run script, install PKG, mount DMG, run command |
| **App Installers / patch management** | Deploy and update third-party macOS apps (Chrome, Zoom, etc.) |
| **Extension attributes** | Custom inventory fields populated by scripts |
| **Scope** | Which devices/users receive a profile, policy, or app |

Deep dive: [[Jamf Pro - Policies, Profiles, and Smart Groups]].

Setup walkthrough: [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]].

---

## Jamf Now

Jamf Now targets teams that need MDM without a dedicated Mac admin:

- Quick enrollment via link or ABM
- Basic app deployment
- Passcode and encryption policies
- Lost Mode and remote wipe on supported devices

Trade-off: fewer advanced features than Jamf Pro (no complex policy scripting, limited patch workflows).

---

## Jamf School

Built for education:

- Class-based app and content distribution
- Shared iPad scenarios
- Teacher tools for locking screens, opening apps, viewing devices
- Integration with Apple School Manager (ASM), the education equivalent of ABM

---

## Jamf Connect

Handles **login experience** and **local account lifecycle** on Mac:

- Login window shows company SSO (Okta, Entra ID, Google, etc.)
- Can create/sync local macOS accounts from IdP attributes
- FileVault and Secure Token considerations at login
- Menu bar app for password sync and network account info

See [[Jamf Connect - SSO and Local Account Management]].

---

## Jamf Protect

Endpoint detection and response for macOS:

- Unified logs from macOS security subsystems
- Analytics for suspicious process, persistence, and privilege changes
- Integrations with SIEM (Splunk, etc.)
- Complements MDM — Protect observes; Pro enforces configuration

See [[Jamf Protect - Endpoint Security for Mac]].

---

## How the Pieces Fit Together

```text
Apple Business Manager
        ↓
   Jamf Pro (MDM)
        ├── Configuration profiles (security baseline)
        ├── Policies + scripts (apps, LaunchAgents, tooling)
        ├── App Installers (patch Chrome, Zoom, etc.)
        │
        ├── Jamf Connect (SSO login)
        └── Jamf Protect (threat detection)
```

Identity provider (Entra, Okta, Google) sits **alongside** Jamf:

```text
Employee terminated
  → Disable IdP account (email, SSO, VPN)
  → Jamf Pro: lock/wipe/reassign Mac
  → Jamf Connect: login no longer works
```

---

## Alternatives

Not every org uses Jamf. Compare options: [[__ REFERENCE - Apple MDM Alternatives (Kandji, Mosyle, Addigy, Intune)]].

---

## Related Notes

- [[__ PRIMER - Apple Device Management and MDM]]
- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]]
- [[Jamf Connect - SSO and Local Account Management]]
- [[Jamf Protect - Endpoint Security for Mac]]
- [[Jamf Self Service - Employee App Portal]]
- [[Jamf Troubleshooting - Common Issues]]
