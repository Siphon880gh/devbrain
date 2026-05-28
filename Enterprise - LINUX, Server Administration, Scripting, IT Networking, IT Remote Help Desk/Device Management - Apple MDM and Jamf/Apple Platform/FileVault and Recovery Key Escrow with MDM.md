## FileVault and Recovery Key Escrow with MDM

**FileVault** is Apple's full-disk encryption for Mac. In managed environments, IT enables FileVault through MDM and **escrows the recovery key** so a lost password does not mean a bricked laptop.

Jamf Pro is the most common escrow destination for Mac fleets.

---

## Why Escrow Matters

| Scenario | Without escrow | With escrow |
|---|---|---|
| Employee forgets password | Data may be unrecoverable | IT retrieves recovery key from Jamf |
| Offboarding | Wipe is still possible via MDM | Escrow key available until wipe |
| Compliance audit | Hard to prove encryption | Jamf inventory shows FileVault status + key stored |

---

## How Jamf Pro Enforces FileVault

Typical approach:

1. **Configuration profile** — FileVault payload: enable FileVault, show recovery key to user (optional), redirect recovery key to Jamf
2. **Policy** — trigger `fdesetup` or rely on profile at enrollment
3. **Inventory** — smart group "FileVault not enabled" for remediation

Profile details: [[Configuration Profiles and Payload Types]].

---

## Secure Token and Bootstrap Token

Modern macOS ties FileVault to **Secure Token**:

- First user to enable FileVault gets a Secure Token
- Other admin users need token delegation
- **Bootstrap Token** (ADE Macs) lets MDM escrow token for silent Secure Token grant to new users

This interacts with [[Jamf Connect - SSO and Local Account Management]] — SSO-created accounts need Secure Token for FileVault unlock after reboot.

Symptoms of token issues:

- User cannot unlock FileVault after password change
- "Authentication needed" loop at preboot

Fix paths: bootstrap token escrow in Jamf, log out/in, or admin `sysadminctl` operations (version-specific).

---

## Viewing Escrowed Keys in Jamf Pro

On a computer record:

```text
Management tab → FileVault Recovery Key
```

Requires Jamf admin role with key viewing permission. Treat keys as sensitive — same tier as domain admin credentials.

---

## FileVault Deployment Flow

```text
ADE Mac enrolls
↓
FileVault profile installs
↓
User completes Setup Assistant / first login
↓
Encryption begins (background)
↓
Recovery key escrowed to Jamf
↓
Inventory: FileVault = Enabled
```

For existing Macs, a policy can enable FileVault on next check-in; user may need to log out for encryption to complete.

---

## Offboarding and FileVault

Before reassigning hardware:

| Action | Notes |
|---|---|
| **Wipe via Jamf** | Destroys volume; encryption key gone |
| **Disable FileVault then unmanage** | Rare; slow; wipe is faster |
| **Record key before wipe** | Only if legal/compliance requires recovery attempt |

Wipe is preferred for offboarding company-owned Macs.

---

## Troubleshooting

| Issue | Check |
|---|---|
| Key not escrowed | Profile payload, bootstrap token, user completed first login |
| Encryption pending forever | Disk space, user never logged out, check `fdesetup status` |
| User locked out | Recovery key from Jamf; or wipe if device is disposable |
| Profile won't apply | Conflicting profiles; check `profiles show` |

```bash
fdesetup status
diskutil apfs list
```

---

## Related Notes

- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- [[Jamf Connect - SSO and Local Account Management]]
- [[Configuration Profiles and Payload Types]]
- [[Corporate - Jamf (Apple Devices)]]
