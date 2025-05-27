
### ✅ **Goal**

When a user submits a form on your website, you'd like to receive an email with their submission details. However, sending emails programmatically requires a valid `FROM` address—so your backend must send the email on behalf of an authorized sender, such as `employee@yourcompany.com`.

This guide walks you through using **Google Workspace** (formerly G Suite) and **Node.js** to send emails via the Gmail API using a **service account**.

---

## 🔐 Why a Google Workspace Email?

Google Workspace allows organizations to use custom domain email addresses (e.g., `employee@yourcompany.com`) rather than personal Gmail accounts (e.g., `example@gmail.com`).

If your website form collects user submissions, you’ll likely send the data from your own domain email—either your own or an employee’s—to keep everything consistent and manageable. Typically, you’ll send the form results back to an address on your domain, which helps maintain deliverability.

The visitor’s email address will usually be included in the message body so you can follow up. However, be aware that including links or images in this first message—especially when it's your initial outreach—can negatively impact your deliverability score. You can have the contact form deliver on the behalf of the user's gmail account - for that, refer to [[Send Email as Visitor from a Website Form Using Personal Gmail, OAuth2, and Nodemailer]]

For this setup, you **must** use a Google Workspace account. If you're using a personal Gmail account, refer to a different guide that covers OAuth2-based Gmail access.

> ✅ You can send the email to any address. The `TO` address does **not** need to be on Google Workspace.

---

## 🔧 Setup Overview

### 1. **Create a Google Cloud Project**

- Go to the [Google Cloud Console](https://console.cloud.google.com/).
- Create a new project.
- Enable the **Gmail API** for your project.

### 2. **Create a Service Account**

- In your project, go to **IAM & Admin > Service Accounts**.
- Create a new service account.
- Enable **Domain-Wide Delegation**.
- Download the JSON credentials file (this is your `SERVICE-ACCOUNT.json`).

### 3. **Authorize the Service Account**

- You must be a Google Workspace **Admin**.
- Go to [Admin console > Security > API Controls > Manage Domain-Wide Delegation](https://admin.google.com/).
- Add a new API client using:
    - **Client ID**: Found in your `SERVICE-ACCOUNT.json` under `client_id`
    - **OAuth Scopes**: `https://mail.google.com`


---

## 🛡 Security Tips

- **Store your service account file securely.** Do not hardcode the path.
    
- Use environment variables to reference the path (e.g., `process.env.GMAIL_SERVICE_ACCOUNT_PATH`).

- Run this script only from the backend—never expose credentials client-side.

---

## 📦 Dependencies

Install the required packages via `npm`:

```json
"dependencies": {
  "express": "^4.19.2",
  "google-auth-library": "^9.9.0",
  "googleapis": "^136.0.0",
  "nodemailer": "^6.9.13"
}
```

---

## 🧠 Node.js Script

Here’s a complete example of the Node.js script. Replace the following values in the code:

- `SERVICE-ACCOUNT.json` → your service account file
- `employee@yourcompany.com` → the sender's Workspace email (used 3x)
- `you@yourcompany.com` → the recipient's email

```js
const nodemailer = require('nodemailer');
const { google } = require('googleapis');
const key = require('./SERVICE-ACCOUNT.json'); // path to your downloaded service account file

const scopes = ['https://mail.google.com'];

const jwtClient = new google.auth.JWT(
  key.client_email,
  null,
  key.private_key,
  scopes,
  'employee@yourcompany.com' // the user you're sending on behalf of
);

jwtClient.authorize((err, tokens) => {
  if (err) {
    console.error('Authorization error', err);
    return;
  }

  console.log('✅ Successfully authorized!');

  const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
      type: 'OAuth2',
      user: 'employee@yourcompany.com',
      accessToken: tokens.access_token,
      expires: tokens.expiry_date,
      clientId: null,       // Not needed when using service account
      clientSecret: null,   // Not needed when using service account
      refreshToken: null    // Not needed when using service account
    }
  });

  const mailOptions = {
    from: 'Employee <employee@yourcompany.com>',
    to: 'you@yourcompany.com',
    subject: 'Hello from your form!',
    text: 'A user submitted your form.',
    html: '<b>A user submitted your form.</b>'
  };

  transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
      return console.error('✉️ Send error:', error);
    }
    console.log('📨 Message sent: %s', info.messageId);
  });
});
```


---

## 🧪 Test It

Run the script in your Node.js environment. You should receive an email sent _from_ your Google Workspace sender address and _to_ your desired inbox.