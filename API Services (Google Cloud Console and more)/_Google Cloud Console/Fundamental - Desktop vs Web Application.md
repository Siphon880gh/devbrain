When you create an **OAuth 2.0 Client ID** in Google Cloud, Google asks you to choose an **Application type**.

This matters because the application type controls how your app is allowed to complete the OAuth flow, where it can receive the callback, and how safely it can store credentials.

The common options are:

```txt
Desktop App
Web Application
Service Account
```

---

# Why Google Makes You Choose an Application Type

Google asks for an **Application type** mostly for security.

Different apps have different risks. A website, CLI script, desktop app, mobile app, and server-to-server process all handle credentials differently.

Google wants to know:

```txt
Where is this app running?
Can this app safely store a client secret?
Where should Google send the OAuth callback?
Is this app used by one trusted user or many outside users?
What kind of redirect URLs should be allowed?
How risky is the authorization flow?
```

OAuth gives your app access to a Google account. Depending on the scopes, that could mean access to Gmail, Calendar, Drive, Sheets, or other sensitive data.

So Google needs guardrails around the flow.

For example:

```txt
A backend web app can safely store a client secret.
A browser app cannot safely store a client secret.
A desktop app may run locally and use localhost redirects.
A service account may not need a human user to sign in at all.
```

That is why the application type matters.

---

# Simple Recommendation

```txt
Many users signing into your web app
→ Use Web Application

One trusted Google account authorizing a CLI script or backend automation
→ Use Desktop App

Server-to-server access without a real user signing in
→ Consider a Service Account
```

---

# When to Use Web Application

Choose **Web Application** when your app has users signing in through a website or web app.

Use this for:

```txt
SaaS apps
Web dashboards
Multi-user apps
Apps where many users connect their own Google account
Apps using a real backend OAuth callback URL
```

Example callback URL:

```txt
https://yourdomain.com/oauth/google/callback
```

Typical flow:

```txt
User clicks "Connect Google"
→ Your backend generates the Google OAuth URL
→ User signs in with Google
→ Google redirects back to your callback URL
→ Your backend receives the authorization code
→ Your backend exchanges the code for tokens
→ Your app stores the refresh token securely
```

This is the normal choice when each customer, client, or team member connects their own Google account to your app.

---

# Why Web Application Is Better for Many Users

A **Web Application** OAuth client is built for a backend server that handles many users.

It supports controlled redirect URLs like:

```txt
https://yourdomain.com/oauth/google/callback
```

That lets Google make sure OAuth responses only go back to approved domains.

This helps prevent attacks where someone tries to steal an authorization code by redirecting the user to a fake callback URL.

Web Application is also better because your backend can:

```txt
Store the client secret safely
Verify the OAuth state value
Store each user’s refresh token separately
Track which Google account belongs to which app user
Handle re-authorization when a token expires or gets revoked
```

So when you are building a real web app with many users, Google expects you to use **Web Application**, not Desktop App.

---

# When to Use Desktop App

Choose **Desktop App** when you are authorizing a tool, script, CLI process, or local/backend automation for one trusted Google account.

Use this for:

```txt
CLI scripts
Local developer tools
Personal automations
A backend process that uses one master Google account
A 24/7 worker that needs Gmail, Drive, Sheets, Calendar, etc.
```

Example:

```txt
You have one master Gmail account.
You authorize it once.
Your backend stores the refresh token.
Your script uses that refresh token to get new access tokens when needed.
```

Typical flow:

```txt
CLI script opens Google OAuth URL
→ You sign in with the master Google account
→ Google sends back an authorization code
→ Your script exchanges the code for tokens
→ You securely store the refresh token
→ Your backend uses it to keep running
```

This is often easier for internal tools because you do not need a public web callback domain just to authorize one account.

---

# Does Google Expect Only One Account for a Desktop App?

Not exactly.

A **Desktop App** OAuth client is not strictly limited to one Google account.

Technically, multiple Google accounts can authorize the same Desktop App client.

But in practice, Desktop App is usually meant for:

```txt
Installed apps
Local tools
CLI scripts
Developer tools
Internal automations
One trusted user or a small trusted group
```

