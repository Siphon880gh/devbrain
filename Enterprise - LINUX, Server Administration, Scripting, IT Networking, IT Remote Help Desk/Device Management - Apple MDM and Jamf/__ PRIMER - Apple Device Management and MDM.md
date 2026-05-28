## Apple Device Management and MDM

**MDM (Mobile Device Management)** is how organizations configure, secure, and manage Apple devices from a central admin console instead of touching every Mac, iPhone, or iPad by hand.

In plain terms:

> MDM is the remote control layer for company-owned Apple hardware.

It works with Apple's management APIs. The MDM server (Jamf, Kandji, Mosyle, Intune, etc.) sends commands and configuration profiles to enrolled devices over the internet.

---

## What MDM Can Do

| Area | Examples |
|---|---|
| Enrollment | Auto-enroll new Macs at first boot |
| Configuration | Wi‑Fi, VPN, email, restrictions, login settings |
| Apps | Deploy App Store apps, PKG installers, patch third-party apps |
| Security | FileVault, passcode rules, firewall, PPPC permissions |
| Identity | Connect devices to company SSO (often via Jamf Connect or Entra) |
| Lifecycle | Lock, wipe, unenroll, reassign hardware |
| Compliance | Report inventory, OS version, encryption status, patch level |

MDM does **not** replace your identity provider. It controls the **device**. Entra ID, Google Workspace, or Okta control the **user account**.

See also: [[Corporate - Jamf (Apple Devices)]] and [[Corporate - Microsoft Intune]] (Windows equivalent, in the Cybersecurity vault).

---

## Core Apple Platform Pieces

These exist outside any single vendor. Every serious Apple MDM setup uses some combination of them:

| Component | Role |
|---|---|
| [[Apple Business Manager and Automated Device Enrollment]] | Buy/assign devices; zero-touch enrollment (ADE, formerly DEP) |
| [[Configuration Profiles and Payload Types]] | Declarative settings pushed to devices |
| [[PPPC - Pre-Approving macOS Automation Permissions with MDM]] | Pre-approve TCC prompts for scripts and automation |
| [[FileVault and Recovery Key Escrow with MDM]] | Enforce disk encryption; IT holds recovery keys |

---

## Typical Enrollment Models

### Automated Device Enrollment (ADE) — preferred for company-owned Macs

```text
Device purchased through ABM or assigned in ABM
↓
Shipped to employee (or staged by IT)
↓
Employee powers on and connects to network
↓
Setup Assistant shows company enrollment
↓
Device auto-enrolls into MDM
↓
Baseline profiles, apps, and policies apply
```

ADE devices are **supervised** (for iOS/iPadOS) or **user-approved MDM** (macOS) and remain under management until explicitly released.

### User-initiated enrollment

Employee installs an MDM profile or opens an enrollment URL. Common for BYOD or adding management to an already-in-use Mac. User can often remove the profile unless the device was enrolled via ADE.

### Manual / Apple Configurator

IT physically connects devices and assigns them to ABM. Used for small batches, refurb units, or devices not bought through an authorized channel.

---

## MDM vs. Remote Desktop vs. Scripting

These solve different problems:

| Tool type | Purpose | Examples in this vault |
|---|---|---|
| MDM | Fleet policy, enrollment, app deploy, wipe | [[__ PRIMER - Jamf Product Suite]] |
| Remote desktop | Interactive support on one machine | [[Directory - Remote Desktop Apps]], [[VNC Remote Desktop for Mac - How to Use]] |
| Local automation | Startup scripts, LaunchAgents on one Mac | [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]] |

MDM can **deploy** LaunchAgents and scripts fleet-wide, but it does not replace SSH, VNC, or Tailscale for day-to-day troubleshooting. See [[2. Install Tailscale on Mac and Explore]] for mesh VPN access to managed Macs.

---

## Choosing a Platform

See [[__ REFERENCE - Apple MDM Alternatives (Kandji, Mosyle, Addigy, Intune)]] and [[Directory - Device Management Tools]].

**Jamf** is the most common choice for Mac-heavy organizations. **Intune** fits Microsoft-first shops managing mixed Windows + Apple fleets. **Kandji**, **Mosyle**, and **Addigy** are Mac-native alternatives with different pricing and UX.

---

## Related Notes

- [[__ PRIMER - Jamf Product Suite]]
- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]]
- [[Jamf Connect - SSO and Local Account Management]]
- [[Jamf Protect - Endpoint Security for Mac]]
- [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]] (OpenClaw vault — deep PPPC walkthrough)
