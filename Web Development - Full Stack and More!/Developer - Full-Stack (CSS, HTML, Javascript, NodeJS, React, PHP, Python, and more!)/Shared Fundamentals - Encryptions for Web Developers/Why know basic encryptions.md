Even if you're not a dedicated security engineer, understanding the **basics of encryption and encoding** is crucial for any web developer. These encryption practices are already built into the way modern apps, databases, and servers operate—so as a developer, it’s essential to understand them.

> For other security topics—like protection against cross-site scripting (XSS) and related concerns—refer to the **Enterprise - Code Standards, Compliance, Security** folder.

#### 🔐 1. **SSH Keys for Git & Servers**

Public/private key pairs allow secure authentication without exposing passwords. They're used for GitHub access and remote server logins—your dev workflow depends on it.

#### 🧂 2. **Password Hashing with Salt**

Never store plain passwords. Instead, use one-way hashing algorithms (like bcrypt) **with salt** to protect user credentials in case your database gets breached.

#### 🧾 3. **JWT Signing & Verifying**

JSON Web Tokens help users stay logged in securely. Tokens are **signed**, not encrypted, so understanding signature verification is critical for trust and integrity.

#### 🆔 4. **MongoDB ObjectIDs & UUIDs**

Mongo uses unique ObjectIDs to prevent collisions. 

In some apps, generating **UUIDs** (e.g., for filenames or API keys) adds a layer of obscurity and security.
#### 📜 5. **TLS/SSL Certificates for HTTPS**

TLS (formerly SSL) uses encryption to secure data in transit between your server and the user’s browser. It relies on **public/private key pairs** to establish trust and encrypt traffic. As a developer, you should understand:

- How to configure HTTPS in your app or server.
    
- What certificate authorities (CAs) do.
    
- How to handle expired or self-signed certs.
    
- That modern browsers require HTTPS for many features (e.g., service workers, geolocation).
    

Even if a sysadmin sets it up, knowing the basics helps you debug issues and enforce secure defaults (like HSTS or redirecting HTTP to HTTPS).
#### 🌐 6. **URL Encoding & Parsing**

I’ve included **encoding** here for organizational reasons—it’s conceptually similar to encryption in that it transforms data into a less human-readable format. But more importantly, encoding is also **crucial for web security**. Mishandled URLs can lead to serious vulnerabilities like **XSS**, **open redirects**, or **authentication bypasses**.