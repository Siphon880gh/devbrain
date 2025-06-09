## Why Zero Trust Helps:

- With **least-privilege access**, the employee would only have access to what they need — not the full database.
- **Continuous monitoring** and **anomaly detection** would detect unusual behavior (e.g., large downloads or data transfers).
- **Just-in-time access** and **session auditing** could limit time windows for access and track exactly what was done.

---

## Internal Threat Examples

### 🧨 **Disgruntled Employee Exfiltrating Data**

A system administrator at a company becomes unhappy after learning they will be laid off. Before their access is revoked, they:

- Log in using valid credentials
- Download sensitive customer records or proprietary source code
- Send it to a personal email or upload it to cloud storage

Because the employee had **legitimate access**, traditional perimeter security wouldn’t flag this as suspicious.

### 🧑‍🔧 **Contractor Abuse**

**Scenario:**  
A third-party contractor is hired to perform maintenance on internal systems. While working, they access customer databases out of scope for their role and copy sensitive data.

**How it happens:**

- The contractor was given overly broad access "temporarily"
    
- No segmentation or access review was in place
    
- Their activity went unmonitored
    

**Zero Trust Prevention:**

- Enforce **least-privilege access** and **access expiration**
    
- Use **role-based access controls (RBAC)** and **session logging**
    
- Review and approve third-party access with **auditable workflows**
    

---

### 🛠️ **Misconfigured Privileges**

**Scenario:**  
An HR staff member is accidentally granted access to the finance department’s folders, including payroll and tax data. They download files without malicious intent, but the data is leaked when their device is later compromised by malware.

**How it happens:**

- Misconfigured group permissions or shared drives
    
- Lack of data classification and access boundaries
    

**Zero Trust Prevention:**

- Enforce **access reviews and privilege audits**
    
- Apply **data classification and tagging**
    
- Restrict access based on both **identity and device health**
    

---

### 📤 **Accidental Data Sharing by Employees**

**Scenario:**  
An employee uploads sensitive product specs to a personal Google Drive to work from home. The drive is not protected, and the link is later indexed or shared publicly.

**Zero Trust Prevention:**

- Block unauthorized cloud storage using **cloud access security brokers (CASB)**
    
- Detect and alert on **data exfiltration attempts**
    
- Use **data loss prevention (DLP)** rules to stop uploads of classified content
    

---

### 👩‍💻 **Compromised Insider via Phishing**

**Scenario:**  
An employee clicks on a phishing email and unknowingly gives away their login credentials. The attacker uses the employee's access to move through the network and launch ransomware.

**Zero Trust Prevention:**

- Require **MFA**, blocking use of just a stolen password
    
- Monitor behavior with **UEBA** (User and Entity Behavior Analytics)
    
- Limit damage through **micro-segmentation** and **JIT access**
    

---

Would you like these formatted into a printable briefing or slideshow format?