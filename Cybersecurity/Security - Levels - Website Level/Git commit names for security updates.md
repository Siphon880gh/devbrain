
Using a consistent and professional commit naming scheme—especially for security-related updates—improves communication, simplifies audit trails, and enhances trust in your development process. Always include enough detail to describe the nature and risk of the change, and make it easy for others to assess at a glance.

---

### 🔐 **Commit Naming for Security-Only Updates**

When a commit addresses **only security issues**, the name should clearly indicate the nature and scope of the fix. You should also note whether the update affects **application code**, **infrastructure**, or **dependencies**, and optionally mention the **severity level** (low, medium, high, or critical).

#### **Examples:**

- `SECURITY (High): Patched XSS vulnerability in user profile page [App Code]`
    
- `SECURITY (Critical): Blocked unauthorized access via API token misconfiguration [Server Config]`
    
- `SECURITY (Medium): Updated outdated SSL/TLS cipher suites [Infrastructure]`
    
- `SECURITY (Low): Removed exposed internal debug endpoint [Code Cleanup]`
    
- `SECURITY: Bumped dependency to fix CVE-2025-12345 [Dependencies]`


### 🔐 **Commit Naming When Quick and Dirty Bootstrapping**

If it's your first security updates and you're bootstrapping the app, you may not care to be so specific and would rather prefer to return to writing code asap. You can name as:

- `SECURITY: Code hardened {Optionally explain}`
- `SECURITY: Server hardened {Optionally explain}`

---

### 🔄 **Commit Naming for Mixed Updates (Security + Non-Security)**

Sometimes, a commit includes **both security fixes and general improvements**. In these cases, it’s important to still highlight the presence of a security patch, but within a broader context.

Use prefixes like `UPDATE:` or `RELEASE:` to show it's a general update, and clearly tag the security context within parentheses or descriptors. Mentioning the **severity** of the security component is highly recommended.

#### **Examples:**

- `RELEASE: UI enhancements and auth fix (includes HIGH severity security patch)`
    
- `UPDATE: Refactored API + resolved privilege escalation issue (Security - Critical)`
    
- `RELEASE v2.3.1: Performance improvements, dependency updates, and XSS mitigation`
    
- `UPDATE: Admin dashboard tweaks + session token renewal patch (Security - Medium)`
    
- `RELEASE: Codebase cleanup and firewall rule tightening [Security - Low]`
    

---

### 🧩 **Optional Enhancements for Traceability**

To support audits and internal review processes, you may consider adding:

- **CVE IDs or internal issue tracking references**
    
    - Example: `SECURITY: Fixed input sanitization (CVE-2025-12345)`
    - **CVE** stands for **Common Vulnerabilities and Exposures** and is a public identifier assigned to a known cybersecurity vulnerability. Managed by [The MITRE Corporation](https://www.cve.org/), CVEs are widely used across the industry to provide a standardized reference for discussing, tracking, and addressing security issues.
    - And team can search and it'll list all commits with a specific CVE number:
		```
		git log --grep="CVE-2025-12345"      
		```
    
- **Environment labels** (e.g., [App Code], [Server], [Cloud Infra])
    
- **Version tags** for formal releases
    
    - Example: `RELEASE v1.4.0: Security + Feature Additions`
        

---

### ✅ **Commit Naming Template**

For clarity and consistency, use the following template:

```
<TYPE> (Severity): <Short Summary> [Scope/Area]
```

**TYPE** can be:

- `SECURITY`: for security-only changes
- `UPDATE`: for mixed updates or internal patches
- `RELEASE`: for formal, versioned releases

**Severity levels**: Low, Medium, High, Critical  
**Scope**: App Code, Server Config, Infra, Dependencies, etc.


