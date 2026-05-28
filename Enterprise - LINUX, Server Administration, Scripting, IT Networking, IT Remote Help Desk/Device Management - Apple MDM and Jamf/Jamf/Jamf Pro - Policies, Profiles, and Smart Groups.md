## Jamf Pro — Policies, Profiles, and Smart Groups

Jamf Pro admin work revolves around three ideas: **who** gets something (scope), **what settings** apply (configuration profiles), and **what actions** run (policies).

---

## Configuration Profiles

Profiles push declarative settings to devices. They map to Apple payload types.

Common payloads:

| Payload | Use |
|---|---|
| Wi‑Fi / VPN / Mail / Calendar | Connectivity and account setup |
| Restrictions | Block App Store, iCloud, USB, etc. |
| FileVault | Require encryption; escrow recovery key |
| PPPC (`com.apple.TCC.configuration-profile-policy`) | Pre-approve automation permissions |
| Login Window / Dock / Finder | UX baseline |
| Certificates | Trust internal CAs; Wi‑Fi EAP-TLS |
| Privacy & Security | Gatekeeper, SIP-related settings where allowed |

See [[Configuration Profiles and Payload Types]] for platform-wide context.

Profiles install silently on managed devices. Verify on a Mac:

```bash
profiles show
```

or:

```bash
system_profiler SPConfigurationProfileDataType
```

---

## Policies

Policies are **actions** Jamf runs on devices. Triggers include:

| Trigger | When it runs |
|---|---|
| **Enrollment Complete** | Right after MDM enrollment |
| **Recurring Check-In** | Periodic inventory/check-in |
| **Login / Logout / Startup** | User session events |
| **Custom** | Manual from admin console |
| **Event** | Smart group membership change, etc. |

Policy actions can include:

- Run shell script (as root or user)
- Install PKG, DMG, or app
- Run Jamf binary commands
- Reboot, rename computer, enable FileVault
- Deploy a configuration profile

### Example: deploy a LaunchAgent via policy

Many orgs use an **Enrollment Complete** policy to:

1. Create `/usr/local/bin/` or `/Users/Shared/` script paths
2. Copy startup script
3. Install plist into `/Library/LaunchAgents/` or user LaunchAgents
4. `launchctl bootstrap` the agent

This connects Jamf fleet management to local macOS automation. See [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]] and [[Loading and Unloading LaunchAgents with launchctl]].

If the automation needs Accessibility or AppleEvents, pair the policy with a [[PPPC - Pre-Approving macOS Automation Permissions with MDM]] profile.

---

## Smart Groups vs. Static Groups

### Smart groups (dynamic)

Membership updates automatically when inventory changes.

Examples:

```text
All Macs on macOS 15.x
All Macs missing FileVault
All Macs without Chrome installed
All Macs in scope "Engineering"
All Macs last check-in > 7 days ago
```

Use smart groups to **scope** profiles and policies so only relevant devices receive them.

### Static groups (manual)

Fixed list. Useful for pilots, exec machines, lab benches, or one-off exceptions.

---

## Scope

Every profile, policy, and app has a **scope** tab:

- Target computers (all, smart group, static group, individual)
- Target users (optional — less common for Mac computer policies)
- Limitations (network, IP range, department)
- Exclusions (override for test machines or break-glass accounts)

**Best practice:** scope baselines broadly (all enrolled Macs), scope specialized tools narrowly (developers, design, kiosks).

---

## Extension Attributes

Custom inventory fields populated by scripts on check-in.

Examples:

- Last VPN connection date
- Homebrew package count
- OpenClaw stack version
- Whether a required LaunchAgent is loaded

Extension attributes power smart groups: "All Macs where EA `OpenClaw Version` is not `2.x`".

---

## App Lifecycle in Jamf Pro

| Method | When to use |
|---|---|
| **App Store apps (VPP/Apps and Books)** | Apple-approved store apps via ABM |
| **PKG / DMG** | One-off installers, legacy apps |
| **App Installers** | Jamf-maintained third-party catalog (Chrome, Firefox, Zoom, etc.) |
| **Patch management** | Update catalog apps on a schedule |

Patch policies reduce "please update Chrome" tickets by pushing updates centrally.

---

## Typical Baseline Stack

A common new-Mac baseline scoped to **All Computers**:

```text
Enrollment Complete policy
  → Set computer name
  → Install management helper tools
  → Install company PKG bundle (VPN, EDR agent, etc.)

Configuration profiles
  → FileVault enforce + escrow
  → Wi‑Fi + internal CA cert
  → PPPC (if using Terminal/AppleScript automation)
  → Restrictions (USB storage, iCloud Drive, etc.)

Recurring policies
  → Patch third-party apps weekly
  → Run compliance script (report drift)
```

---

## Offboarding Actions

From the Jamf Pro device record (or via API/automation):

| Action | Effect |
|---|---|
| **Lock** | Lock screen; user needs PIN/password |
| **Wipe computer** | Erase Mac (destructive) |
| **Remove MDM profile** | Only when releasing device from management |
| **Unmanage** | Stop managing; device keeps data |

Always pair device actions with IdP account disable. See [[Corporate - Jamf (Apple Devices)]].

---

## Related Notes

- [[__ PRIMER - Jamf Product Suite]]
- [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]]
- [[Configuration Profiles and Payload Types]]
- [[PPPC - Pre-Approving macOS Automation Permissions with MDM]]
- [[FileVault and Recovery Key Escrow with MDM]]
- [[Jamf Troubleshooting - Common Issues]]
