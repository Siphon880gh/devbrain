

You can use a webhost and their email services which usually means you are charged two different plans.

You can use paid email APIs. They have something to offer because manually setting up form that emails is a difficult given that online help and ChatGPT help is outdated.

You can still leverage free gmail however it’s a bit tricky. Your options are:
As a service: Mailgun, Sendgrid, cloudmailin.com
Gmail API https://developers.google.com/gmail/api/guides/sending#python
NodeMailer npm install nodemailer 

NodeMailer works well, however its errors are ambiguous, often about wrong password or syntax for many errors.

---


Online help and ChatGPT help is outdated. as of 5/4/24

ChatGPT gives outdated code.

Youtube tutorials from a few years prior, on a form sending completed forms to your email inbox, is likely outdated.

NodeMailer’s documentation not too helpful and is out of date as of 5/4/2024 saying to enable “less secure apps” when in fact Google has removed that since 5/30/22.
https://www.nodemailer.com/usage/using-gmail/

Online help says the scope is “https://www.googleapis.com/auth/gmail.send“ and isn’t until much search that for nodemailer to work, it has to be all scopes “https://mail.google.com”
https://stackoverflow.com/questions/51555214/gmail-api-invalid-username-or-password-when-using-oauth2-in-nodemailer

Online help says you can authorize directly with plain username and password in the code and have less secured app enabled. This is obsoleted because “less secured app” option has been removed by Google/Gmail as of 5/30/22.

---

My other two tutorials are on using standard Gmail accounts or Workspace Gmail Accounts as accounts to email form details to your target email. 