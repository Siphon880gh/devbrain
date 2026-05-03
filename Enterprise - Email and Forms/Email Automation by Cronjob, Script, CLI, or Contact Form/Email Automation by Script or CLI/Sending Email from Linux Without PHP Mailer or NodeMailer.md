You do not always need PHP Mailer, NodeMailer, or a full app runtime just to send email.

For many basic Linux use cases, you can send email at the operating-system level with tools like `msmtp` or `swaks`.

This is useful for:

- cron jobs
    
- server alerts
    
- backup scripts
    
- contact form fallbacks
    
- automation scripts
    
- internal admin tools
    

Instead of writing a PHP or Node app just to send one email, Linux can talk directly to your email provider’s SMTP server.

---

# The Usual Setup for Most Email Providers

Most email providers still support normal SMTP sending.

The basic setup usually looks like this:

```txt
SMTP server: smtp.yourprovider.com
Port: 587 or 465
Security: STARTTLS or SSL/TLS
Username: your email address
Password: app password, SMTP password, or SMTP/API token
```

You configure those settings once, then your Linux server can send email from scripts.

For example, a provider may give you settings like:

```txt
SMTP host: smtp.example.com
SMTP port: 587
Username: you@example.com
Password: your SMTP password
Encryption: STARTTLS
```

Then you place those settings into a Linux SMTP tool.

---

# Do You Need `msmtp`, `swaks`, or Both?

You do **not** need both.

Think of them like this:

```txt
msmtp = the actual lightweight email sender
swaks = optional SMTP testing/debugging tool
```

