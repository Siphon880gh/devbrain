The **OSI model** is a conceptual framework developed by the **International Organization for Standardization (ISO)** to standardize how different computer systems communicate over a network.
- It divides networking into **7 layers**, each with its own role.    
- It helps developers and engineers design interoperable protocols and troubleshoot networks logically.
  
## 🧱 OSI Model – 7 Layers (Top to Bottom)

| Layer | Name             | Examples / Purpose                       |
| ----- | ---------------- | ---------------------------------------- |
| 7     | **Application**  | HTTP, FTP, SMTP — User-facing protocols  |
| 6     | **Presentation** | SSL/TLS, data encryption, compression    |
| 5     | **Session**      | Session control, dialogs, connections    |
| 4     | **Transport**    | **TCP, UDP** — reliable or fast delivery |
| 3     | **Network**      | IP, ICMP — routing & addressing          |
| 2     | **Data Link**    | Ethernet, MAC addresses, ARP             |
| 1     | **Physical**     | Cables, Wi-Fi, electrical signals        |

---

### 📍 Eg. Layer 4 = Transport Layer

- **Main protocols:**
    - **TCP** (Transmission Control Protocol): reliable, ordered
    - **UDP** (User Datagram Protocol): fast, no guarantees
- **Job:** Break data into segments, manage delivery, retransmit if needed (TCP)


---

### 🧠 Mnemonic to Remember the 7 Layers (Top → Bottom):

**"All People Seem To Need Data Processing"**

|Layer|Name|
|---|---|
|7|Application|
|6|Presentation|
|5|Session|
|4|Transport|
|3|Network|
|2|Data Link|
|1|Physical|
