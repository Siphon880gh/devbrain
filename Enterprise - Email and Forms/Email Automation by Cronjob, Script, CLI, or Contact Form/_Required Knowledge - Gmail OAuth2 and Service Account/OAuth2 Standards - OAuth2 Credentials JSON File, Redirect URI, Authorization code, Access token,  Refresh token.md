
The components of the OAuth2 standards are:
- OAuth2 Credentials JSON File
- Redirect URI
- Authorization code
- Access token
- Refresh token (Optional)

The types of OAuth2 access are:
- Offline
	- Long persistent, as in the user may go offline on the app, but access will still be needed in the background or for later when the user returns (instead of making them go through the OAuth2 screens again)
- Online
	- Access token expires after 1 hour and that's it

It's coded as:
```
access_type: "online" | "offline"
```

---

## 🧠 Typical Flow Timeline

**(Before Step 1)**  
📁 **Backend loads OAuth2 client credentials**

Before anything begins, your backend reads the **OAuth 2.0 Client Credentials `.json` file**, which contains:

- `client_id` (there needs to be an id that identifies your app on Google's dashboard)
- `client_secret` (but you gotta have some sort of secret or password)
- `redirect_uris`

This file is downloaded from Google Cloud Console when you create an OAuth 2.0 client ID. It is used to configure the `oauth2Client` instance like this:

```js
const key = require('./credentials.json').installed;

const oauth2Client = new google.auth.OAuth2(
  key.client_id,
  key.client_secret,
  key.redirect_uris[0] // typically something like http://localhost:3001/oauth2callback
);
```

> ⚠️ **Do not confuse** this with a **service account `.json` file**, which is used for server-to-server API access (e.g., Google Workspace apps), not for Gmail OAuth2.

---

### Then:

1. 🔗 **Backend generates OAuth URL** with:
    
    ```js
    access_type: 'offline',
    prompt: 'consent',
    scope: ['https://mail.google.com']
    ```
    
2. 👤 **Frontend redirects the user** to that OAuth URL. The user sees the **consent screen** if:
    
    - It’s their **first time** using your app, or
    - You’ve explicitly set `prompt: 'consent'`
        
3. 🔁 **Google redirects back to your site**, e.g.:
    
    ```
    /oauth2callback?code=AUTHORIZATION_CODE
    ```
    
4. 📬 **Your backend handles the `/oauth2callback` route**. It extracts the URL query `code`  uses the OAuth2 client SDK to exchange it for token(s):
    
    ```js
    const { tokens } = await oauth2Client.getToken(code);
    ```
    
    - ✅ `tokens.access_token` — valid for ~1 hour
        
    - ✅ `tokens.refresh_token` — it's only defined if:    
        - It's the user's **first** consent, or
        - You used `prompt: 'consent'` with `access_type: 'offline'`
    
5. 🧠 Later, when the `access_token` expires:

	Requirement: Let's say you've already have set the refresh icon with:
	```
	oauth2Client.setCredentials({
	  refresh_token: 'your_stored_refresh_token_here'
	});
	```

	Then you can get a new access token with
    ```js
    const refreshedTokens = await oauth2Client.refreshAccessToken();
    ```
    
    - ✅ The access token is inside: `refreshedTokens.access_token`
    - That `refreshedTokens` also contains the token_type and expiry_date,
    - 🔄 **No user interaction needed** — session continues seamlessly


---

## 📌 Clarification on `access_type: 'offline'`

- It **does not** mean you must refresh the token every hour.
- It **enables** your app to access user data _while they’re offline_, by giving you a `refresh_token` you can use _on-demand_.
    

The idea is:

> “Give me a `refresh_token` so I can keep working after the user leaves.”


---
## 📌  Clarification on `prompt: 'consent'`

This option is **optional** — but critical depending on your use case.

### ✅ If not set:

- Google will show the **consent screen only the first time** the user uses your app.
    
- On future logins, if the user already granted access, Google will **skip the consent screen** and redirect immediately with a new `code` (but **without** a new `refresh_token`).
    

### ✅ If set to `'consent'`:

- Google will **always show the consent screen**, even if the user already authorized your app.
    
- This is required if you want Google to issue a **new `refresh_token`** — for example, if the original was lost or revoked.
    

> ⚠️ But don’t worry: you don’t need to make users see the consent screen every time they return.

In most production apps:

- You **store the `refresh_token`** on the server after the first authorization.
- When the user comes back, you identify them via **cookies, sessions, or local storage**.
- Then, you silently use the **server stored `refresh_token`** to generate a new `access_token`.

So while `prompt: 'consent'` is required _once_ to obtain a refresh token, it’s not something you show the user repeatedly — unless you're re-authorizing or onboarding again.


---
## 🔑 Reasoning Behind These Standards

Understanding how tokens work helps balance **security** and **user experience**:

- When you receive an **authorization `code`**, it means the user just completed a **new login session**.  
    → Unless you use `prompt: 'consent'`, Google may skip the consent screen if the user already approved your app.
    
- When you use a **`refresh_token`** to obtain a new `access_token`, you're continuing the **same session silently**.  
    → This is useful for background jobs or when the user returns later — no need to prompt them to log in again.

### 🔄 `refresh_token` Is Optional

The `refresh_token` is **not always required**. It’s only needed when:

- You expect **long sessions**
- User wants you to on their behalf when they leave the website (eg. Google Sheet automation)
- The user may go **offline** and return later
- You want to provide a seamless **“Remember Me”** experience

If you don’t need persistent access, you can rely solely on the `access_token`, which by design is **short-lived (1 hour)** for security.  

This short expiration limits the risk if the token is exposed.

The `refresh_token` adds convenience to that model — allowing your app to stay logged in without compromising security. This is because when the access_token is used with every Google service interaction, there's a risk of a hacker getting your access_token.


### 📊 How to Audit

If you're logging or auditing sessions:
- If access comes from `getToken(code)`, it's a **new login flow**
- If access comes from `refreshAccessToken()`, it's a **continuation of an earlier session**

### 🔐 Security Perspective

- The `refresh_token` should be stored **securely on your backend** (never exposed to frontend code).
- The `access_token` is used for all API requests and expires quickly — reducing the impact of accidental leaks.
- This layered approach offers **built-in containment** and **optional convenience** depending on your app’s needs.


---

## ✅ Summary

### 🔄 Token Responsibilities

| Token           | Purpose                                                                                                                                                                     |
| --------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `access_token`  | Used to access Gmail/Google APIs; expires in ~1 hour                                                                                                                        |
| `refresh_token` | May or may not be returned to you by the Oauth2 Client SDK when exchanging authorization code. <br><br>Stored securely; used to silently get new `access_token` when needed |
| `expiry_date`   | Timestamp (ms) when current `access_token` expires                                                                                                                          |
|                 |                                                                                                                                                                             |

---

## 🔁 Two Ways a New `access_token` Is Created

|Method|Indicates...|User Interaction?|Source|
|---|---|---|---|
|`getToken(code)`|🆕 New session/login|✅ Yes|Authorization Code|
|`refreshAccessToken(refresh_token)`|🔄 Same session continued|❌ No|Stored Refresh Token|

---

## 🎛 Key OAuth2 Options & Their Roles

|Option|What It Does|Required for Refresh Token?|
|---|---|---|
|`access_type: 'offline'`|Asks Google for a long-term refresh token for background access|✅ Yes|
|`prompt: 'consent'`|Forces user to re-consent and allows issuing a new refresh token even if they consented before|✅ If re-requesting|

---

## 🔐 OAuth2 Flow Summary — Gmail Example

|Item|When It's Generated|Where It Appears|Depends On|Purpose|
|---|---|---|---|---|
|**OAuth2 URL**|When your backend calls `oauth2Client.generateAuthUrl()`|Sent to frontend → browser|Can include `access_type`, `prompt`, `scope`|Starts the OAuth2 flow|
|**Consent Screen**|When user clicks OAuth URL|On Google’s site|First-time or `prompt: 'consent'`|Lets user approve app access|
|**Authorization Code**|After user consents|In browser URL: `/oauth2callback?code=...`|Returned only after successful user consent|One-time code to exchange for tokens|
|**Access Token**|After exchanging `code` or using a `refresh_token`|In backend response to `getToken()` or refresh|Always short-lived (~1 hour)|Used to call Gmail or other APIs|
|**Refresh Token**|Only after code exchange w/ `access_type: 'offline'`|Returned once (or again if forced via prompt)|`access_type: 'offline'` + consent (first-time or `prompt: 'consent'`)|Used to silently get new access tokens over time|
