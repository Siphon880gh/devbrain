## Jamf Self Service — Employee App Portal

**Jamf Self Service** is a Mac (and iOS) app deployed through Jamf Pro. It gives employees a company-branded portal to install approved software and run IT workflows without opening a ticket.

---

## What Employees See

Typical Self Service catalog items:

- Optional productivity apps (Slack, Zoom, design tools)
- VPN or certificate enrollment shortcuts
- "Run Fix" policies (clear cache, reconnect Wi‑Fi profile, refresh config)
- Links to internal docs or support forms

Required baseline apps usually install silently via enrollment policies — Self Service is for **optional** or **on-demand** items.

---

## Admin Setup in Jamf Pro

1. **Settings → Self Service → macOS** — branding, description, notifications
2. Create **Self Service policies** — mark policy as available in Self Service
3. Add icon, category, description, button text
4. Scope to appropriate smart groups
5. Deploy **Jamf Self Service.app** via enrollment policy (if not already present)

---

## Policy Design Tips

| Do | Avoid |
|---|---|
| Clear button labels ("Install Chrome") | Vague "Run policy 1042" |
| Categories (Productivity, Security, Dev) | One flat list of 80 items |
| Lightweight scripts with feedback | Long-running scripts with no UI |
| Pilot with one department smart group | Fleet-wide untested scripts |

---

## Self Service vs. Silent Policies

| Method | When |
|---|---|
| **Enrollment / recurring policy** | Required baseline — FileVault, EDR, VPN, mandatory apps |
| **Self Service** | Optional apps, dev tools, one-off fixes |
| **App Installers (patch)** | Automatic updates for catalog apps |

See [[Jamf Pro - Policies, Profiles, and Smart Groups]].

---

## macOS Permissions

Self Service policies that run scripts triggering TCC still need [[PPPC - Pre-Approving macOS Automation Permissions with MDM]] profiles.

---

## Related Notes

- [[__ PRIMER - Jamf Product Suite]]
- [[Jamf Pro - Policies, Profiles, and Smart Groups]]
- [[Jamf Troubleshooting - Common Issues]]
