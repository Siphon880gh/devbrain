## Jamf Pro — Zero-Touch Enrollment and ABM Setup

Zero-touch enrollment means a new Mac arrives ready for work after the employee unboxes it and signs in — no IT bench setup required.

The flow depends on **Apple Business Manager (ABM)** + **Automated Device Enrollment (ADE)** + **Jamf Pro**.

Platform primer: [[Apple Business Manager and Automated Device Enrollment]].

---

## Prerequisites

| Requirement | Notes |
|---|---|
| Apple Business Manager account | Tied to organization D-U-N-S number |
| Jamf Pro tenant | Cloud or on-prem |
| MDM server token in ABM | Download from Jamf; upload to ABM |
| Devices in ABM | Purchased from authorized reseller or assigned manually |
| Default MDM server set in ABM | Points new devices to Jamf |

---

## Setup Sequence

### 1. Connect Jamf Pro to Apple Business Manager

In Jamf Pro:

1. Go to **Settings → Device Management → Automated Device Enrollment**
2. Download the **MDM server token** (`.p7m` file)
3. In ABM: **Settings → Device Management Settings → Add MDM Server**
4. Upload the token; assign devices or set as default server

Token expires periodically — renew before expiry or new enrollments fail.

### 2. Create a PreStage Enrollment in Jamf Pro

PreStage Enrollment configures what happens at **first boot** before the user fully lands on the desktop.

Typical PreStage settings:

| Setting | Recommendation |
|---|---|
| **Mandatory** | On for company-owned Macs (user cannot skip MDM) |
| **Await configuration** | On — Setup Assistant waits until Jamf finishes baseline |
| **Authentication** | Require company SSO or local account creation rules |
| **Skip Setup Assistant panes** | Skip Apple ID, Siri, analytics if not needed |
| **Scope** | All ADE devices or specific ABM device groups |

Assign to PreStage:

- Baseline configuration profiles (FileVault, Wi‑Fi, restrictions)
- Enrollment policies (naming, scripts, app installs)
- Jamf Connect login configuration (if used)

### 3. Assign Devices in ABM

Devices must appear in ABM before activation:

- **Automatic:** buy from Apple or authorized reseller with ABM linked
- **Manual:** Apple Configurator 2 → add to ABM (for existing devices)
- **Apple Business Essentials / DEP resellers:** varies by vendor

In ABM, assign devices to the Jamf MDM server (or a device group that defaults to Jamf).

### 4. Ship to Employee

Employee flow:

```text
Unbox Mac → power on → select language/region → Wi‑Fi
↓
Setup Assistant: "This Mac is managed by [Your Company]"
↓
Authenticate (local account or Jamf Connect SSO)
↓
Mac enrolls → Jamf runs PreStage scope
↓
Desktop ready with apps and policies
```

---

## Staging vs. Drop-Ship

| Model | Description |
|---|---|
| **Drop-ship** | Reseller ships directly to employee; ADE runs on first boot |
| **IT staging** | IT unboxes, verifies enrollment, reseals, then ships |
| **User-initiated** | Employee runs enrollment URL (not zero-touch; no ADE lock) |

Drop-ship scales best but requires ABM assignment to be correct **before** the employee powers on.

---

## Releasing a Device from Management

When offboarding or selling hardware:

1. Remove device from ABM assignment (or release in ABM)
2. In Jamf: unmanage or wipe as policy dictates
3. User may need to complete Erase All Content and Settings on Apple Silicon

ADE-enrolled Macs remain managed until released in ABM — users cannot simply remove the MDM profile.

---

## Common Setup Mistakes

| Mistake | Symptom |
|---|---|
| Expired MDM token | New devices fail enrollment |
| Device never added to ABM | Setup Assistant shows normal consumer setup |
| Wrong default MDM server | Device enrolls into wrong tenant or none |
| PreStage not scoped | Device enrolls but gets no baseline |
| Missing `Await Configuration` | User reaches desktop before policies finish |

Troubleshooting: [[Jamf Troubleshooting - Common Issues]].

---

## Related Notes

- [[Apple Business Manager and Automated Device Enrollment]]
- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- [[Jamf Connect - SSO and Local Account Management]]
- [[__ PRIMER - Apple Device Management and MDM]]
