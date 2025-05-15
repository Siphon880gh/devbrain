Even if you're not a security engineer, knowing the **basics of encryption and encoding** is essential for every web developer. It directly impacts how you build secure, reliable apps.

#### 🔐 1. **SSH Keys for Git & Servers**

Public/private key pairs allow secure authentication without exposing passwords. They're used for GitHub access and remote server logins—your dev workflow depends on it.

#### 🧂 2. **Password Hashing with Salt**

Never store plain passwords. Instead, use one-way hashing algorithms (like bcrypt) **with salt** to protect user credentials in case your database gets breached.

#### 🧾 3. **JWT Signing & Verifying**

JSON Web Tokens help users stay logged in securely. Tokens are **signed**, not encrypted, so understanding signature verification is critical for trust and integrity.

#### 🆔 4. **MongoDB ObjectIDs & UUIDs**

Mongo uses unique ObjectIDs to prevent collisions. 

In some apps, generating **UUIDs** (e.g., for filenames or API keys) adds a layer of obscurity and security.

#### 🌐 5. **URL Encoding & Parsing**

Encoding isn't encryption, but it's still essential. Misparsed or unvalidated URLs can lead to **XSS**, **open redirects**, or bypassed auth rules. Know how to **encode, decode, and validate** URLs safely