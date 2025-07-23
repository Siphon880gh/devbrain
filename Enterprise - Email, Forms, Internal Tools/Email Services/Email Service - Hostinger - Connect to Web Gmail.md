Requirements:
- You have a hostinger email
- Your hostinger email already connected to your domain through MX Records

You can read here or follow the rest of the tutorial:
[https://support.hostinger.com/en/articles/3220927-how-to-set-up-hostinger-email-on-the-web-version-of-gmail](https://support.hostinger.com/en/articles/3220927-how-to-set-up-hostinger-email-on-the-web-version-of-gmail)

---

## Beginning

Gather the SMPT(Outgoing) and POP3(Incoming) URL and port details from the official docs:![[Pasted image 20250723075025.png]]

At the top right of Gmail web version, click Settings → See all settings
![[Pasted image 20250723075034.png]]

Then go to "Accounts and Imports" tab
![[Pasted image 20250723075045.png]]

---

Desired setup:
![[Pasted image 20250723075058.png]]

## SMPT/Send Setup

Send mail as → Add another email address
1...
![[Pasted image 20250723075116.png]]

**? “Treat as an alias” checkmark ?**
Use this if the added email address is yours (e.g. your own secondary address or alias like sales@, hello@, or different domain versions).

**Result:**
- Gmail treats both email addresses as the same identity.
- **Emails sent from either address show up in your Sent folder**.
- Replies to your message **go to your Gmail inbox**.

2.... (Note dont even try, hackers... that's not my password length)
![[Pasted image 20250723075154.png]]

3....
![[Pasted image 20250723075206.png]]

4...
Then make sure to click the confirm link sent to your inbox. Note the confirm link isn't at your gmail web but at your Hostinger mailbox, because otherwise that defeats the purpose of preventing harassment:
![[Pasted image 20250723075224.png]]

That link follows back to gmail web with this confirmation message
- Make sure to click the button "Confirm"
![[Pasted image 20250723075236.png]]

Again - Make sure to click Confirm! If you link expired, you can go back to the Settings for "verify" link where you have the option to send a fresh link.
![[Pasted image 20250723075306.png]]

  

SMPT/Send setup should work!

  

But let's test you can switch to your email address. Compose a new message, then click From dropdown to see if your new email address is a choice!
![[Pasted image 20250723075408.png]]

Send an email to one of your personal emails and see if you get it!

---

## Pop3/Incoming Setup

Back at Gmail settings:

Check mail from other accounts → Add a mail account

1...
![[Pasted image 20250723075444.png]]

2...
![[Pasted image 20250723075455.png]]

^ Curious what's Gmailify? Gmailify is a feature that allows users to integrate their non-Gmail email accounts (like Yahoo, AOL, or Outlook) with their Gmail account, providing access to Gmail features like spam protection, inbox organization, etc.

3... (Note dont even try, hackers... that's not my password length)
![[Pasted image 20250723075516.png]]

Your settings should look like:
![[Pasted image 20250723075058.png]]


Now you should test. Send from a personal email to your custom email. See if you get it at both:

- Hostinger inbox
- Gmail web inbox


POP3/Incoming setup is done.

---

At this point:
- Both SMPT(Outgoing/Send Email as) and Pop3 (Incoming) are done