## Definitions

**Standards are typically versioned by date or numerical designation** to reflect ongoing updates as new vulnerabilities emerge and security expectations evolve. This ensures they remain relevant and effective over time.

**In some cases, standards include a series or number** that corresponds to a specific industry or category, helping to group related standards under a common framework.

---

**Compliance frameworks** and **standards** are often used interchangeably, but there's a subtle difference worth noting:
- A **framework** may incorporate **multiple standards** or map to them.
- A **standard** can stand alone or be a building block **within a framework**.

In practice, people often say:
- "We follow the **SOC 2 standard**" (though it’s technically a framework).
- "We're ISO 27001 **compliant**" (referring to a standard treated like a framework).
    
So while they aren’t strictly the same, they’re commonly used as synonyms in operational settings—especially in security, compliance, and audits.

---

**Map of standards**

Map 1:
![[Pasted image 20250514015657.png]]

Map 2:
![[Pasted image 20250514015722.png]]

From: https://complianceforge.com/grc/nist-800-53-vs-iso-27002-vs-nist-csf-vs-scf

---

## **Standards / Compliance Frameworks**

### **PCI DSS (Payment Card Industry Data Security Standard)**

**Objective:**  
Protect cardholder data during transactions.

**Requirements:**
- Maintain a secure network using firewalls and strong password policies.
- Encrypt data during transmission and securely store sensitive information.
- Conduct regular testing of security systems and processes.
- Enforce strong access control through unique user IDs and role-based permissions.

### **ISO 27001**

**Objective:**  
Ensure the confidentiality, integrity, and availability of information by implementing an Information Security Management System (ISMS).

**Requirements:**
- Perform comprehensive risk assessments and manage identified risks.
- Establish and enforce information security policies, including asset management.
- Implement effective incident response and management processes.
- Comply with legal obligations and contractual security requirements.
- Measure performance regularly and conduct internal audits to ensure ongoing compliance.

### **SOC 2 (System and Organization Controls 2)**

**Objective:**  
Ensure service providers securely manage data to protect the privacy and interests of their clients, particularly in cloud-based environments.

**Requirements:**

- Establish controls aligned with the **five Trust Services Criteria**: Security, Availability, Processing Integrity, Confidentiality, and Privacy.
- Implement risk management and internal control policies.
- Monitor and log access to systems and sensitive data.
- Conduct third-party audits to verify effectiveness of internal controls.
- Maintain incident response and breach notification processes.
### **FISMA (Federal Information Security Management Act)**

**Objective:**  
Ensure the security of federal information systems and data by requiring federal agencies and contractors to implement comprehensive information security programs.

**Requirements:**

- Categorize information and systems based on risk impact (low, moderate, high).
- Implement minimum security controls as defined by **NIST SP 800-53**.
- Conduct regular risk assessments and continuous monitoring.
- Develop and maintain system security plans (SSPs).
- Report security status to oversight bodies such as OMB and DHS.

### **CMMC (Cybersecurity Maturity Model Certification)**

**Objective:**  
Protect Controlled Unclassified Information (CUI) across the defense industrial base by assessing and certifying the cybersecurity maturity of Department of Defense (DoD) contractors.

**Requirements:**
- Meet one of five maturity levels, from basic cyber hygiene (Level 1) to advanced/progressive practices (Level 5).
- Implement a range of practices drawn from NIST SP 800-171 and other sources.
- Undergo certification by an authorized third-party assessment organization (C3PAO).
- Demonstrate institutionalization of processes at each maturity level.
- Ensure continuous compliance for contract eligibility with DoD.

### **FedRAMP (Federal Risk and Authorization Management Program)**

**Objective:**  
Standardize security assessment, authorization, and continuous monitoring for cloud products and services used by U.S. federal agencies.

**Requirements:**
- Implement and document security controls from **NIST SP 800-53**, tailored for cloud environments.
- Complete a rigorous assessment process through a **Third-Party Assessment Organization (3PAO)**.
- Obtain a Joint Authorization Board (JAB) or Agency ATO (Authorization to Operate).
- Continuously monitor systems and submit periodic reports.
- Maintain a FedRAMP-compliant System Security Plan (SSP) and POA&M (Plan of Action and Milestones).

### **NIST CSF (Cybersecurity Framework)**

**Objective:**  
Provide a structured, voluntary framework to help organizations manage and reduce cybersecurity risks.

**Requirements (Framework Core Functions):**

- **Identify:** Understand the business context, resources, and risk environment.
- **Protect:** Develop safeguards like access controls, awareness training, and data security.
- **Detect:** Implement continuous monitoring and detection systems for anomalies.
- **Respond:** Establish incident response plans and communications strategies.
- **Recover:** Maintain recovery plans and improve resilience through lessons learned.

> While not a regulation, NIST CSF is widely used across industries and often integrated into regulatory compliance programs (e.g., FISMA, CMMC).

### **COBIT (Control Objectives for Information and Related Technologies)**

**Objective:**  
Provide a governance and management framework for enterprise IT that ensures alignment between business goals and IT processes.

**Requirements:**
- Define roles and responsibilities using governance and management objectives.
- Implement control processes for planning, building, delivering, and monitoring IT services.
- Focus on value delivery, risk management, and performance measurement.
- Use a maturity model to assess and improve governance capability.
- Align IT activities with enterprise strategy and compliance requirements.

> COBIT is often used in industries like finance, healthcare, and government to structure internal audits and support SOX or other compliance efforts.

### **ITIL (Information Technology Infrastructure Library)**

**Objective:**  
Standardize IT service management (ITSM) to align IT services with business needs and improve service quality.

**Requirements (Key Processes):**
- **Service Strategy:** Define market spaces, offerings, and financial management.
- **Service Design:** Develop architecture, SLAs, and capacity planning.
- **Service Transition:** Manage change, release, and deployment processes.
- **Service Operation:** Oversee incident, problem, and access management.
- **Continual Service Improvement (CSI):** Analyze metrics and implement improvements.

> ITIL is not a compliance requirement but is often paired with ISO 20000 or used in regulated sectors to demonstrate operational maturity.

---

### **NIST SP 800-171**

**Objective:**  
Protect Controlled Unclassified Information (CUI) in non-federal systems and organizations, particularly in government contracting.

**Requirements (14 Control Families):**

- Access control, audit and accountability, configuration management.
- Identification and authentication, incident response, maintenance.
- Media protection, physical protection, personnel security.
- Risk assessment, security assessment, system and communications protection, and system and information integrity.
- Document policies, implement controls, and assess regularly.

> NIST 800-171 is a foundation for CMMC compliance and is required for many DoD and federal contractors.

---

### **CSA STAR (Cloud Security Alliance - Security, Trust & Assurance Registry)**

**Objective:**  
Promote transparency, assurance, and compliance in cloud services through independent assessments and self-attestation.

**Requirements:**

- Complete the **Consensus Assessments Initiative Questionnaire (CAIQ)** for self-assessment.
- Align with **CSA Cloud Controls Matrix (CCM)**, covering key cloud security principles.
- Undergo third-party audits (e.g., ISO 27001) for **STAR Certification**.
- Opt for continuous monitoring under **STAR Level 3** for real-time assurance.
- Provide public-facing security posture documentation to customers and partners.

> CSA STAR is a cloud-specific certification model that complements ISO 27001 and supports vendor selection in cloud ecosystems.