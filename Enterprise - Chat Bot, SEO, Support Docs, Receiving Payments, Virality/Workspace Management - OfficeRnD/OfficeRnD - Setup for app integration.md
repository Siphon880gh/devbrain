This is the **complete, start-to-finish** guide for connecting FlexAgents / AgentOps to the OfficeRnD Flex API v2. Follow these steps in order.

> **Prerequisites**
>
> - Access to an OfficeRnD Flex admin account (or an invitation from a teammate).
> - A cloned copy of this repo with the `.env` file ready to edit.

---

## Table of Contents

1. [Step 1 — Get an OfficeRnD Organisation](#step-1--get-an-officernd-organisation)
2. [Step 2 — Create an Application (Developer Tools)](#step-2--create-an-application-developer-tools)
3. [Step 3 — Copy Client ID & Client Secret](#step-3--copy-client-id--client-secret)
4. [Step 4 — Find Your Organisation Slug](#step-4--find-your-organisation-slug)
5. [Step 5 — Choose Your Scopes](#step-5--choose-your-scopes)
6. [Step 6 — Fill In `.env`](#step-6--fill-in-env)
7. [Step 7 — Generate a Token (Verify Credentials)](#step-7--generate-a-token-verify-credentials)
8. [Step 8 — Make Your First API Request](#step-8--make-your-first-api-request)
9. [Step 9 — Run the Dashboard Smoke Test](#step-9--run-the-dashboard-smoke-test)
10. [Optional — Webhooks](#optional--webhooks)
11. [Optional — Static Bearer Token](#optional--static-bearer-token)
12. [Environment Variable Reference](#environment-variable-reference)
13. [Troubleshooting](#troubleshooting)

---

## Step 1 — Get an OfficeRnD Organisation

You need access to an OfficeRnD **organisation** before you can use the API.

- **New organisation**: Request one through [officernd.com](https://www.officernd.com/).
- **Join an existing one**: Ask a teammate to [invite you as an admin](https://help.officernd.com/en/articles/248618-flex-add-a-new-admin-user-to-your-officernd-account).

Once you can log in to the OfficeRnD admin panel, proceed to the next step.

---

## Step 2 — Create an Application (Developer Tools)

Navigate to **Settings → Data & Extensibility → Developer Tools** in the OfficeRnD admin panel.

This page lists all applications that have been created for your organisation.

Click **Create Application** and fill in:

| Field | What to enter |
|-------|---------------|
| **Name** | A descriptive name, e.g. `CTRL AgentOps` |
| **Description** | Short description of what the app does |
| **Image** | Optional — a logo or icon |
| **Permissions** | Start with **read-only** on the resources you need (members, companies, payments, etc.). API v2 uses fine-grained, resource-level permissions. |

![Creating a new application in OfficeRnD](images/officernd-create-app.png)

> **📘 Note**
>
> Deleting applications is **only** possible by contacting the OfficeRnD support team at [support@officernd.com](mailto:support@officernd.com).

---

## Step 3 — Copy Client ID & Client Secret

After creating the application, you'll see two buttons next to it — **Configure** and **View**:

![Application list showing Configure and View buttons](images/officernd-app-list.png)

- **Configure** — change name, description, image, or permissions.
- **View** — reveals the **Client ID** and **Client Secret**.

Click **View** to see your credentials:

![Client ID and Client Secret displayed after clicking View](images/officernd-client-credentials.png)

Copy these values — you'll paste them into `.env` in [Step 6](#step-6--fill-in-env).

---

## Step 4 — Find Your Organisation Slug

The **slug** identifies your organisation in all API URLs:

```
https://app.officernd.com/api/v2/organizations/{slug}/…
```

To find it:

1. Go to **Settings → My Account**.
2. Look at the **Admin Site** and **Members Portal** fields — both contain your slug.

![Organisation slug shown in Settings → My Account](images/officernd-org-slug.png)

For example, if your Admin Site URL is `https://app.officernd.com/admin/ctrlcollective`, then your slug is `ctrlcollective`.

---

## Step 5 — Choose Your Scopes

OfficeRnD uses **fine-grained OAuth scopes** that match the permissions you set on your application.

Scopes follow the pattern:

```
flex.<area>.<resource>.<action>
```

**Examples**:

| Scope | Grants |
|-------|--------|
| `flex.community.members.read` | Read members |
| `flex.billing.payments.read` | Read payments |
| `flex.space.bookings.read` | Read bookings |
| `flex.settings.organization.read` | Read org settings |

> **❗ Important**
>
> The scopes you request in your token call **must not exceed** the permissions set on the application. An app with only "Read" permissions cannot generate a token with "Create" scope.

Build a **space-separated** string of all the scopes you need. Start minimal — you can always add more later by updating the app permissions and scope string together.

**Minimal example** (members only):

```
flex.community.members.read
```

**Broader example** (billing + community + space):

```
flex.billing.payments.read flex.community.members.read flex.community.companies.read flex.space.bookings.read flex.space.locations.read
```

---

## Step 6 — Fill In `.env`

Open your `.env` file (see `flexagents/.env`) and set the OfficeRnD variables:

```bash
# --- OfficeRnD (see docs/officernd-env.md) ---
OFFICERND_TOKEN_URL="https://identity.officernd.com/oauth/token"
OFFICERND_ORG_SLUG="your-org-slug"                    # from Step 4
OFFICERND_CLIENT_ID="your-client-id"                   # from Step 3
OFFICERND_CLIENT_SECRET="your-client-secret"           # from Step 3
OFFICERND_OAUTH_SCOPE="flex.community.members.read"    # from Step 5
OFFICERND_MODE="live"                                  # enables live API calls
OFFICERND_ACCESS_TOKEN=""                              # leave empty when using client credentials
```

> **⚠️ Security**
>
> - Do **not** commit `.env` to version control (keep it in `.gitignore`).
> - Do **not** paste secrets into chat, tickets, or documentation.

---

## Step 7 — Generate a Token (Verify Credentials)

Before starting the app, verify your credentials work by generating a token manually.

### Token endpoint

```
POST https://identity.officernd.com/oauth/token
Content-Type: application/x-www-form-urlencoded
```

### Request body parameters

| Parameter | Value |
|-----------|-------|
| `client_id` | Your Client ID from Step 3 |
| `client_secret` | Your Client Secret from Step 3 |
| `grant_type` | `client_credentials` |
| `scope` | Your scope string from Step 5 |

### cURL example

```bash
curl -X POST \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "client_id={your_client_id}&client_secret={your_client_secret}&grant_type=client_credentials&scope=flex.community.members.read" \
  https://identity.officernd.com/oauth/token
```

### Expected response (200 OK)

```json
{
  "access_token": "<access_token>",
  "token_type": "Bearer",
  "expires_in": 3599,
  "scope": "flex.community.members.read"
}
```

Key points:
- Tokens are valid for **3600 seconds (1 hour)**.
- `expires_in` shows the remaining time in seconds.
- FlexAgents handles token refresh automatically — you do not need to manually rotate tokens.

### Postman example

You can also generate tokens using Postman. Set it up as a POST request to the token URL with `x-www-form-urlencoded` body:

![Postman token generation example](images/officernd-postman-token.png)

> **❗ CORS is disabled** on the token endpoint for security reasons. Exchange credentials through a server application (Node.js, Python, Go, .NET) or cURL — not from a browser.

### If the request fails

- **401 Unauthorized**: Double-check `client_id` and `client_secret`.
- **400 Bad Request / invalid_scope**: Your scope string doesn't match the permissions set on the application. Review Step 5 and your app's permission settings.
- See [Troubleshooting](#troubleshooting) for more help.

---

## Step 8 — Make Your First API Request

With a valid token, you can call any OfficeRnD API endpoint.

### Example: Get Members

```bash
curl --request GET \
     --url https://app.officernd.com/api/v2/organizations/{org-slug}/members \
     --header 'accept: application/json' \
     --header 'authorization: Bearer {access_token}'
```

### Example response

```json
{
  "rangeStart": 1,
  "rangeEnd": 1,
  "cursorNext": "string",
  "cursorPrev": "string",
  "results": [
    {
      "_id": "664c6947e59b00c0bb1a2ad9",
      "name": "John Doe",
      "email": "john@doe.com",
      "location": "664c6947e59b0050731a2aca",
      "company": "664c6947e59b0031c71a2ad1",
      "status": "contact",
      "createdAt": "2024-05-21T09:28:39.360Z",
      "modifiedAt": "2025-03-25T09:34:07.936Z",
      "properties": {
        "hubspot_link_id": "49511990-108680244395"
      }
    }
  ]
}
```

### Using the developer portal

You can also make requests directly in the [OfficeRnD developer documentation portal](https://developer.officernd.com/reference) by pasting your token into the **Authentication** field in the top-right corner.

### Using the Authorization header

Add this header to every API request:

```
Authorization: Bearer <access_token>
```

> **❗ Important**
>
> Before making API requests, read the guide on [querying data](https://developer.officernd.com/docs/building-queries). The API has specific limitations that apply to certain endpoints.

---

## Step 9 — Run the Dashboard Smoke Test

With `OFFICERND_MODE=live` and valid credentials in `.env`:

1. Start FlexAgents: `npm run dev`
2. Log in as **Admin**.
3. Open **`/admin/officernd`** in your browser.
4. Use the grouped buttons to call one Flex API v2 list (or organisation GET) per OAuth scope.

Paths are defined in `lib/officernd/scope-test-catalog.ts`. If OfficeRnD returns **404** for an entity type, check the [API reference](https://developer.officernd.com/reference) and adjust the path segment in `lib/officernd/entity-paths.ts`.

---

## Optional — Webhooks

If you want real-time event notifications from OfficeRnD:

1. In OfficeRnD: **Settings → Developer Tools → Webhooks → Add Endpoint**.
2. Set **Endpoint URL** to your public AgentOps URL:
   ```
   https://<your-domain>/api/webhooks/officernd
   ```
   (must match `APP_BASE_URL` in production)
3. Choose the **events** you want to subscribe to (start small while testing).
4. If the UI provides a **signing secret** (HMAC secret), put it in:
   ```bash
   OFFICERND_WEBHOOK_SECRET="your-signing-secret"
   ```
5. Without a configured secret, **production** webhook verification stays locked down (see `lib/officernd/webhook-verify.ts`).

---

## Optional — Static Bearer Token

If you prefer not to use client credentials flow, you can set a static bearer token:

```bash
OFFICERND_ACCESS_TOKEN="your-bearer-token"
```

When set, you can leave `OFFICERND_CLIENT_ID`, `OFFICERND_CLIENT_SECRET`, and `OFFICERND_OAUTH_SCOPE` empty.

> **⚠️ Warning**: Tokens from `client_credentials` expire after ~1 hour. A static token is mainly useful for quick testing unless something else refreshes it for you.

---

## Environment Variable Reference

### REST API (`getOfficeRnDClient()`)

| Variable | Required (live) | Purpose |
|----------|----------------|---------|
| `OFFICERND_MODE` | — | `stub` (default) or `live` |
| `OFFICERND_ORG_SLUG` | yes | Organisation slug in URLs |
| `OFFICERND_ACCESS_TOKEN` | one of * | Static bearer token |
| `OFFICERND_CLIENT_ID` | one of * | OAuth app id |
| `OFFICERND_CLIENT_SECRET` | one of * | OAuth app secret |
| `OFFICERND_OAUTH_SCOPE` | with client creds | Space-separated scopes |
| `OFFICERND_TOKEN_URL` | no | Token endpoint (default: `https://identity.officernd.com/oauth/token`) |

\* Live mode needs **either** `OFFICERND_ACCESS_TOKEN` **or** all three of `OFFICERND_CLIENT_ID` + `OFFICERND_CLIENT_SECRET` + `OFFICERND_OAUTH_SCOPE`.

Token responses may return `token` or `access_token`; both are handled. OAuth tokens are cached in memory and refreshed before expiry.

### Webhooks (`POST /api/webhooks/officernd`)

| Variable | Required (prod) | Purpose |
|----------|----------------|---------|
| `OFFICERND_WEBHOOK_SECRET` | yes | HMAC signing key; without it, production rejects webhooks |

### Setup checklist

| Done? | Variable | Where you get it |
|-------|----------|-----------------|
| | `OFFICERND_ORG_SLUG` | Settings → My Account → Admin Site URL |
| | `OFFICERND_CLIENT_ID` | Developer Tools → your app → **View** |
| | `OFFICERND_CLIENT_SECRET` | Developer Tools → your app → **View** |
| | `OFFICERND_OAUTH_SCOPE` | Must match your app's allowed scopes (see [Step 5](#step-5--choose-your-scopes)) |
| | `OFFICERND_MODE` | Set to `live` when the above are set |
| | `OFFICERND_WEBHOOK_SECRET` | Webhooks → your endpoint (if signing secret shown) |
| | `APP_BASE_URL` | Your deployed AgentOps base URL (for webhook config) |

---

## Troubleshooting

### Token Acquisition Fail (Scope Mismatch)

**Symptom**: On one machine the connection works; on another you get:

```
Token acquisition fail
The value in OFFICERND_OAUTH_SCOPE does not match what the OfficeRnD app
registration allows, or it uses the wrong scope names for this tenant.
```

**Cause**: The `OFFICERND_OAUTH_SCOPE` value in `.env` on the failing machine is incorrect, outdated, or formatted differently than what the app registration expects.

**Fix**:

1. On the **working** machine, open `.env` and copy the exact `OFFICERND_OAUTH_SCOPE` value.
2. Paste it into `.env` on the failing machine.
3. Also verify `OFFICERND_CLIENT_ID` and `OFFICERND_CLIENT_SECRET` match if both machines use the same app registration.
4. Restart the dev server.

### 404 on API calls

If a list or get call returns **404** for a specific entity type, the path segment may not match the current API. Grab the correct path from the [API reference](https://developer.officernd.com/reference) and update `lib/officernd/entity-paths.ts`.

### 401 Unauthorized

- Verify `client_id` and `client_secret` are correct.
- Ensure the application hasn't been deleted or reconfigured.
- Try generating a new token manually (see [Step 7](#step-7--generate-a-token-verify-credentials)).

### Invalid scope errors

- Scopes must exactly match what's allowed by your app's permissions.
- Scope names are case-sensitive and follow the `flex.<area>.<resource>.<action>` pattern.
- If unsure, create a new app with minimal read permissions and use the scope OfficeRnD documents for those permissions.

---

## Further Reading

- [OfficeRnD API Reference](https://developer.officernd.com/reference)
- [Querying Data Guide](https://developer.officernd.com/docs/building-queries)
- [API v2 Migration Guide](https://developer.officernd.com/docs/api-v2-migration-guide)
- [Creating & Managing Webhooks](https://developer.officernd.com/docs/creating-and-managing-webhooks)
- [Environment variable reference](../officernd-env.md) (detailed `.env` doc)
- [Troubleshooting guide](officernd-troubleshooting.md) (additional issues)
