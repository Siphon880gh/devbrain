## Configuration Profiles and Payload Types

Configuration profiles are XML/plist packages (`.mobileconfig`) that MDM pushes to Apple devices. Each **payload** is one settings domain.

Jamf Pro, Kandji, Mosyle, and Intune all build profiles — the underlying Apple payload types are the same.

---

## How Profiles Reach Devices

```text
Admin creates profile in MDM
↓
Profile scoped to devices/users
↓
MDM signs and delivers profile on check-in
↓
macOS/iOS installs silently (managed devices)
↓
Settings enforced; user often cannot change locked keys
```

List installed profiles on Mac:

```bash
profiles show
profiles show -type configuration
```

Remove a specific profile (admin/testing only — managed profiles may reappear):

```bash
sudo profiles remove -identifier com.company.profileid
```

---

## Common Payload Types

| Payload type | Purpose |
|---|---|
| `com.apple.wifi.managed` | Wi‑Fi networks and 802.1X |
| `com.apple.vpn.managed` | VPN on-demand rules |
| `com.apple.mail.managed` | Email account setup |
| `com.apple.security.firewall` | macOS application firewall |
| `com.apple.MCX.FileVault2` | FileVault enforcement |
| `com.apple.TCC.configuration-profile-policy` | PPPC — TCC permissions |
| `com.apple.applicationaccess` | Restrictions (App Store, iCloud, etc.) |
| `com.apple.loginwindow` | Login window text, admin access |
| `com.apple.mdm` | MDM enrollment itself |
| `com.apple.security.certificatetrust` | Trust custom CAs |
| `com.apple.extensiblesso` | SSO extension for apps |
| `com.apple.servicemanagement` | Background items / launch services (macOS 13+) |

Apple documents payload keys in the [Device Management MDM protocol reference](https://developer.apple.com/documentation/devicemanagement).

---

## Restrictions Payload

High-impact for corporate Macs:

- Disable iCloud Drive or specific iCloud services
- Block USB mass storage (varies by OS version)
- Disable App Store or require admin password
- Camera/microphone restrictions (iOS; macOS more limited)
- Delay OS updates or hide beta updates

Test restrictions on a pilot smart group before fleet scope — overly aggressive profiles generate help desk volume.

---

## PPPC Payload

Special case for automation fleets. Pre-approves **Transparency, Consent, and Control (TCC)** prompts.

Required when deploying:

- LaunchAgents that run `osascript`
- Terminal automation
- Full Disk Access for backup or security tools

See [[PPPC - Pre-Approving macOS Automation Permissions with MDM]].

Deep walkthrough: [[Why Startup Scripts Do Not Port Easily Across Macs - Permissions and MDM]].

---

## FileVault Payload

Works with [[FileVault and Recovery Key Escrow with MDM]]:

- Require FileVault on enrollment
- Escrow personal recovery key to Jamf
- Show recovery key to user (optional)

---

## Profile Conflicts

Multiple profiles can target the same domain. **Most restrictive wins** for many keys, but behavior varies by payload.

Best practices:

- One baseline profile per domain where possible
- Avoid duplicate Wi‑Fi/VPN payloads from different teams
- Use Jamf **Profile Conflicts** logging when troubleshooting

---

## Custom Profiles

Jamf allows uploading raw `.mobileconfig` files built externally (e.g., [ProfileCreator](https://github.com/ProfileCreator/ProfileCreator), iMazing Profile Editor).

Use when Jamf UI lacks a niche payload or you need exact Apple template control.

---

## Related Notes

- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- [[PPPC - Pre-Approving macOS Automation Permissions with MDM]]
- [[FileVault and Recovery Key Escrow with MDM]]
- [[Apple Business Manager and Automated Device Enrollment]]
