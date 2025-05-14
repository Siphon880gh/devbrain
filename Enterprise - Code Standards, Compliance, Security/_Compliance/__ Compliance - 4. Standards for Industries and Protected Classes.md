If your SaaS app serves any of these industries, you must follow their standards, usually mandated by law.

## Healthcare

### **HIPAA (Health Insurance Portability and Accountability Act)**

**Objective:**  
Protect the privacy and security of individuals’ health information (PHI) in the healthcare sector.

**Requirements:**
- Implement administrative safeguards like workforce training and security management processes.
- Apply physical safeguards such as facility access controls and secure workstation use.
- Enforce technical safeguards including access control, encryption, and audit controls.
- Ensure that Business Associate Agreements (BAAs) are in place when third parties handle PHI.
- Conduct regular risk assessments to identify and mitigate vulnerabilities to ePHI.

**NIST is a U.S. government agency, and its publications are **widely used to meet HIPAA's technical and administrative requirements.**

Key examples:
- **NIST SP 800-66 Rev. 1**:  
    _“An Introductory Resource Guide for Implementing the HIPAA Security Rule”_
- Maps HIPAA Security Rule safeguards to NIST controls.
- Helps covered entities understand how to use NIST’s risk management framework for HIPAA.
- **NIST SP 800-53**:
- A catalog of security and privacy controls often used to implement HIPAA-compliant systems.
- **NIST Cybersecurity Framework (CSF)**:
- Not HIPAA-specific, but its flexible structure helps health orgs align security practices with HIPAA requirements.

👉 **Bottom line:** NIST provides detailed, government-backed guidance for HIPAA compliance.

*****ISO** are not HIPAA-specific, but they:**  
- Support **information security best practices**.
- Can help demonstrate **due diligence and strong controls** for protecting PHI.
- **ISO 27799** is a health-sector specific extension of ISO 27001.

👉 So while **ISO is helpful**, it doesn’t directly map to HIPAA like NIST does.


**🔹 ISO 27799**
- **A healthcare-specific extension of ISO 27001.**
- **Provides detailed guidance for protecting personal health information in healthcare systems.**

Again, while it can be applied to PHI in any form, its controls are geared heavily toward ePHI environments (networks, storage, data transfers).

---
## Education

### **FERPA (Family Educational Rights and Privacy Act)**

**Objective:**  
Protect the privacy and security of students’ education records and personally identifiable information (PII) in the education sector.

**Requirements:**
- Allow parents and eligible students to access and request correction of education records.
- Obtain written consent before disclosing student information, with limited exceptions.
- Restrict public sharing of “directory information” unless families are given an opt-out.
- Transfer privacy rights from parents to students at age 18 or upon enrollment in a postsecondary institution.
- Apply protections to all forms of education records—paper, verbal, and electronic.

### ✅ Who FERPA Covers:

| Level of Education                            | Covered by FERPA?                                                 |
| --------------------------------------------- | ----------------------------------------------------------------- |
| **Public K–12 schools**                       | ✅ Yes                                                             |
| **Private K–12 schools**                      | ⚠️ Only if they receive federal funding                           |
| **Colleges & Universities**                   | ✅ Yes                                                             |
| **Online learning platforms used by schools** | ✅ If handling education records on behalf of covered institutions |

### NIST and FERPA Compliance

**NIST** is a U.S. government agency that provides technical standards and cybersecurity frameworks widely adopted by schools and vendors to help meet FERPA requirements—especially when handling electronic student data.

**Key examples:**

- **NIST SP 800-171:**  
    A set of security requirements for protecting Controlled Unclassified Information (CUI) in non-federal systems, often used by educational institutions to secure student data.
    
- **NIST SP 800-53:**  
    A catalog of security and privacy controls used to build secure systems that align with FERPA’s intent.
    
- **NIST Cybersecurity Framework (CSF):**  
    Not FERPA-specific, but supports risk-based security planning and helps educational institutions organize their technical and administrative controls.
    

👉 **Bottom line:** NIST provides detailed, government-backed guidance for protecting student records in digital environments under FERPA.

### ISO and FERPA

**ISO standards are not FERPA-specific**, but they:

- Promote strong information security practices.
    
- Help demonstrate institutional responsibility and compliance with FERPA’s intent, particularly for vendors handling student data.
    

