
Note: This approach is appropriate for websites or web apps where the user would've signed up or logged in using their Google account. 

### ✅ **Big Picture**

When someone submits a form on your website—whether it’s a contact request or a quote inquiry—you don’t want to rely on checking a dashboard to catch new leads. A more reliable approach is to have those submissions automatically emailed to you.

To make that happen, your backend needs to send emails programmatically. This requires a valid `FROM` address, which usually means sending on behalf of an authorized sender. That authorized sender could be the owner's personal gmail address or the owner's Google Workspace email address. But you have something better than the owner's email addresses...

The `From` address could be the visitor's gmail address because they're already authenticated on your website or web app using Google OAuth2. You can capture the visitor's gmail address from their login session. And because you will see the emailed form submission as though the visitor actually emailed you themselves, you can reply with urls, images, or html without deliverability penalty. For good user experience, you may want to show the user their gmail address that they will be contacted back on.

Since the "sender" is not your custom domain, if you own multiple websites with forms, you may want to incorporate the business or website name in the subject to identify which website the message is from.

This guide will show you how to use the visitor's gmail account (authorized when they signed into your website using Google OAuth2) and **Node.js** to send emails via the Gmail API.

---

## 🔐 Requirements

- User needs to authenticate as a Google user on your website or web app. If you had offered multiple ways to sign up, you may want to consider conditionally displaying another type of form for non-Google users. This is a form where the non-Google visitor can enter their email address and the actual sender is the owner's email address. For that too, refer to [[Send Email as Owner from a Website Form Using Personal Gmail, App Password, and Nodemailer]] or [[Send Email as Owner from a Website Form Using Google Workspace, Service Account, Nodemailer]] depending on if the owner's email address is a personal gmail or a Google Workspace email, respectively.
- You want an email at the same time the user submits the form. If instead you are throttling to the next hour, you will need to store the refresh token, then later request for a fresh access token at the time of emailing. That is outside the scope of this document but has been alluded to at [[OAuth2 Standards - OAuth2 Credentials JSON File, Redirect URI, Authorization code, Access token,  Refresh token]]


---

## 1. ⚙️ Google Cloud Setup

1. Go to [Google Cloud Console](https://console.cloud.google.com/).
2. Create a **new project** (or use an existing one).
3. Enable the **Gmail API** for the project.
4. Go to **OAuth Consent Screen**:
    - Set up as "External"
    - Fill in App name, email, etc.
5. Create OAuth credentials:
    - Go to **APIs & Services > Credentials**
    - Click “Create Credentials” > “OAuth client ID”
    - Select "Desktop App" as application type
    - **Download** the `.json` file—it contains your client ID and secret


---
## 2. 🔧 NodeJS Setup
### a. 📦 Install Dependencies

Add these dependencies to your `package.json`:

```json
"dependencies": {
  "express": "^4.19.2",
  "google-auth-library": "^9.9.0",
  "googleapis": "^136.0.0",
  "nodemailer": "^6.9.13"
}
```

### b. 💻 Node.js Script

Make sure to replace:

- `CLIENT-DETAILS.json` with your downloaded OAuth 2.0 credentials
- `you@yourcompany.com` as your recipient email

```js
const nodemailer = require('nodemailer');
const express = require('express');
const { google } = require('googleapis');

const app = express();
const port = 3001;

const key = require('./CLIENT-DETAILS.json').installed;

const oauth2Client = new google.auth.OAuth2(
  key.client_id,
  key.client_secret,
  `http://localhost:${port}/oauth2callback`
);

const scopes = ['https://mail.google.com'];

const url = oauth2Client.generateAuthUrl({
  access_type: 'offline',
  scope: scopes
});

console.log('Visit this URL to authorize access:', url);

async function getUserEmail(oauth2Client) {
  const oauth2 = google.oauth2({
    auth: oauth2Client,
    version: 'v2'
  });

  const res = await oauth2.userinfo.get();
  return res.data.email;
}

async function sendEmail(tokens, userEmail) {
  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      type: 'OAuth2',
      user: userEmail, // use actual authenticated user
      clientId: key.client_id,
      clientSecret: key.client_secret,
      refreshToken: tokens.refresh_token,
      accessToken: tokens.access_token
    }
  });

  const mailOptions = {
    from: userEmail,
    to: 'you@yourcompany.com',
    subject: 'Form Submission Received',
    text: `This was sent from: ${userEmail}`,
    html: `<p>This was sent from: <b>${userEmail}</b></p>`
  };

  transporter.sendMail(mailOptions, (err, info) => {
    if (err) return console.error('Error sending email:', err);
    console.log('Email sent:', info.response);
  });
}


app.get('/oauth2callback', async (req, res) => {
  const { code } = req.query; // oauth2callback?code=****
  try {
    const { tokens } = await oauth2Client.getToken(code);
    oauth2Client.setCredentials(tokens);
    
    const userEmail = await getUserEmail(oauth2Client);
    console.log('Authenticated user email:', userEmail);
    
    res.send('Authentication successful! You may close this window.');
    console.log('Tokens:', tokens);
    await sendEmail(tokens);
  } catch (err) {
    console.error('Token error:', err);
    res.send('Authentication failed.');
  }
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
)
```


^ Note If you tried to set `from` to a different address than the authenticated Gmail account, **Gmail would reject the message** or rewrite the `FROM` header to match the actual sender.
- The code automatically retrieves the gmail address when the user authorizes
- That key code is `const res = await oauth2.userinfo.get();` which contains the authenticated user's email address.

> [!note] ^ At nodemailer.CreateTransporter:
> 
> **🔑 clientId and clientSecret**
> - These identify your app to Google's OAuth 2.0 system.
> - They come from the .json file you downloaded when you created OAuth credentials in the Google Cloud Console.
> - They do not identify the user—they identify the application making the request.
>
> **👤 user:**
> - This is the email address of the user who signed in via OAuth2.
> - It's used to tell Gmail whose mailbox the app is sending from.
> - The accessToken and refreshToken are also tied to this user's account and their granted permissions.
>   


c. 🧪 Test It?

You can't really test this yet because the frontend is really necessary


---

### 3. Adopt the backend for security reasons

Don't forget to sanitizer users's inputs.

You are sending the emails in real time in line with the user form submissions. 

If instead you are throttling to the next hour, you will need to store the refresh token, then later request for a fresh access token at the time of emailing. That is outside the scope of this document but has been alluded to at [[OAuth2 Standards - OAuth2 Credentials JSON File, Redirect URI, Authorization code, Access token,  Refresh token]]

---

## 4. Create your frontend

You'll need a form that capture's the visitor's message. The user's gmail address is captured by the OAuth2 Client SDK because the user has logged in. That information is POST with payload to an API end point where your backend receives the user's information, and then it sanitizes, and then it emails to you.

Your frontend should request the OAuth2 URL from your backend (e.g., via `/get-auth-url`), then redirect the user to that URL. After the user signs in and grants access, Google redirects them to your site’s `/oauth2callback` route with a `code` query param, for example:
- http://localhost:3000/oauth2callback?code=AUTHORIZATION_CODE
- https://domain.com/oauth2callback?code=AUTHORIZATION_CODE

Your backend (as already implemented in `app.get('/oauth2callback')`) handles this by calling `const { tokens } = await oauth2Client.getToken(code);` to exchange the code for OAuth2 tokens. These tokens are then set as credentials and used to send the email—all in the same route.