Google does not enforce “only one account,” but the Desktop App flow is designed for apps running in a local or installed environment, not for a public multi-user SaaS app.

For example, this is a good Desktop App use case:

```txt
You run a backend CLI process.
It uses one master Google account.
You authorize it once.
It stores a refresh token securely.
The process runs 24/7.
```

This is usually not a good Desktop App use case:

```txt
You have 500 customers.
Each customer clicks “Connect Google” inside your web dashboard.
You manage all their OAuth callbacks through your production website.
```

For that, use **Web Application**.

---

# The Big Security Difference

The main difference is whether the app can keep secrets.

## Web Application

A backend web app can safely store:

```txt
Client ID
Client secret
Refresh tokens
User-token mappings
```

Because these stay on the server.

## Desktop App

A desktop app or CLI tool cannot fully hide secrets from the machine it runs on.

Even if you put a client secret inside the app, a technical user could inspect the app and extract it.

So Desktop App OAuth clients are treated differently. The flow is designed around local authorization, not around a public production backend serving many users.

---

# Important Caveats and Gotchas

## 1. Testing mode can expire refresh tokens after 7 days

If your OAuth consent screen is still in **Testing** mode, refresh tokens for external users may expire after 7 days.

This is one of the most common reasons a working OAuth setup suddenly breaks with an error like:

```txt
invalid_grant
```

For long-running automation, you usually want the app moved to **Production** mode.

---

## 2. Production mode does not mean refresh tokens last forever

Moving an OAuth app to **Production** mode can remove the 7-day testing limit, but it does not mean a refresh token is permanent forever.

A refresh token can still stop working if:

```txt
The user revokes access
The Google account password changes in some sensitive-scope cases
The token is unused for a long time
Too many refresh tokens are created for the same user/client
The app violates Google OAuth policies
The scopes or consent requirements change
```

So your app should always handle token failure and have a re-authorization process.

---

## 3. You may not get a refresh token every time

Google usually returns a refresh token the first time a user grants offline access.

During development, developers often re-run the OAuth flow and wonder why no new refresh token appears.

To request a refresh token, your OAuth URL usually needs:

```txt
access_type=offline
```

During development, you may also use:

```txt
prompt=consent
```

But for a real user-facing app, do not force consent every time unless you have a good reason. It creates a worse user experience.

---

## 4. Store refresh tokens like passwords

A refresh token can be used to generate new access tokens. Treat it like a secret.

Do not store it in:

```txt
Frontend JavaScript
LocalStorage
Public GitHub repos
Plain text config files
Client-side code
```

Store it on the backend, preferably encrypted or protected by your server’s secret-management process.

---

## 5. Use Service Accounts only for the right use case

A **Service Account** is not the same as “a backend app.”

Use a service account when the app itself owns the resource or when you are using Google Workspace domain-wide delegation.

Good use cases:

```txt
Accessing Google Cloud resources
Writing to a Google Sheet owned by the service account
Server-to-server automation
Workspace admin-approved domain-wide delegation
```

Bad assumption:

```txt
"I have a backend, so I should always use a service account."
```

If your app needs to access a real user’s Gmail, Drive, Calendar, or personal Google data, you usually need OAuth user consent instead.

---

# Developer Rule of Thumb

```txt
Use Web Application when real users sign into your web app.

Use Desktop App when you are authorizing one trusted account for a CLI/local/internal automation.

Use Service Account when no human user needs to sign in and the app is accessing app-owned or admin-delegated resources.
```

For this specific case:

```txt
Backend CLI process running 24/7
One master Google account
Needs to keep using Google APIs after initial authorization
```

Recommended application type:

```txt
Desktop App
```

---

# Final Summary

Google asks for the OAuth application type because each app type has a different security model.

```txt
Desktop App means:
“This runs locally or as an installed/internal tool.”

Web Application means:
“This runs on a backend server and may support many users.”

Service Account means:
“This is server-to-server access without normal user sign-in.”
```

So the simplest way to decide is:

```txt
Many users logging into your website?
→ Web Application

One trusted Google account for a CLI script or backend worker?
→ Desktop App

No user login, app-owned resources, or Workspace admin delegation?
→ Service Account
```