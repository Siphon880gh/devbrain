Think of your app like a building with multiple checkpoints. Each layer filters or controls something different.

For these coder notes, we have our terms that are easier to recognize than the official terms. Below lists the levels with both terminologies.

---

## 1. 🌐 Edge Network Layer

**(Our term: “Proxy layer”)**

- Example: Cloudflare
    
- Official terms:
    
    - Reverse Proxy
        
    - CDN (Content Delivery Network)
        
    - WAF (Web Application Firewall)
        
    - Edge Network
        

**What it does:**

- Sits _in front_ of your server
    
- Filters bots, attacks, bad countries/IPs
    
- Handles SSL, caching, rate limiting
    

👉 Think:  
**“Traffic must pass Cloudflare before it even sees my server”**

---

## 2. 🖥️ Network / OS Layer

**(Our term: “Linux level”)**

- Example: `ufw`, `iptables`, `nftables`
    

**Official term:**

- Host-based firewall
    
- Network layer (L3/L4)
    

**What it does:**

- Allows/blocks raw IP + port access
    
- Runs inside your VPS kernel
    

👉 Think:  
**“Even if traffic reaches my server, can it connect at all?”**

---

## 3. 🧰 Hosting / Control Panel Layer

**(Our term: “Web host level”)**

- Example: Hostinger hPanel, cPanel, CloudPanel
    

**Official term:**

- Control panel / hosting abstraction layer
    

**What it does:**

- UI for managing firewall rules, domains, SSL
    
- Sometimes includes basic WAF or IP blocking
    

👉 Think:  
**“A dashboard that controls server behavior without CLI”**

---

## 4. 🌍 Web Server Layer

**(Our term but not documented yet: “Web Server level”)**

- Example: Nginx, Apache
    

**Official term:**

- Web server / reverse proxy (L7)
    

**What it does:**

- Routes requests to apps (`proxy_pass`)
    
- Handles domains, SSL termination, headers
    
- Can block requests (rate limits, rules)
    

👉 Think:  
**“Where domains and ports get mapped to apps”**

---

## 5. ⚙️ Supply Chain Etc Layer

**(Our term: “Website or Application Stacks level")**

- Example: NextJS, etc

**What it does:**

- Vulnerable dependencies needing updates now

---

## 6. ⚙️ Application Layer

**(Our term: “Website or Application Code level")**

- Example: Programming code in Flask, PHP, Node.js
    

**Official term:**

- Application layer (L7)
    

**What it does:**

- Business logic (API, auth, DB queries)
    
- Validates input, handles sessions, JWTs
    

👉 Think:  
**“The actual brain of your app”**

---

## 7.  🔐 Application Configuration Layer

**(Our term not documented yet: “Application Config and Secrets Level”)**

- Example: `.env`, secrets, config files
    

**Official terms:**

- Environment configuration
    
- Secrets management
    

**What it does:**

- Stores credentials (DB passwords, API keys)
    
- Controls runtime behavior (dev vs prod)
    

👉 Think:  
**“Hidden switches and passwords your app uses”**