## Add Vercel's v0 model to Cursor

Requirement: Paid Vercel

These instructions are from https://vercel.com/docs/v0/cursor. Note their instructions are outdated as of 6/2025, saying that you can use their v0 model for free. That is no longer the case.

You can force connect the ChatGPT connection into v0 server.

Get your Vercel v0 API key at https://v0.dev/chat/settings/keys

Notice you get free $5 credits/month, however you still have to be on a paid plan.

At Cursor settings at the top right:
![[Pasted image 20250609014558.png]]

Navigate to Models tab:
![[Pasted image 20250609014608.png]]


Scroll down pass the models and expand API Keys section:
![[Pasted image 20250609014617.png]]

Enable the OpenAI API Key

Then enter these details:
- Your API Key you wrote down from an earlier step
- The OpenAI Base URL set to:
```
https://api.v0.dev/v1
```

![[Pasted image 20250609014641.png]]

---

If you are not on a paid Vercel plan, you will get this error screen:

![[Pasted image 20250609014656.png]]

Specifically:
```
(status code 403)  
{"success":false,"error":"Premium or Team plan required to access the v0 API: https://v0.dev/chat/settings/billing"}
```