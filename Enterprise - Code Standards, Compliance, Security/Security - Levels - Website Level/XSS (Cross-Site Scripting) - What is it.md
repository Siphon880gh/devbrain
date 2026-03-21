**XSS (Cross-Site Scripting)** is a type of security vulnerability where an attacker injects malicious JavaScript into a trusted website — which then runs in another user’s browser.

---

### 🧨 How XSS works:

1. The attacker finds a way to inject code (e.g., into a comment box, form field, or URL).
    
2. A user visits the vulnerable page.
    
3. The attacker’s script runs **inside the user’s browser** — with the same permissions as the legitimate site.
    

---

### 🎯 What attackers can do with XSS:

- Steal cookies, tokens, or session info
    
- Make requests on behalf of the user (like CSRF, but more powerful)
    
- Modify the page content (e.g., fake login forms)
    
- Log keystrokes or redirect users
    

---

### 🛡️ Types of XSS:

|Type|Description|Example|
|---|---|---|
|**Stored XSS**|Malicious script is saved on the server (e.g., in a comment or database)|Viewing a post triggers the attack|
|**Reflected XSS**|Script is injected via URL/query and reflected in the response|Clicking a malicious link triggers the script|
|**DOM-based XSS**|Script manipulates the page using insecure JS (e.g., `document.location`)|Happens entirely on the frontend|

---

### ✅ How to prevent XSS:

- **Escape all user input** before rendering it in HTML
    
- Use frameworks that auto-sanitize (e.g., React, Angular)
    
- Set HTTP headers:
    
    - `Content-Security-Policy`
        
    - `X-XSS-Protection` (legacy)
        
- Avoid `innerHTML`, `document.write`, and other risky DOM APIs
    

---

### TL;DR:

**XSS = attacker runs JS in your users’ browser via your site.**

It's dangerous because:

- It can **steal tokens** stored in memory
    
- It can **bypass CSRF defenses**
    
- It makes **frontend-only token auth** vulnerable if not paired with proper input sanitization and secure coding practices