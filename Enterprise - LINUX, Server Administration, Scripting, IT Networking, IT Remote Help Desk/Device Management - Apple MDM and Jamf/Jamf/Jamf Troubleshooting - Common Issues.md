## Jamf Troubleshooting — Common Issues

Quick reference for help desk and Mac admins working with Jamf Pro and enrolled Macs.

---

## Enrollment Failures

| Symptom | Likely cause | Fix |
|---|---|---|
| No "managed by" screen at Setup Assistant | Device not in ABM or wrong MDM server | Verify ABM assignment; see [[Apple Business Manager and Automated Device Enrollment]] |
| "Could not enroll" after setup | Expired MDM token | Renew token in Jamf → upload to ABM |
| Profile downloads but enrollment incomplete | Network/firewall blocking Apple MDM endpoints | Allow `*.apple.com`, `*.jamfcloud.com` (or on-prem hostname) |
| User skipped enrollment | PreStage not mandatory | Set PreStage to mandatory for ADE |

Check Jamf Pro: **Computers** → search serial → **Management History**.

---

## Device Not Checking In

```bash
sudo jamf policy
sudo jamf recon
```

| Symptom | Checks |
|---|---|
| Last check-in stale | Mac offline? VPN required? |
| `jamf: command not found` | Framework removed — re-enroll |
| MDM profile missing | `profiles show \| grep jamf` |

Force policy from Jamf console: **Management → Update Management** or run policy by trigger.

---

## Profile Not Applying

```bash
profiles show
profiles show -type configuration
sudo profiles renew -type enrollment
```

- Scope mismatch — device not in target smart group
- Conflicting profile — check Jamf logs and remove duplicate payloads
- User deferral — some payloads wait for logout/reboot

See [[Configuration Profiles and Payload Types]].

---

## Policy Script Failures

- Check **Policy Logs** on computer record in Jamf
- Run script locally with same user context (root vs. user)
- Verify script path exists on disk (MDM deploy step may have failed)
- Check PPPC if script needs TCC access: [[PPPC - Pre-Approving macOS Automation Permissions with MDM]]

---

## LaunchAgent Deployed but Not Running

Cross-reference [[Loading and Unloading LaunchAgents with launchctl]]:

```bash
launchctl list | grep com.company
plutil ~/Library/LaunchAgents/com.company.agent.plist
log show --predicate 'process == "launchd"' --last 1h | grep com.company
```

Common issues:

- Plist syntax error
- Script not executable (`chmod +x`)
- Wrong path after user rename
- Missing PPPC for AppleScript

---

## FileVault / Login Issues

- Recovery key missing in Jamf — see [[FileVault and Recovery Key Escrow with MDM]]
- SSO login fails after password change — Jamf Connect + IdP sync
- Secure Token missing — bootstrap token policy

```bash
fdesetup status
sysadminctl -secureTokenStatus foruser username
```

---

## App Install / Patch Stuck

- App Installer requires minimum macOS version
- User deferred update notification
- VPP license exhausted in ABM
- Check **Patch Management** logs in Jamf

---

## Removing Management (Break-Glass)

Company-owned ADE Mac:

1. Release device in ABM (or wipe and remove from ABM)
2. Erase Mac
3. Remove from Jamf inventory

Do not advise users to delete MDM profile on ADE devices — it will reappear or block until released in ABM.

---

## Useful Client Commands

```bash
# Jamf binary
jamf help
jamf recon
jamf policy
jamf version

# MDM / profiles
profiles status -type enrollment
profiles show

# System info for tickets
system_profiler SPHardwareDataType SPSoftwareDataType
sw_vers
```

---

## Related Notes

- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]]
- [[__ PRIMER - Jamf Product Suite]]
- [[Automating Terminal Tabs on macOS with LaunchAgents, AppleScript, and Startup Scripts]]
