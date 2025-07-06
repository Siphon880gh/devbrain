You may look into a client like Filezilla and see that Filezilla connects in passive mode:
```
Response: 200 Type set to I
Command:  PASV
Response: 227 Entering Passive Mode (11,222,33,444,210,125)
```

**Passive FTP** is a mode of FTP (File Transfer Protocol) that solves problems caused by firewalls and NAT (Network Address Translation) — especially on the **client side**. Filezilla defaults to using **Passive FTP**.

---

### 🚧 Problem with Active FTP:

In **active mode**, the client tells the server:

> "Hey, connect to me on port XYZ."

But if the client is behind a firewall or NAT (like most home users or web-based tools), the server can't reach them.

---

### ✅ Passive FTP to the rescue:

In **passive mode**:

1. The client connects to the server on port **21** (control connection).
2. The server replies with a port number (e.g., port **53765**).
3. The **client** then initiates a **second connection** back to the server on that port for data transfer (e.g., listing files or downloading).

So, **the client always initiates connections** — this works better with firewalls and NAT.

---

### 📦 Summary Table

|Mode|Who opens data connection?|Good for NAT/firewall?|
|---|---|---|
|**Active**|Server → Client|❌ Often blocked|
|**Passive**|Client → Server|✅ More reliable|

---

### 🔐 Why servers need PassivePorts config

Because FTP servers choose **random ports** for passive mode, they must:
- Be told which port range to use (e.g., `50000–51000`)
- Have that port range open in the firewall

Without this, passive mode fails during directory listings or file transfers.

---

### Why important to know

When setting up a new SFTP/FTP in Filezilla, it may fail due to the server not having passive mode on and/or the ports for passive mode enabled. Debian 22 LTS by default disables both. In that case, refer to [[_ Hostinger VPS KVM2 Debian 22 - 2. FTP Setup]]