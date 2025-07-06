
**Applies to:** Hostinger VPS KVM2 • Ubuntu 24.04.2 LTS • CloudPanel

---

## 🧩 Overview

While Hostinger’s ordering process and setup wizard are mostly straightforward, **manual terminal work is still required** afterward — especially for things like FTP. The wizard can give the false impression that everything is fully configured.

---

## ⚠️ Important Warning About the Setup Wizard

**Do NOT add your SSH key during the Hostinger wizard.**  
Doing so may cause issues that make FTP setup more difficult.  
👉 **Wait to add your SSH key until after** you have confirmed FTP is working manually via terminal.

---

## ✅ Done with the Wizard?


Copy your credentials/passwords to a safe place.

Now perform these two checks:

1. **SSH Login** using root password  
    (You can add passwordless SSH key authentication later.)
    
2. **SFTP/FTP Access** using FileZilla
    

---

## 🔒 Tip Before Terminal Access

When accessing your VPS via root terminal, it's strongly recommended to go **behind a VPN**.

Why?  
Hostinger uses Cloudflare by default, which will **ban your IP for 1 hour** after repeated failed login attempts — and there's **no way to unblock this from the Hostinger interface.**

---

## 🧪 Test: SSH Login

Use either:

- `"root"` (we’ll disable this later for better security), or
    
- The **site user** created via CloudPanel
    

---

## 🧪 Test: SFTP/FTP Login

You **do not** need to create a new SFTP/FTP user in CloudPanel.  
You can use:
- `"root"`
- Or the **existing site user**

👉 If login fails (which is likely on fresh installs), you'll need to manually fix FTP/SFTP.  
**Refer to the FTP setup instructions** ([[_ Hostinger VPS KVM2 Debian 22 - 2. FTP Setup]]), complete the steps, and then return here once FileZilla works.

---

## ✅ Once SSH and SFTP/FTP Logins Are Working

Now you can safely **add your SSH public key** from your computer.

![[Pasted image 20250706131250.png]]

- This will enable **SSH passwordless login**
    
- Makes it easier to automate terminal access with an alias from your local machine
    