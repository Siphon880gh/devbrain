## Apple MDM Alternatives — Kandji, Mosyle, Addigy, Intune

Jamf is the incumbent for Apple fleet management, but it is not the only option. Pick based on identity stack, budget, admin skill, and Mac-vs-Windows mix.

Overview: [[__ PRIMER - Apple Device Management and MDM]].

---

## Comparison Table

| Platform | Strengths | Typical buyer |
|---|---|---|
| **Jamf Pro** | Deepest Mac/iOS features, largest community, App Installers, mature API | Mac-primary enterprise |
| **Jamf Now** | Simple; low admin overhead | Small business |
| **Kandji** | Modern UX, strong automation "Blueprints," auto-patch | Mac-native startups / mid-market |
| **Mosyle** | Aggressive pricing, Apple-only focus, education tiers | Cost-sensitive Mac fleets |
| **Addigy** | MSP-friendly multi-tenant, live scripting | MSPs managing many clients |
| **Microsoft Intune** | Unified Windows + Mac + mobile under Entra | Microsoft 365 shops |
| **Workspace ONE (Omnissa)** | VMware heritage; cross-platform | Mixed OS enterprises |

Business-oriented overviews in Cybersecurity vault: [[Corporate - Jamf (Apple Devices)]], [[Corporate - Microsoft Intune]].

---

## Kandji

- **Blueprints** — ordered onboarding stacks (like PreStage + policies as one unit)
- Auto Apps — similar concept to Jamf App Installers
- Strong compliance views and patch automation
- Native ABM/ADE integration

Choose when you want a cleaner admin UX than legacy Jamf Pro and you are Mac-only.

---

## Mosyle

- Apple-only MDM (Mac, iPhone, iPad, Apple TV)
- Mosyle Business and Mosyle Fuse (more advanced) tiers
- Competitive pricing for smaller fleets
- Education products parallel Jamf School

Choose when budget is tight and you do not need Jamf's entire ecosystem.

---

## Addigy

- Built for **MSPs** — single pane for many customer tenants
- Live terminal and script execution on endpoints
- Community scripts and monitoring
- ABM integration

Choose when you are an MSP or need strong multi-org management.

---

## Microsoft Intune (+ Autopilot for Windows)

For **Windows**, Intune is the default. For **Mac**, Intune provides:

- ABM/ADE enrollment
- Configuration profiles (Apple payload types)
- App deployment (PKG, App Store via ABM)
- Compliance policies gating Entra conditional access
- Remote wipe, lock, retire

Mac depth is thinner than Jamf for patch catalog and Mac-specific workflows, but **one console for everything** wins in Entra-first orgs.

Windows Autopilot parallels Jamf PreStage: [[Corporate - Microsoft Intune]].

---

## When to Stay on Jamf

- Large existing Jamf Pro investment (profiles, policies, integrations)
- Heavy use of Jamf Connect + Protect as a suite
- Complex Mac patch requirements via App Installers
- Need Jamf API ecosystem and community scripts

---

## When to Consider Switching

- Mac fleet small and Microsoft already owns identity + Windows management
- MSP needs multi-tenant without Jamf Pro per-customer cost
- Admins want blueprint-style UX (Kandji) at lower complexity

Migration projects require parallel enrollment, profile rebuild, and ABM MDM server reassignment — treat as a project, not a toggle.

---

## Related Notes

- [[__ PRIMER - Jamf Product Suite]]
- [[Directory - Device Management Tools]]
- [[Apple Business Manager and Automated Device Enrollment]]
