## Jamf Connect — SSO and Local Account Management

Jamf Connect is a separate Jamf product that controls **how users log into Macs** and how **local macOS accounts** stay aligned with your cloud identity provider.

Jamf Pro manages the device. Jamf Connect manages the **login experience and account mapping**.

---

## What Problem It Solves

Without Jamf Connect:

- Employees create arbitrary local Mac accounts
- FileVault Secure Token ownership gets messy
- Passwords drift from company SSO
- Offboarding depends on remembering local account names

With Jamf Connect:

- Login window presents company SSO (Okta, Entra ID, Google, etc.)
- Local account can be created or matched from IdP attributes on first login
- Password sync (where supported) keeps Mac login aligned with cloud password
- Menu bar app shows account status and supports password updates

---

## Components

| Piece | Role |
|---|---|
| **Jamf Connect Login** | Replaces or augments macOS login window with SSO |
| **Jamf Connect Verify** (legacy naming in some docs) | Post-login menu bar app for account sync |
| **Configuration profile** | Deployed via Jamf Pro; points to IdP and sets account rules |
| **IdP integration** | OIDC/SAML app registration in Okta, Entra, etc. |

Configuration is usually a `.plist` or JSON preference list scoped through Jamf Pro.

---

## Typical Login Flow

```text
User at Mac login screen
↓
Jamf Connect shows "Sign in with Company SSO"
↓
Redirect to IdP (Okta / Entra / Google)
↓
User authenticates + MFA
↓
Jamf Connect creates or syncs local macOS account
↓
User lands on desktop; FileVault token assigned per policy
```

---

## FileVault and Secure Token

On modern macOS, **Secure Token** is required for FileVault management and some system changes.

Jamf Connect login can ensure the user's local account receives a Secure Token when:

- Account is created at first SSO login
- Bootstrap token escrow is configured in Jamf Pro
- Login policy matches Apple's requirements for the macOS version

Misconfiguration here causes "FileVault enabled but user cannot unlock" support tickets. Pair Jamf Connect setup with [[FileVault and Recovery Key Escrow with MDM]].

---

## Account Creation Modes

Common configuration choices:

| Mode | Behavior |
|---|---|
| **Create local account from IdP** | First SSO login creates `firstname.lastname` local user |
| **Map to existing local account** | Match by username or email attribute |
| **Network account only** | Less common on Mac; usually still need local account for offline |

Use consistent username patterns across the fleet — especially if you deploy per-user paths or PPPC rules tied to executables in home folders.

---

## Offboarding Interaction

Offboarding is a **two-system** process:

```text
Disable user in IdP
  → SSO login fails on next attempt
  → Revoke app sessions (email, Slack, VPN)

Jamf Pro device action
  → Lock or wipe company Mac
  → Recover hardware
```

Jamf Connect stops new logins immediately when IdP is disabled. It does not erase data by itself — use Jamf Pro for device actions.

See [[Corporate - Jamf (Apple Devices)]] for the full offboarding narrative.

---

## Deployment via Jamf Pro

1. Register Jamf Connect app in IdP (OIDC recommended)
2. Build Jamf Connect configuration (Jamf provides templates per IdP)
3. Deploy as configuration profile to smart group (all Macs, or ADE PreStage)
4. Test on clean Mac: ADE enroll → SSO login → FileVault → reboot → verify unlock

---

## Related Notes

- [[__ PRIMER - Jamf Product Suite]]
- [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]]
- [[FileVault and Recovery Key Escrow with MDM]]
- [[__ PRIMER - Apple Device Management and MDM]]
