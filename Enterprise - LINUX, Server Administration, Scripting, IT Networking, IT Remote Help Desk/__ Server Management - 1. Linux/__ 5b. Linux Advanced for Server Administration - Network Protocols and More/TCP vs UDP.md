### ✅ **TCP and UDP Are Network Protocols**

- They're part of the **Transport Layer** in the [OSI model](https://en.wikipedia.org/wiki/OSI_model) or **Layer 4**.
- They define **how data is transmitted** between devices.
- They run **on top of network interfaces** (like `eth0`, `wlan0`, etc.), but **they are not interfaces themselves**.

A quick comparison
- **TCP** is for reliable, ordered communication (used by web, SSH, MongoDB, etc.)
- **UDP** is for fast, unreliable communication (used by things like video calls, DNS)

---

### 🔒 Why It Matters

Most services — including **MongoDB**, **SSH**, **HTTP**, etc. — use **TCP** to ensure reliable delivery of data. By specifying the protocol in UFW, you can fine-tune what traffic is allowed.

---

### 📌 Example: Enabling MongoDB Port with TCP Only

MongoDB listens on **TCP port 27017**. To allow access:
```
sudo ufw allow 27017/tcp
```

This tells UFW:

> “Only allow traffic on port 27017 **if** it’s using the TCP protocol.”

🛡️ **Best practice:** Always specify `/tcp` or `/udp` instead of using the port alone (like `27017`) — this avoids accidentally opening ports to protocols you don’t use.