
## Invicti Product

**What it is:**
- **NOT** an indexing even though they do list all the web vulnerabilities.  
- What they really are is a dynamic application security testing (DAST) tool.  
  
**Functions:**
- Detects critical web vulnerabilities such as SQL Injection, Cross-Site Scripting (XSS), and misconfigurations.
- Integrates seamlessly with CI/CD pipelines to support secure DevOps practices.
- Offers prioritized, actionable remediation guidance for developers and security teams.

## Invicti lists indexes from different standards

Invicti **does not** own these standards.

Their web vulnerabilities list:
https://www.invicti.com/learn/vulnerabilities/

Their scanner:
https://www.invicti.com/product/

----

## Classification Section

The **"Classification"** section in a vulnerability report from **Invicti** (or similar tools like Acunetix) often mixes **indexes**, **scores**, and **standards/frameworks** to show how a single vulnerability maps across different domains of security understanding and compliance.

Example from https://www.invicti.com/web-vulnerability-scanner/vulnerabilities/activemq-remote-code-execution-cve-2023-46604/

```
Classifications:
OWASP 2017-A1, CAPEC-242, CWE-94, CVSS:3.0/AV:N/AC:L/PR:N/UI:N/S:C/C:L/I:H/A:H, ISO27001-A.14.2.5, HIPAA-164.306(a), 164.308(a), PCI v3.2-6.5.1, OWASP 2013-A1
```

Here's how to break it down:
The **"Classification"** section in a vulnerability report from **Invicti** (or similar tools like Acunetix) often mixes **indexes**, **scores**, and **standards/frameworks** to show how a single vulnerability maps across different domains of security understanding and compliance.

### ✅ **Indexes / Taxonomies (Categorize Type of Vulnerability)**

These help you understand the nature and cause of the vulnerability.

- **OWASP 2017-A1**: Injection (from OWASP Top 10, 2017)
- **OWASP 2013-A1**: Also Injection (older OWASP Top 10 version)
- **CAPEC-242**: _Code Injection_ – Common Attack Pattern Enumeration and Classification
- **CWE-94**: _Improper Control of Code Generation (‘Code Injection’)_ – Common Weakness Enumeration

### ✅ **Scoring / Risk Rating System (Quantifies Severity)**

These help prioritize based on how dangerous the vulnerability is.

- **CVSS:3.0/AV:N/AC:L/PR:N/UI:N/S:C/C:L/I:H/A:H**  
    - This is a **CVSS v3.0 vector**, which breaks down attack characteristics.
    - Example meaning: Exploitable over network, no privileges required, no user interaction, full impact on integrity and availability.
    
### ✅ **Compliance Standards / Frameworks (Map to Legal or Industry Requirements)**

These show what laws or industry rules require this type of vulnerability to be addressed.

- **ISO27001-A.14.2.5**: Security in development and testing
- **HIPAA-164.306(a), 164.308(a)**: U.S. healthcare security rules – requires protecting ePHI
- **PCI v3.2-6.5.1**: Payment Card Industry – requires protection against common coding vulnerabilities like injection

### 🧠 Summary of Classification Section

This multi-tagging allows **security teams**, **compliance officers**, and **developers** to all get relevant views depending on their focus — whether it's _technical cause_, _exploitability_, or _legal/regulatory exposure_.

|Type|Examples|
|---|---|
|**Indexes/Taxonomies**|OWASP, CAPEC, CWE|
|**Scoring System**|CVSS|
|**Compliance Standards**|ISO 27001, HIPAA, PCI DSS|
