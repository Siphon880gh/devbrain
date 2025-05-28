
**Nodemailer** is a module for **Node.js** that allows you to send emails easily from your server-side JavaScript code.

For full working code that emails you from a script or from a backend server:
 [[2. Gmail CLI with NodeMailer and App Password]]
 
---

### 🔍  Nodemailer with `service: "gmail"`

When you specify `service: "gmail"` in `nodemailer.createTransport()`, you're using a built-in shortcut that tells Nodemailer to automatically configure the correct SMTP settings for Gmail.

Your code (For example, [[2. Gmail CLI with NodeMailer and App Password]]):
```
{
  service: "gmail"
}
```

Behind the scenes, Nodemailer maps `"gmail"` to:

```js
{
  host: "smtp.gmail.com",
  port: 465, // or 587
  secure: true // true for port 465, false for 587
}
```

So instead of manually specifying the `host`, `port`, and `secure` options, you're letting Nodemailer refer to Gmail's official SMTP server configuration.

---

### 🌐 Under the hood: SMTP at Machine

- When you send an email using this transport, your **local machine (Mac/Linux)** connects to Gmail’s SMTP server over the internet.
- The connection is made using **TCP on port 465 (SSL) or 587 (STARTTLS)**, depending on how Gmail's server expects it.
- Most systems (MacOS, Linux, etc.) allow outbound connections on these ports by default, so **no special firewall or port opening is needed** unless you're on a highly restricted network.    
- Gmail requires **authentication via your email and app password**—not your normal Gmail password—for CLI or script-based sending.