`msmtp` is the tool you normally use when your server needs to send email. Debian describes it as a light SMTP client that forwards mail to an SMTP server, such as a free mail provider. ([Debian Packages](https://packages.debian.org/testing/mail/msmtp?utm_source=chatgpt.com "Debian -- Details of package msmtp in forky"))

`swaks` is mainly for testing and debugging SMTP. Debian describes it as the “Swiss Army Knife SMTP,” useful for testing SMTP setups with STARTTLS and SMTP authentication. ([Debian Packages](https://packages.debian.org/sid/swaks?utm_source=chatgpt.com "Debian -- Details of package swaks in sid"))

So the simple rule is:

```txt
Normal sending: install msmtp
Troubleshooting SMTP: install msmtp + swaks
Gmail API with OAuth2/curl: you do not need either
```

---

# Install Option 1: Only Install `msmtp`

Use this if you just want Linux to send email from scripts, cron jobs, alerts, or automation.

```bash
sudo apt update
sudo apt install msmtp
```

Create your config file:

```bash
nano ~/.msmtprc
```

Example config:

```txt
defaults
auth on
tls on
tls_starttls on
tls_trust_file /etc/ssl/certs/ca-certificates.crt

account default
host smtp.yourprovider.com
port 587
from you@example.com
user you@example.com
password YOUR_SMTP_PASSWORD
```

Secure the file:

```bash
chmod 600 ~/.msmtprc
```

Send a test email:

```bash
printf "Subject: Test email\n\nHello from Linux." | msmtp someone@example.com
```

This is the simplest setup for many normal SMTP providers.

---

# Install Option 2: Install `msmtp` and `swaks`

Use this if you want both a sender and a testing tool.

```bash
sudo apt update
sudo apt install msmtp swaks
```

Use `msmtp` for normal sending:

```bash
printf "Subject: Test email\n\nHello from Linux." | msmtp someone@example.com
```

Use `swaks` when you want to test the SMTP connection directly:

```bash
swaks \
  --to someone@example.com \
  --from you@example.com \
  --server smtp.yourprovider.com \
  --port 587 \
  --tls \
  --auth LOGIN \
  --auth-user you@example.com \
  --auth-password YOUR_SMTP_PASSWORD
```

This helps you confirm whether the SMTP server, port, TLS, username, and password are working before you wire it into scripts.

---

# Why This Is Useful

This Linux-level setup keeps email sending simple.

Instead of this:

```txt
Install Node
Install npm packages
Install NodeMailer
Write a script
Manage dependencies
Run the app
```

Or this:

```txt
Install PHP
Install Composer
Install PHP Mailer
Write a PHP script
Run it through PHP
```

You can often do this:

```txt
Install msmtp
Add SMTP settings
Pipe a message into msmtp
```

That is enough for many server tasks.

---

# The Gmail Problem

Gmail is where things get more complicated.

Gmail still has SMTP settings, but the problem is authentication. For many older guides, the answer was simple: create a Gmail app password and use it with `smtp.gmail.com`.

That can still work, but only if the Google account supports app passwords.

Google says app passwords require 2-Step Verification, and the app-password option may not be available for some accounts, such as accounts using certain security setups, organization-managed accounts, or accounts enrolled in stronger protection programs. ([Google Help](https://support.google.com/accounts/answer/185833?hl=en&utm_source=chatgpt.com "Sign in with app passwords - Google Account Help"))

So with Gmail, the easy path is:

```txt
Gmail account supports app passwords
→ create Gmail app password
→ use smtp.gmail.com
→ send with msmtp, swaks, PHP Mailer, or NodeMailer
```

But the harder path is:

```txt
Gmail account does not support app passwords
→ simple SMTP password login may not work
→ you likely need OAuth2
→ use Gmail API or OAuth2-based sending
```

This is why Gmail can feel annoying compared with other email providers. With many normal providers, you can create an SMTP password or API token and be done. With Gmail, Google may push you into OAuth2 instead.

---

# Gmail OAuth2 Usually Means Gmail API

When Gmail app passwords are not available, you usually need OAuth2.

That means your app or script has to:

```txt
1. Create a Google Cloud project
2. Enable the Gmail API
3. Create OAuth2 credentials
4. Open a Google consent screen
5. Get an authorization code
6. Exchange that code for tokens
7. Store the refresh token
8. Use the refresh token to get short-lived access tokens
9. Use the access token to send email
```

This is why many developers use a runtime like Node or Python. The OAuth2 flow is easier when a library handles the token exchange, refresh token storage, and API calls.

But technically, Gmail API is still just an HTTPS API. Google documents `users.messages.send` as the Gmail API method for sending messages. ([Google for Developers](https://developers.google.com/workspace/gmail/api/reference/rest/v1/users.messages/send?utm_source=chatgpt.com "Method: users.messages.send | Gmail")) Google’s Gmail API guide also says messages can be sent directly with `messages.send` or from a draft with `drafts.send`. ([Google for Developers](https://developers.google.com/workspace/gmail/api/guides/sending?utm_source=chatgpt.com "Create and send email messages | Gmail"))

That means you can still use shell scripts and `curl` if you are comfortable handling OAuth2 yourself.

---

# Gmail API with Shell and `curl`

With the Gmail API path, you are not using SMTP anymore.

You are calling Google’s Gmail API over HTTPS.

The rough flow looks like this:

```txt
Refresh token
→ exchange for access token
→ build email message
→ base64url encode it
→ POST it to Gmail API with curl
```

A simplified request looks like this:

```bash
curl -X POST \
  "https://gmail.googleapis.com/gmail/v1/users/me/messages/send" \
  -H "Authorization: Bearer ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "raw": "BASE64URL_ENCODED_EMAIL_MESSAGE"
  }'
```

So even though people often use Node, Python, or PHP for Gmail OAuth2, it is not impossible from shell.

The difference is responsibility.

With Node or Python, a library can manage OAuth2 for you.

With shell and `curl`, you have to manage more yourself:

```txt
OAuth2 authorization URL
Authorization code
Refresh token
Access token refresh
Token expiration
Base64url email formatting
Gmail API request
```

That is doable, but it is more work than normal SMTP.

---

# Practical Recommendation

For most email providers:

```txt
Use msmtp.
```

For debugging SMTP:

```txt
Use swaks.
```

For Gmail with app passwords available:

```txt
Use Gmail SMTP + msmtp.
```

For Gmail without app passwords:

```txt
Use OAuth2 + Gmail API.
```

For simple server alerts, cron jobs, and automation emails, `msmtp` is usually the cleanest Linux-level solution.

For Gmail specifically, the setup depends on whether Google gives your account access to app passwords. If it does, Gmail can work like a normal SMTP provider. If it does not, you are no longer in simple SMTP territory — you are in OAuth2 and Gmail API territory.