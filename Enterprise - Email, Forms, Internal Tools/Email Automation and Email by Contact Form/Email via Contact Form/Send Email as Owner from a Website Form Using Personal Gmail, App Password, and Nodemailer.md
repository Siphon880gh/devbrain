### ✅ **Big Picture**

When someone submits a form on your website—whether it’s a contact request or a quote inquiry—you don’t want to rely on checking a dashboard to catch new leads. A more reliable approach is to have those submissions automatically emailed to you.

To make that happen, your backend needs to send emails programmatically. This requires a valid `FROM` address, which usually means sending on behalf of an authorized sender like `your_business@gmail.com`. 

Because the `FROM` is not actually the visitor, your code should capture and incorporate the visitor’s email address in the message body, so you can actually follow up with the visitor. But that means your first email to them cannot contain urls, images, or html, to prevent deliverability penalties.

You will be using a personal gmail email address. If you run multiple websites that you intend to have web forms, you may want to consider signing up for gmail accounts named after your business, eg. `yourbusinessname@gmail.com` so it helps you instantly identify which business the submission came from. 
- As of 2021, gmail requires a phone number to sign up unless you're signing up on a phone's google app. Expectations are that they will eventually require all gmail signups to be tied to a unique phone number. The conflict of interest here is that gmail wants small businesses to pay for Google Workspace.
- Instead of creating a new gmail address, you could program the subject to have the business or website in it.

In addition, your code should email form submissions from the same email address that receives it. Gmail generally considers this safe behavior, so it helps maintain high deliverability—provided the message content doesn’t appear spammy. 

This guide will show you how to use a **personal gmail** and **Node.js** to send emails via the Gmail App Password.

---
## 🔐 Requirements

- For this setup, you **must** have generated an App Password for your personal gmail address. If you haven't, first refer to [[1. Create Gmail app password]].

---

### 1. CLI Emailer Using Owner's Gmail

We’ve created a CLI-based email sender that uses the owner’s Gmail address. You can adapt it into a full stack solution with a contact form. The approach would be to wrap the CLI in a backend endpoint. See:  [[2. Gmail CLI with NodeMailer and App Password]]

You can test the API endpoint with tools like Postman, Insomniac, or a cURL call in the terminal.

✋ Once that's working, continue on the rest of this guide to complete the setup.

---

### 2. Adopt the backend for security reasons and development time constraints

Refer to [[Levels of development shortcuts for web forms]]

---
### 3. Create your frontend

You'll need a form with at least inputs to capture the visitor's email address and message. That information is POST with payload to an API end point where your backend receives the user's information, and then it sanitizes, and then it emails or saves to a folder for later emailing, whichever method you adopted form #2. The visitor's email address input should be programmed to be part of the message body so that you can easily follow up with them.