👉 **So while ISO frameworks (like ISO 27001)** can support secure environments, **they do not directly map to FERPA** like NIST publications do.

🔹 **ISO 27001**  
A general-purpose information security standard that can help institutions implement a structured approach to managing and protecting student PII.

🔹 **ISO/IEC 27018**  
Focused on protecting personally identifiable information in public cloud environments—useful for vendors working with schools and universities.

> While FERPA is a legal requirement, NIST and ISO provide the technical controls and process frameworks to **support secure implementation**.

---

## **Children’s Privacy**

### COPPA (Children’s Online Privacy Protection Act)

**Objective:**  
Protect the personal information and online privacy of children under the age of 13 by regulating how websites, apps, and online services collect, use, and share their data.

**Requirements:**

- Obtain **verifiable parental consent** before collecting personal information from children under 13.
- Provide a **clear and comprehensive privacy policy** detailing data practices related to children.
- Allow parents to **review, delete, or refuse further data collection** about their child.
- Limit data collection to what is reasonably necessary for a child to participate in an activity.
- Maintain **reasonable security** procedures to protect children’s data.
### Social Media and COPPA

Social media platforms have faced scrutiny under COPPA, as children under 13 can **inadvertently sign up** or lie about their age.  
For example, **Facebook and Instagram prohibit users under 13** from creating accounts to comply with COPPA. However, this is often not sufficient—children can easily falsify their birthdate to bypass age gates, leading to **unauthorized data collection** and potential COPPA violations.

👉 **Bottom line:** Simply requiring users to enter their age is not enough. Platforms must implement **robust age verification and parental consent systems** to comply with COPPA.
### FTC Enforcement and Coverage

COPPA is enforced by the **Federal Trade Commission (FTC)** and applies to:

- **Operators of websites, mobile apps, and online services** that are directed to children under 13
    
- **General-audience platforms** that knowingly collect data from children
    

Violations can result in **significant fines**, legal action, and reputational harm. High-profile cases have included actions against platforms like **YouTube**, **TikTok**, and **ad tech providers** for unauthorized collection of children’s data.
### What Counts as Personal Information Under COPPA?

- Full name
- Home or email address
- Phone number
- IP address or device identifiers
- Geolocation data
- Photos, videos, or voice recordings of the child
- Any other information that allows someone to identify or contact the child

### Frameworks and Best Practices to Support COPPA

While COPPA is the legal baseline, organizations can use **NIST privacy engineering guidelines** and frameworks like the **NIST Privacy Framework** to implement stronger privacy controls.

**ISO/IEC 29184** (Online Privacy Notices and Consent) and **ISO/IEC 27001** (information security) also support best practices for handling children’s data in compliance with global privacy expectations.

👉 These frameworks help organizations **go beyond minimum compliance** and create safer digital environments for children.

---

## Financial

### **GLBA (Gramm-Leach-Bliley Act)**

**Objective:**  
Protect the privacy and security of consumers’ personal financial information held by financial institutions.

**Requirements (Key Rules):**
- **Safeguards Rule:**  
    Develop, implement, and maintain a written **information security plan** to protect customer data.
- **Financial Privacy Rule:**  
    Provide clear **privacy notices** explaining what personal data is collected, how it is used, and how it is protected.
- **Pretexting Provisions:**  
    Prevent unauthorized access to private information through social engineering or impersonation.

**Common Controls:**
- Conduct regular risk assessments.
- Encrypt sensitive customer information.
- Limit access to personal data on a need-to-know basis.
- Monitor third-party service providers for compliance.
- Train staff on data protection practices.

> GLBA applies to banks, insurance companies, mortgage brokers, investment firms, and any organization “significantly engaged” in providing financial products or services to individuals.


### **SOX (Sarbanes-Oxley Act)**

**Objective:**  
Ensure the accuracy and integrity of financial reporting for publicly traded companies and prevent corporate fraud.

**Requirements:**

- Establish internal controls over financial reporting (ICFR).
- Require executive certification of financial statements (Section 302).
- Maintain audit trails and records retention (Section 404).
- Implement access controls and monitor system changes.
- Enable external auditors to evaluate IT systems and data security processes.

> While not an IT-specific law, SOX heavily involves IT teams to maintain system integrity and support audit readiness for financial data.