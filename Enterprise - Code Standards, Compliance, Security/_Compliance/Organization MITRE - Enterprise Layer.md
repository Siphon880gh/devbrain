
MITRE ATT&K framework starts from three possible layers where there can be attacks:
- Enterprise
- Mobile
- ICS (Industrial Control Systems)

---

### 🧠 **What the Enterprise Layer Covers:**

- On-premise systems (Windows, Linux, macOS)
- Cloud platforms (AWS, Azure, GCP)
- SaaS environments (like Microsoft 365)
- Identity systems (Active Directory, etc.)
- User workstations, file servers, and email

---

### ✅ **Structure of ATT&CK Enterprise:**

#### 🔹 **Tactics** (Columns in the matrix)

Think of these as the **“goals”** or **stages** an attacker wants to accomplish — like breaking in, stealing data, or maintaining access.

Here are some key tactics:

|Tactic|Purpose|
|---|---|
|**Initial Access**|How attackers first get into a system|
|**Execution**|How they run malicious code|
|**Persistence**|How they stay in the system over time|
|**Privilege Escalation**|How they gain more powerful access|
|**Defense Evasion**|How they avoid being detected|
|**Credential Access**|How they steal usernames/passwords|
|**Discovery**|How they explore the system/network|
|**Lateral Movement**|How they move from one machine to another|
|**Collection**|How they gather target data|
|**Exfiltration**|How they send stolen data out|
|**Command and Control**|How they communicate with compromised systems|

---

#### 🔹 **Techniques** (Rows under each tactic)

These describe **how** the attacker achieves each tactic.  
Each technique may have:

- Variants called **sub-techniques**
    
- Associated **mitigations** and **detections**
    

> Example:

- **Tactic:** Credential Access  
    → **Technique:** Keylogging  
    → **Sub-technique:** Recording keyboard input to capture passwords