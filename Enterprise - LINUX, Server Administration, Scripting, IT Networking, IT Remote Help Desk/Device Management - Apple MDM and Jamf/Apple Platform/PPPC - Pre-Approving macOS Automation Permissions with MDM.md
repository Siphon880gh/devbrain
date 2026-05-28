## PPPC — Pre-Approving macOS Automation Permissions with MDM

**PPPC (Privacy Preferences Policy Control)** is a configuration profile payload that pre-grants macOS **TCC (Transparency, Consent, and Control)** permissions — the privacy prompts for Accessibility, Full Disk Access, AppleEvents, Screen Recording, etc.

For fleet-deployed automation, PPPC is often the difference between "works on one Mac" and "works on every Mac without manual clicks."

---

## When You Need PPPC

Any time MDM deploys automation that would normally trigger a user prompt:

| Automation | Typical TCC service |
|---|---|
| `osascript` controlling Terminal | AppleEvents |
| Simulated keystrokes / UI scripting | Accessibility |
| Reading protected folders | Full Disk Access (`SystemPolicyAllFiles`) |
| Screen capture tools | Screen Recording |
| Background LaunchAgents at login | Background Items (macOS 13+) |

This vault's LaunchAgent workflows are a prime example: [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]].

---

## Payload Type

```text
com.apple.TCC.configuration-profile-policy
```

Apple reference: [Privacy Preferences Policy Control payload](https://support.apple.com/guide/deployment/privacy-preferences-policy-control-payload-dep38df53c2a/web).

---

## Without MDM vs. With PPPC

```text
Without PPPC:
  New Mac boots → LaunchAgent runs → osascript blocked → user must approve manually

With PPPC:
  Mac enrolls → profile installs → TCC already allows → automation runs on first login
```

Extended walkthrough with OpenClaw context: [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]].

---

## Building a PPPC Rule

For each permission, document:

1. **Identifier** — bundle ID (e.g. `com.apple.Terminal`) or code requirement
2. **IdentifierType** — `bundleID` or `path` (path is fragile after updates)
3. **Service** — Accessibility, AppleEvents, SystemPolicyAllFiles, etc.
4. **Allowed** — `true` to allow; `false` to deny
5. **Code requirement** — from `codesign` (for non-bundle tools)

Extract code requirement:

```bash
codesign -dr - /System/Applications/Utilities/Terminal.app
```

Example output:

```text
designated => identifier "com.apple.Terminal" and anchor apple
```

For `osascript`, rules often target the **controlling app** and the **target app** in AppleEvents dictionaries.

---

## Example Conceptual Policy

| App | Service | Action |
|---|---|---|
| Terminal.app | Accessibility | Allow |
| Terminal.app | AppleEvents → System Events | Allow |
| iTerm.app | Accessibility | Allow |
| Custom tool (by code req) | SystemPolicyAllFiles | Allow |

Jamf Pro provides a **PPPC Utility** or inline Privacy Preferences editor — prefer that over hand-editing XML.

---

## Deploy from Jamf Pro

1. Build PPPC profile in Jamf (Computers → Configuration Profiles → Privacy Preferences)
2. Scope to smart group (all Macs with automation, or entire fleet)
3. On test Mac: enroll → `profiles show` → reboot → verify zero prompts
4. Pair with policy that installs LaunchAgent plist and script

Policy + profile ordering: profile should be present **before** first automation run. Use **Await Configuration** in PreStage if automation runs at first login.

---

## Standardization Requirements

PPPC breaks when paths and bundle IDs drift:

| Good | Bad |
|---|---|
| `/Users/Shared/company/startup.sh` | `/Users/bob/Desktop/test-v2.sh` |
| Same Terminal app everywhere | Mix of Terminal and iTerm without rules for both |
| Consistent LaunchAgent label | Different plist labels per machine |

Align with [[Jamf Pro - Policies, Profiles, and Smart Groups]] baseline policies.

---

## Limitations

Apple restricts some categories from full silent approval:

- Screen Recording (varies by OS version)
- Camera / Microphone
- Some Apple Silicon security changes per release

Always test on a **fresh ADE Mac** running your target macOS version before scaling.

---

## Architecture Tip — Reduce PPPC Surface

Prefer `launchd` running daemons directly over Terminal tab AppleScript when possible:

```text
launchd → ollama serve
launchd → litellm
launchd → openclaw
```

That eliminates Accessibility and AppleEvents for Terminal control. See the "Better Architecture" section in [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]].

---

## Verify on Client Mac

```bash
profiles show
system_profiler SPConfigurationProfileDataType
```

TCC database (advanced debugging — SIP and macOS version affect visibility):

```bash
# Requires Full Disk Access on newer macOS; use for support only
sqlite3 /Library/Application\ Support/com.apple.TCC/TCC.db '.tables'
```

---

## Related Notes

- [[Configuration Profiles and Payload Types]]
- [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]]
- [[Loading and Unloading LaunchAgents with launchctl]]
- [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]]
- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
