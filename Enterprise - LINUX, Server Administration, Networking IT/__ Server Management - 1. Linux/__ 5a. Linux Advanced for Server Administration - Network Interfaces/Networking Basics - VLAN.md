
**VLAN** stands for **Virtual LAN** — a way to logically segment networks **without needing separate physical switches**.

#### 📌 Key Concepts:

- VLANs allow multiple isolated networks on the same physical interface (like `eth0`).
- Each VLAN is identified by a **VLAN ID** (1–4094).
- Common in enterprise environments to separate traffic (e.g., guest Wi-Fi, VoIP, internal systems).

#### 🔧 Example Interface Naming:

When a VLAN is configured on an interface, it usually appears as:

```
eth0.10   → VLAN 10 on eth0
eth0.20   → VLAN 20 on eth0
```

#### 💡 Use Cases:

- Segmenting traffic for security or performance.
- Isolating departments (e.g., finance vs. dev).
- Managing broadcast domains in large networks.