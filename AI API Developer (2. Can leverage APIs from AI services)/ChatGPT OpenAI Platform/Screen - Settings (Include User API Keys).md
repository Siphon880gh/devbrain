## Scope

Settings screen is either organization specific or project specific

Settings apply to the organization (Here it’s WengIndustry) when at a subscreen for organization settings. Settings apply to the project (Default project or App 1 depending which one is selected) when at a subscreen for project settings:
![[Pasted image 20250416004852.png]]

![[Pasted image 20250416004857.png]]

They could've improved the interface a bit by putting emphasis on either the organization name or the project name depending on if the current subscreen.

Clicking a menu item under the Organization heading will open a subscreen whose settings affect the organization level. Clicking a menu item under the Project heading will open a subscreen whose settings affect at the project level:
![[Pasted image 20250416013934.png]]

---

## Features

At the OpenAI Platform’s settings screen, you can:
- View and adjust model usage limits
- Manage organization members, including who can:
- Access and view the dashboard
- Modify billing settings and view invoices
- Set or adjust credit limits and auto-repurchase options when usage reaches a set threshold
- Manage either the organization (all projects) or the project’s **API keys**, including the ability to:
    - **Block specific endpoints**
    - **Restrict access** to **read-only** or **write-only**
    - Having no restrictions means the endpoint can fully be read and/or written (if applicable)

Make sure roles and permissions are assigned carefully to control who can make changes to sensitive settings like billing and API access.

At OpenAI Platform’s setting screens, see model limits, manage members who can view the dashboard for this organization, and which members can affect billing, manage billing, and adjust billing limits and credits to repurchase when hit a number of credits use.

---
## API Keys

Note: User API keys that work across all projects at the organization is deprecated and accessed at a different menu. But will be discussed how to access before the end of section.

At Settings page, you can access either:
- All projects' api keys under the same organization, if you click "API Keys" menu item under "ORGANIZATION" section. The organization name at the top left is how it knows.
- The current project's API keys, if you click "API Keys" menu item under "PROJECT" section. The dropdown of the project names at the top left is how it knows.
- User API keys access will be discussed later

Depending on which API Keys menu item you click, you either access all projects' API Keys or that one project's API keys:

![[Pasted image 20250416012932.png]]

To access User API Keys:

Go to Settings -> Your Profile:
![[Pasted image 20250418221757.png]]

After removing User API Keys or if you don't have API Keys, that tab won't exist for you:
![[Pasted image 20250418222410.png]]

---


## Subscreens

A/B - How to open screen:
- Click gear icon at the top right navigation menu
  ![[Pasted image 20250416005202.png]]

This is what appears when you open the Settings Screen:
![[Pasted image 20250416005233.png]]

---

Projects subscreen lets you see a quick snapshot which project is spending more or to get a feel of the spend across projects. This is akin to having multiple product lines in a business’ portfolio and they’re all using OpenAI AI services:

![[Pasted image 20250416011406.png]]
