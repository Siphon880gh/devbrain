## Apple Configurator 2 — Manual ABM Assignment

**Apple Configurator 2** is Apple's free Mac app for preparing iPhone, iPad, and Mac devices. In enterprise workflows it fills gaps when hardware did **not** arrive through an ABM-linked purchase channel.

See [[Apple Business Manager and Automated Device Enrollment]] for the full ABM picture.

---

## When You Need Configurator

| Situation | Configurator role |
|---|---|
| Bought Mac from retail / non-DEP reseller | Add to ABM manually (Apple terms apply) |
| Refurb or legacy device | Assign to MDM server via Configurator |
| iOS/iPadOS bulk prep | Supervise and assign before handout |
| Lab or event devices | Erase and reassign quickly |

Manual add requires physical USB connection (Mac) or supervised workflow (iOS).

---

## High-Level Mac Flow

```text
Install Apple Configurator 2 from Mac App Store
↓
Sign in with Managed Apple ID (ABM admin)
↓
Connect target Mac via USB / link in setup
↓
Add to organization in ABM
↓
Assign to Jamf MDM server in ABM
↓
Erase or prepare device
↓
Next setup runs ADE into Jamf
```

Exact menus change between macOS versions — verify against current Apple Platform Deployment guide.

---

## Limitations

- Cannot add devices already personally activated in all cases
- Manual add may have waiting period before ABM shows device
- Some consumer purchase paths are ineligible
- Mac must be erased for clean ADE in many scenarios

If Configurator is not an option, fall back to **user-initiated enrollment** in Jamf.

---

## vs. Zero-Touch Drop-Ship

| | Configurator | Drop-ship ADE |
|---|---|---|
| IT touches hardware | Yes | No |
| Scales to large fleet | Poor | Excellent |
| Fixes wrong purchase channel | Yes | N/A |

Prefer ABM-linked purchasing for fleet scale: [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]].

---

## Related Notes

- [[Apple Business Manager and Automated Device Enrollment]]
- [[Jamf Pro - Zero-Touch Enrollment and ABM Setup]]
- [[Jamf Troubleshooting - Common Issues]]
