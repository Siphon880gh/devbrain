There are indexing (aka classification system) that uses a format with _slashes_ like "xx/xx/xx" etc which are helpful because it can succinctly describe the situation, so it's worth learning these indexes.

**Indexes with Slash Notations**

- **ISO Standards Classification**:
	- Formats also include hierarchical categories, sometimes separated by slashes (e.g., "35/50 – Information Processing Systems").
	- **Format:** Standards are identified hierarchically with numerical codes and sometimes slashes.
	- **Example:** `35/50`
		- `35`: Information processing.
		- `50`: Subcategory under information systems.
	- ISO standards use divisions like **ISO/IEC 27001 (Information Security)** to represent high-level categorization and subcategories.

- **CVE (Common Vulnerabilities and Exposures)**
	- Format: `CVE-YYYY-NNNN`
	- Used for indexing public security vulnerabilities.
	- Example: `CVE-2023-45612`
		- CVE: Identifier.
		- YYYY: Year when vulnerability was disclosed.
		- NNNN: Unique number assigned to the vulnerability.
	- Note: While it uses dashes instead of slashes, its hierarchical structure and unique indexing match how vulnerabilities are cataloged.  

- **CVSS (Common Vulnerability Scoring System) Vector Format**
	- Format: `AV:/AC:/PR:/UI:/S:/C:/I:/A:`
	- Purpose: Describes vulnerabilities’ exploitability and impact comprehensibly.
	- Example Format: `AV:N/AC:L/PR:N/UI:N/S:U/C:H/I:H/A:H`
		- AV (Attack Vector): Network.
		- AC (Attack Complexity): Low.
		- PR (Privileges Required): None.
		- UI (User Interaction): None.
		- S (Scope): Unchanged.
		- C/I/A (Confidentiality, Integrity, Availability): High.
	- Example: CVSS:3.0/AV:N/AC:L/PR:N/UI:N/S:C/C:H/I:H/A:H
		- URL: https://www.invicti.com/web-vulnerability-scanner/vulnerabilities/classification/cvss3-0-avn-acl-prn-uin-sc-ch-ih-ah/
		- Interpretation:
			
			| Metric                         | Value       | Meaning                                                                                                             |
			| ------------------------------ | ----------- | ------------------------------------------------------------------------------------------------------------------- |
			| **CVSS**                       | 3.0         | This follows version 3.0 of the CVSS (Common Vulnerability Scoring System).                                         |
			| **AV (Attack Vector)**         | N (Network) | Can be exploited remotely over a network. No local or physical access required.                                     |
			| **AC (Attack Complexity)**     | L (Low)     | Exploiting the vulnerability is straightforward with no special conditions.                                         |
			| **PR (Privileges Required)**   | N (None)    | Attacker doesn't need any privileges or access to exploit it.                                                       |
			| **UI (User Interaction)**      | N (None)    | No user interaction (like clicking a link) is required.                                                             |
			| **S (Scope)**                  | C (Changed) | The vulnerability affects resources beyond its security scope (e.g., one user's actions compromise another's data). |
			| **C (Confidentiality Impact)** | H (High)    | Major loss of confidentiality (e.g., full data disclosure).                                                         |
			| **I (Integrity Impact)**       | H (High)    | Major loss of integrity (e.g., data tampering or modification).                                                     |
			| **A (Availability Impact)**    | H (High)    | Major loss of availability (e.g., service crash or downtime).                                                       |
			
			Invicti lists vulnerabilities with the same CVSS Score situation:
			![[Pasted image 20250514023252.png]]


- **MITRE ATT&CK Tactic/Technique Classification**  
	- Format: Layers, with slashes to separate Tactics, Techniques, and Sub-techniques.
	- Example: `TA0001/T1059/T1059.001`
		- TA0001: Initial Access (Tactic).
		- T1059: Command and Scripting Interpreter (Technique).
		- T1059.001: PowerShell (Sub-technique).
	- Used to map and classify adversarial behavior.

- **PCI DSS Compliance Controls  
- Context: While PCI DSS doesn’t explicitly use slash-based numbering, its control framework is sequentially organized into 6 domains with sub-controls that could be interpreted similarly.
- Example Format: `Requirement/Control/Sub-control`
	- Example: `12/5/2`
		- 12: Maintain a policy that addresses security for all personnel.
		- 5: Sub-requirement related to tracking and monitoring access.
		- 2: Further division into specific expectations for logging activity.

- **NIST Standards (SP 800 Series)  
	- Purpose: NIST security controls outline cybersecurity best practices for federal and private systems, often broken into hierarchical control identifiers.
	- Format: `Control Family/Sub-category/Parameter`
		- Example: Access Control/AC-2/1
			- AC (Access Control): A top-level family.
			- 2: Sub-category (Account Management).
			- 1: Sub-control parameter, e.g., requiring privileged accounts to be regularly audited.
	- Related Standards:
		- NIST Cybersecurity Framework (CSF).
		- Federal Information Processing Standards (FIPS).

- **Vulnerability Databases (e.g., National Vulnerability Database - NVD)**
	- Purpose: Use identifiers for vulnerabilities aligning with CVE or CVSS scoring systems.
	- Examples:
		- CVE-YYYY-XXXX: Globally unique identifier for each vulnerability (e.g., CVE-2023-45127).
		- Slash Formats in Exploit Strings:
			- `AV:N/AC:L/...` in CVSS scoring (as described above).

- **DISA/STIG (Security Technical Implementation Guides)**  
	- Purpose: Mandated by the U.S. Department of Defense, STIGs define secure implementation practices for systems.
	- Classification Example: `Group/Control/Rule-ID`
		- Example:
			- `V-12345/AC-53/AUD-1`
				- V-12345: Vulnerability ID.
				- AC-53: Refers to specific access control implementation requirements.
				- AUD-1: Indicates associated audit guidance for compliance tracking.
