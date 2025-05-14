
Security indexes are structured systems used to categorize and reference various aspects of cybersecurity, ranging from specific vulnerabilities to broad attack techniques. These indexes serve as foundational tools for professionals to identify, assess, and mitigate threats systematically. Common examples include the **CVE (Common Vulnerabilities and Exposures)** index, which catalogs publicly known security flaws, and the **CWE (Common Weakness Enumeration)**, which classifies the types of software weaknesses that lead to these flaws. Others, like **CAPEC** and **MITRE ATT&CK**, document known attack patterns and adversary tactics. These indexes are essential for building secure systems, guiding threat assessments, and ensuring compliance with security standards across industries.


Here's a table that helps you grasp the common security indexes:

## Index Purposes

| **Index**                | **Full Name**                                                                                  | **Purpose**                                                                                             |
| ------------------------ | ---------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- |
| **ISO/IEC 27000 Series** | International Organization for Standardization / International Electrotechnical Commission     | Provides international standards for information security management systems (ISMS) and best practices. |
| **CVE**                  | Common Vulnerabilities and Exposures                                                           | Catalogs publicly known security flaws and vulnerabilities.                                             |
| **CWE**                  | Common Weakness Enumeration                                                                    | Classifies types of software weaknesses that lead to vulnerabilities.                                   |
| **CAPEC**                | Common Attack Pattern Enumeration and Classification                                           | Documents known attack patterns used by adversaries.                                                    |
| **ATT&CK**               | MITRE ATT&CK (Adversarial Tactics, Techniques, and Common Knowledge)                           | Maps out real-world attacker behaviors and techniques.                                                  |
| STIX/TAXII               | Structured Threat Information Expression / Trusted Automated eXchange of Indicator Information | Formats and exchanges threat intelligence data (e.g., IOCs) across systems and organizations.           |

Here are detailed run-downs of each index.

## Index Details
### **ISO Standards Classification**:

- Formats also include hierarchical categories, sometimes separated by slashes (e.g., "35/50 – Information Processing Systems").
- **Format:** Standards are identified hierarchically with numerical codes and sometimes slashes.
- **Example:** `35/50`

- `35`: Information processing.
- `50`: Subcategory under information systems.

- ISO standards use divisions like **ISO/IEC 27001 (Information Security)** to represent high-level categorization and subcategories.
  
### **CVE (Common Vulnerabilities and Exposures)**  

Purpose: Provides unique identifiers for publicly known security vulnerabilities.

Key Aspects:
- Facilitates rapid identification and tracking of vulnerabilities (e.g., CVE-2022-22965 for Spring4Shell).
- Aligns teams using severity ratings such as CVSS.
- Widely supported by scanning tools like Nessus and OpenVAS for efficient vulnerability management.

USUALLY PAIRED WITH: CVSS Score that tells you vulnerability score and CVEs. Refer to [[Scores - CVSS (Common Vulnerability Scoring System)]]

### **CWE (Common Weakness Enumeration)**

- **What it is:** A catalog of **software weakness types**, such as buffer overflows, injection flaws, or improper authentication.
- **Use case:** Helps developers and security teams understand **why** a vulnerability (like one in CVE) exists.
- **Maintained by:** MITRE
- **Example:** CWE-79 = Cross-Site Scripting (XSS)

>💡 _CWE is about the “class” of flaw, while CVE is about a specific instance in software._

### **CAPEC (Common Attack Pattern Enumeration and Classification)**

- **What it is:** A database of **known attack patterns** used by adversaries.
- **Use case:** Supports **threat modeling**, red teaming, and detection engineering.
- **Maintained by:** MITRE
- **Example:** CAPEC-137 = Parameter Injection

###  **ATT&CK (Adversarial Tactics, Techniques, and Common Knowledge)**

- **What it is:** A framework of **real-world attacker behaviors**, categorized by tactics and techniques.
- **Use case:** Helps SOC teams detect, investigate, and respond to specific adversarial actions.
- **Maintained by:** MITRE
- **Example:** T1059 = Command and Scripting Interpreter (used in malware and lateral movement)
- Example: Supply Chain Compromise
	- Information Paper: https://attack.mitre.org/techniques/T0862/
	- ID: T0862
	- Tactic: Initial Access
	- Description: Supply chain compromise can occur at all stages of the supply chain, from manipulation of development tools and environments to manipulation of developed products and tools distribution mechanisms.
	- Procedure Examples (ID, Name, Description):
		- S0093, Backdoor.Oldrea: The Backdoor.Oldrea RAT is distributed through trojanized installers planted on compromised vendor sites.
		- G0035, Dragonfly: Dragonfly trojanized legitimate ICS equipment providers software packages available for download on their websites.
		- G0088, TEMP.Veles: TEMP.Veles targeted several ICS vendors and manufacturers.
	- Targeted Assets
		- A0008	Application Server
		- A0007	Control Server
		- A0009	Data Gateway
		- ...
		- A0001	Workstation
	- Mitigation
		- M0945, Code Signing: When available utilize hardware and software root-of-trust to verify the authenticity of a system. This may be achieved through cryptographic means, such as digital signatures or hashes, of critical software and firmware throughout the supply chain.
		- ...
	- Detection (ID, Data Source, Data Component, Description):
		- DS0022, File, File Metadata: Use verification of distributed binaries through hash checking or other integrity checking mechanisms. Scan downloads for malicious signatures.

###  **STIX/TAXII (Structured Threat Information Expression / Trusted Automated eXchange of Indicator Information)**

- **What they are:**
	- **STIX:** A standard for structuring **threat intelligence data**
	- **TAXII:** A protocol for **exchanging** that intelligence between systems
- **Use case:** Enables automation and sharing of threat intel between tools or orgs

### ✅ Table of Index Example and Organizations

| Index          | Focus Area                                                | Example            | Maintained By |
| -------------- | --------------------------------------------------------- | ------------------ | ------------- |
| ISO 27001      | Information security management systems (ISMS)            | ISO/IEC 27001:2022 | ISO/IEC       |
| **CVE**        | Specific vulnerabilities                                  | CVE-2022-22965     | MITRE         |
| **CWE**        | Software weakness types. Aka: Type of flaw that caused it | CWE-79 (XSS)       | MITRE         |
| **CAPEC**      | Known attack patterns. Refer to ___                       | CAPEC-137          | MITRE         |
| **ATT&CK**     | Attacker tactics and techniques                           | T1059              | MITRE         |
| **STIX/TAXII** | Threat intel formatting & sharing                         | IOC exchange       | OASIS         |

### Related:

| Index    | Focus Area                     | Example           | Maintained By | **Related how**                                                               |
| -------- | ------------------------------ | ----------------- | ------------- | ----------------------------------------------------------------------------- |
| **CVSS** | Vulnerability severity scoring | CVSS 9.8 Critical | FIRST.org     | Often paired with CVEs to determine which vulnerabilities need urgent action. |

---

## More on Indexing

For more, refer to notes perfixed `Indexes - *` in this same folder.