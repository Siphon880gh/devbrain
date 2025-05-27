### 🎯 Purpose

When a user submits a form on your website, you may want their email address too. If they authenticate using Google OAuth2, you've captured their email address, AND they can email you from their email address. They don't even have to enter their gmail address because they've "logged in".

This streamlines you replying back to them, and also allows you to email back to them with links or images without damaging your email domain's deliverability score. You will literally see an email from the visitor's gmail address.

---

### ✅ Requirements

- The recipient (`TO`) email can be any address (Gmail or not). Usually you set it to your business email because you're having the visitor's gmail address email you.

---

### ⚙️ Google Cloud Setup

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

### 🔒 Security Best Practices

- Store your `.json` credentials securely.
- Use environment variables to store the file path and sensitive details.
- Run the code on the **backend only**—never expose credentials on the frontend.

---

### 📦 Required Packages

Add these dependencies to your `package.json`:

```json
"dependencies": {
  "express": "^4.19.2",
  "google-auth-library": "^9.9.0",
  "googleapis": "^136.0.0",
  "nodemailer": "^6.9.13"
}
```

---

### 🧪 Node.js Script

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


---

### 🧪 How to Use (First Step)

This example runs without a frontend. You visit the printed OAuth2 URL directly in your browser to trigger the authentication flow. It’s a quick way to test the script and confirm email sending works via your backend.

---

### 🚀 Add Frontend Integration (Second Step)

In production, your frontend should request the OAuth2 URL from your backend (e.g., via `/get-auth-url`), then redirect the user to that URL. After the user signs in and grants access, Google redirects them to your site’s `/oauth2callback` route with a `code` query param, for example:
- http://localhost:3000/oauth2callback?code=AUTHORIZATION_CODE
- https://domain.com/oauth2callback?code=AUTHORIZATION_CODE

Your backend (as already implemented in `app.get('/oauth2callback')`) handles this by calling `const { tokens } = await oauth2Client.getToken(code);` to exchange the code for OAuth2 tokens. These tokens are then set as credentials and used to send the email—all in the same route.

---

### 🔐 Manage Access

To review or revoke app permissions:  
👉 [https://myaccount.google.com/security-checkup](https://myaccount.google.com/security-checkup)  
Look for the OAuth app name you created.