
### ✅ **Big Picture**

When someone submits a form on your website—whether it’s a contact request or a quote inquiry—you don’t want to rely on checking a dashboard to catch new leads. A more reliable approach is to have those submissions automatically emailed to you.

To make that happen, your backend needs to send emails programmatically. This requires a valid `FROM` address, which usually means sending on behalf of an authorized sender like `you@yourcompany.com`. 

Because the `FROM` is not actually the visitor, your code should capture and incorporate the visitor’s email address in the message body, so you can actually follow up with the visitor. But that means your first email to them cannot contain urls, images, or html, to prevent deliverability penalties. 

Using a custom domain email helps you instantly identify which business the submission came from—especially useful if you run multiple websites. 

In addition, your code should email form submissions from the same email address that receives it. Or, the code should at least have the "FROM" and "TO" email addresses belong to the same domain address. Gmail generally considers this safe behavior, so it helps maintain high deliverability—provided the message content doesn’t appear spammy. 

While there are multiple ways to set up a custom domain email, many choose **Google Workspace** for its added perks: shared Drive access, consistent team-wide email addresses, and a seamless Gmail interface that lets users switch between personal and business inboxes effortlessly.

This guide will show you how to use **Google Workspace** (formerly G Suite) and **Node.js** to send emails via the Gmail API using a **service account**.

---

## 🔐 Requirements

- For this setup, you **must** use a Google Workspace account. If you don't meet that requirement and don't intend to pay for a Google Workspace account, here are your other options:
	- If you want to email on behalf of your personal Gmail account, refer to my guide other guide: [[Send Email as Owner from a Website Form Using Personal Gmail, App Password, and Nodemailer]]
	- If you want the form submissions be emailed on the behalf of the visitors's gmail account, refer to [[Send Email as Visitor from a Website Form Using Personal Gmail, OAuth2, and Nodemailer]]


---

## 🔧 1. Service Account Setup

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

## 🔧 2. NodeJS Setup

### a. 📦 Install Dependencies

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

### b. 💻 Node.js Script

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

### c. 🧪 Test It

Run the script in your Node.js environment. You should receive an email sent _from_ your Google Workspace sender address and _to_ your desired inbox.

---
## 3. Adopt the backend for security reasons and development time constraints

Refer to [[Levels of development shortcuts for web forms]]

---
## 4. Create your frontend

You'll need a form with at least inputs to capture the visitor's email address and message. That information is POST with payload to an API end point where your backend receives the user's information, and then it sanitizes, and then it emails or saves to a folder for later emailing, whichever method you adopted form #3. The visitor's email address input should be programmed to be part of the message body so that you can easily follow up with them.