
### 🔑 **Passkey**

- **What it is**: A modern replacement for passwords, based on **FIDO2/WebAuthn**.
- **How it works**: Uses **public-private key pairs**. The private key stays on your device; the public key goes to the website.
- **Not limited to one device**: Passkeys can **sync across devices** (e.g., iCloud Keychain on Apple, or Google Password Manager on Android).
- **User experience**: Log in with Face ID, fingerprint, or device PIN — no passwords.

---

### 🔐 **Authenticator App**

- **What it is**: A **TOTP-based** (time-based one-time password) 2FA method, often using apps like Google Authenticator or Authy.
- **Per-device**: Usually tied to **a specific device** — if you lose the device, you lose the codes.
- **Recovery**: Some apps (like **Authy**) allow **cloud backup** and recovery; others (like Google Authenticator) don't unless you export and save codes.
- **Backup codes**: Most services provide **one-time backup codes** when setting up TOTP — these are crucial to save securely as they're your fallback if you lose device access or the app stops working.
- **Use**: Enter a 6-digit code after logging in with a password.

---

### Summary

|Feature|Passkey|Authenticator App|
|---|---|---|
|Based on|Public-key cryptography (FIDO)|Time-based one-time passwords (TOTP)|
|Device limitation|Syncs across devices|Tied to specific device (unless backed up)|
|Password required?|No|Yes (used as 2FA)|
|Recovery|Via cloud sync (Apple/Google)|Only if backup/export supported|
