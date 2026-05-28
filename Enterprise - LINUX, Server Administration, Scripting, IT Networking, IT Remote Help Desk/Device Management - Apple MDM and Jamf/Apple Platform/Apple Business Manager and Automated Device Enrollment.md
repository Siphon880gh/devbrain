## Apple Business Manager and Automated Device Enrollment

**Apple Business Manager (ABM)** is Apple's web portal for organizations to link purchased hardware to their MDM server.

**Automated Device Enrollment (ADE)** — formerly **Device Enrollment Program (DEP)** — is the mechanism that forces company-owned devices to enroll in MDM during Setup Assistant.

Together they enable **zero-touch deployment**.

---

## Key Terms

| Term | Meaning |
|---|---|
| **ABM** | Portal for device assignment, app licensing, MDM server tokens |
| **ASM** | Apple School Manager — education equivalent of ABM |
| **ADE / DEP** | Auto-enrollment at first boot (DEP is legacy name) |
| **MDM server token** | Signed certificate linking ABM to Jamf (or other MDM) |
| **PreStage Enrollment** | Jamf-specific first-boot configuration (other MDMs have equivalents) |
| **Supervision** | Stronger control model (mainly iOS/iPadOS; macOS uses user-approved MDM) |

---

## ABM Responsibilities

ABM is **not** the MDM console. It handles:

- Device inventory from authorized purchases
- Assigning devices to an MDM server
- **Apps and Books** (VPP) licensing for App Store distribution
- Managed Apple IDs (optional, more common in education)
- Renewing MDM server tokens

Day-to-day policy work happens in Jamf Pro: [[Jamf Pro - Policies, Profiles, and Smart Groups]].

---

## Device Appears in ABM When

| Source | Notes |
|---|---|
| Authorized reseller purchase | Automatic if reseller linked to ABM |
| Direct from Apple | With ABM customer number on order |
| Apple Configurator 2 | Manual add for devices not bought through channel |
| Apple Business Essentials | Depends on subscription model |

If a Mac never appears in ABM, you cannot ADE-enroll it — fall back to user-initiated enrollment or reassign through Configurator.

---

## MDM Server Token Lifecycle

```text
Jamf Pro generates token
↓
Upload to ABM (Settings → Device Management)
↓
Assign devices to that MDM server
↓
Token valid ~1 year
↓
Renew before expiry
```

Expired token = new purchases fail silent enrollment.

Setup details: [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]].

---

## ADE vs. User-Initiated Enrollment

| | ADE | User-initiated |
|---|---|---|
| **When** | First boot of ABM-assigned device | Anytime |
| **Skip MDM?** | No (if PreStage is mandatory) | Often yes |
| **Remove profile?** | No until released in ABM | User may remove (unless supervised iOS) |
| **Best for** | Company-owned fleet | BYOD, retrofit |

---

## Apps and Books (VPP)

ABM integrates volume licensing:

- Buy App Store apps in ABM
- Assign to Jamf Pro
- Jamf deploys apps without individual Apple IDs

Jamf Pro shows licensed apps under **Mobile Device Apps** / **Mac App Store apps** depending on platform.

---

## Education: Apple School Manager

K–12 and universities use **ASM** instead of ABM. Devices, MDM tokens, and Managed Apple IDs work similarly. **Jamf School** or Jamf Pro both integrate with ASM.

---

## Related Notes

- [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]]
- [[__ PRIMER - Apple Device Management and MDM]]
- [[__ PRIMER - Jamf Product Suite]]
- [[Apple Configurator 2 - Manual ABM Assignment]]
- [[Configuration Profiles and Payload Types]]
