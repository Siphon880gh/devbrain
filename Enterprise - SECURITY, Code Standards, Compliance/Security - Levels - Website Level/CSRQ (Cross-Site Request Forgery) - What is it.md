**Cross-Site Request Forgery (CSRF)** is an attack where a malicious website tricks a user's browser into making an unwanted request to another site where the user is already authenticated.

### 🧨 How it works:

1. **User logs into Site A** (e.g., a banking app) — their session or auth token (like a cookie) is stored in the browser.
    
2. **User visits malicious Site B** while still logged in to Site A.
    
3. Site B secretly sends a request (e.g., a POST or GET) to Site A using the user's browser — including the stored cookie.
    
4. Site A sees a valid session and processes the request **as if the user made it**.
    

### 🎯 Real-world example:

A hidden `<img>` tag or JavaScript on Site B might trigger:

```html
<img src="https://bank.com/transfer?to=hacker&amount=1000">
```

If Site A doesn’t check the origin or require a CSRF token, the transfer goes through.

---

### ✅ Prevention:

- Use **SameSite cookies** (`SameSite=Strict` or `Lax`)
    
- Require **CSRF tokens** on state-changing requests
    
- Validate **Origin** or **Referer** headers
    

In short: CSRF exploits _trust in the user's browser_.