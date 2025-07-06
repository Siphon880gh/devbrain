
**Applies to:** Hostinger VPS KVM2 • Ubuntu 24.04.2 LTS • CloudPanel

Setting up FTP users on a fresh server can be tricky—especially if you're not familiar with the environment. Critical ports like **21 (FTP)** and **22 (SFTP)** may be **disabled by default**. Additionally, FileZilla defaults to **passive FTP mode**, which requires the server to have passive mode explicitly enabled and a port range opened in the firewall. On OS like **Debian**, all of that is **disabled** out of the box.

To test if FileZilla can connect via FTP or SFTP, you need valid user accounts. **You do NOT need to create new users manually** in CloudPanel—users like `"root"` or the **CloudPanel site-specific user** are automatically set up with FTP/SFTP access.

Where's the Cloudpanel site-specific user?
> CloudPanel -> Settings tab -> Site User Settings
> ![[Pasted image 20250706132614.png]]
>

---
## FileZilla Keeps Saying "Incorrect Password"?

There are several possible causes. Start from the top and work your way down:

### 1. Check Login Settings

- **Protocol**: SFTP
    
- **Host**: IP address of your server
    
- **Port**: Optional (FileZilla defaults to 22 for SFTP, 21 for FTP)
    
- **Logon Type**: Normal
    
- **Username**: Either `root` or the CloudPanel-created site user
    
- **Password**: Must match the selected username
    

### 2. FTP/SFTP Ports Blocked by Default

Even with the correct credentials, FileZilla may show an "Incorrect password" error if **ports 21 or 22 are blocked** by default. This is actually a **security feature**—it misleads brute-force attackers into thinking their credentials are wrong, when the service isn’t even reachable yet.

### 3. Denied Keys?

If you added an SSH key during VPS setup (via the Hostinger dropdown), it may block password-based logins. You can fix this by removing all SSH keys from your Hostinger dashboard.

---

### ✅ CHECKPOINT – Still Can’t Log In?

If login still fails, it's time to use the terminal. We recommend using a VPN for added safety—repeated failed login attempts can get your IP banned by Hostinger’s **Cloudflare-based protection**, and there's no way to manually unblock it from the Hostinger interface.

---

## Open Ports 21 and 22 in UFW

Debian 24.04 uses **UFW** (Uncomplicated Firewall) as a user-friendly wrapper for iptables. Once logged in to the terminal as root:

```bash
sudo ufw allow 21/tcp
sudo ufw allow 22/tcp
sudo ufw reload
```

Verify the rules were added:

```bash
sudo ufw status
```

> **Note:** ChatGPT and many guides might only give you one of these commands. You **need both** to cover FTP and SFTP.

Your FileZilla login should now succeed. But you may still get **disconnected immediately after logging in** due to **passive mode not being enabled**, which brings us to the next section.

---

## Passive Mode: Logged In but Kicked Out?

If FileZilla logs in but disconnects while trying to retrieve the directory listing, and shows this error:

```
Network error: Connection timed out / ENETUNREACH – Network unreachable
```

Then the issue is most likely **passive mode is not enabled or the ports are blocked**.

### What’s Going On?

FileZilla sends the following sequence in its log panel:

```
Response: 200 Type set to I
Command:  PASV
Response: 227 Entering Passive Mode (11,222,33,444,210,125)
```

This response tells FileZilla to connect to the **passive mode data port** at:

- **IP:** 11.222.33.444
- **Port:** (**210** * 256) + **125** = **53765**
    

If your server isn’t configured to allow this connection (no passive mode + closed firewall port), it fails.

---

## Enable Passive Mode in ProFTPD (Default on Debian)

1. **Check Your FTP Service:**
    

```bash
ps aux | grep ftp
```

Look for one of these:

- `proftpd` (config at `/etc/proftpd/proftpd.conf`)
    
- `vsftpd` (config at `/etc/vsftpd.conf`)
    
- `pure-ftpd` (config spread across `/etc/pure-ftpd/conf/`)
    

2. **Edit ProFTPD Config:**
    

```bash
sudo vi /etc/proftpd/proftpd.conf
```

Add or modify near the end:

```apacheconf
<Global>
  PassivePorts 50000 51000
</Global>
```

3. **Restart ProFTPD:**
    

```bash
sudo systemctl restart proftpd
```

4. **Open Passive Port Range in UFW:**
    

```bash
sudo ufw allow 50000:51000/tcp
sudo ufw reload
```

If you still have issues and logs show ports outside that range, widen the passive range:

```bash
sudo ufw allow 49152:65534/tcp
```

**CHECKPOINT -** If this is your first time ever with Filezilla, Filezilla might not be setup for Passive Port. Follow instructions here:
  
Article:

[https://www.hostinger.com/tutorials/how-to-fix-econnrefused-connection-refused-by-server-in-filezilla](https://www.hostinger.com/tutorials/how-to-fix-econnrefused-connection-refused-by-server-in-filezilla)  

Specifically:

1.  [Connect to FileZilla FTP client](https://www.hostinger.com/tutorials/ftp/filezilla-ftp-configuration) and head to **Edit ->** **Network Configuration Wizard**.
2. Press **Next** to proceed once a **Firewall and router configuration wizard** window pop out.
3. Choose **Passive (recommended)** as the **Default transfer mode**, and put a check on the **Allow fallback to another transfer mode on failure** option.
4. Select **Use the server’s external IP address instead**.
5. Choose the **Get the external IP address from the following URL**. If the input field is blank, enter the default value, which is **[http://ip.filezilla-project.org/ip.php](http://ip.filezilla-project.org/ip.php),** and proceed.
6. Don’t make any changes to the port range configuration and select **Ask operating system for a port**.


Filezilla SFTP/FTP should work now!