ISS (information security standards) privacy control standards functions as a compliance mapping and control requirements matrix catalog.

Filename: iss-01-801-information-security-and-privacy-controls-standards-catalog.xlsx
Url: https://www.txdot.gov/content/dam/docs/itd/iss-01-801-information-security-and-privacy-controls-standards-catalog.xlsx


![[Pasted image 20250514012425.png]]

---
### ✅ What It Is:

**ISS Privacy Control Standards** are developed by the **Texas Department of Information Resources (DIR)** and serve as a **state-level security and privacy control framework**, particularly applicable to Texas government agencies and contractors.

---

### 🧩 Functions as a Compliance Control Matrix:

The ISS standard provides:

|Function|Description|
|---|---|
|**Control Catalog**|Lists individual controls covering security and privacy domains (e.g., Access Control, Incident Response).|
|**Mapping Matrix**|Maps controls to multiple frameworks like NIST SP 800-53, TX-RAMP, FedRAMP, PCI DSS, and CJIS.|
|**Implementation Guidance**|Gives standards or procedural guidance to help organizations implement the controls.|
|**Overlays**|Includes overlays or tailoring for different security baselines (Low, Moderate, High) and programs like TX-RAMP.|
|**Discussion/Justification**|Contains explanation sections for why a control exists and its importance.|
|**Crosswalk Columns**|Provides direct cross-referencing to equivalent controls in federal and industry standards (e.g., NIST AC-2 ↔ PCI 8.1).|

---

### 📜 Standards Include

TxDOT (Texas Department of Transportation)—to ensure alignment with various cybersecurity and privacy standards, including:

- NIST SP 800 series
- FedRAMP (Low, Moderate, High)
- TX-RAMP (Texas Risk and Authorization Management Program)
- PCI DSS (Payment Card Industry Data Security Standard)
- CJIS (Criminal Justice Information Services)


### 🏗️ Key Table Columns (Explained)

| Column                     | Purpose                                                                                            |
| -------------------------- | -------------------------------------------------------------------------------------------------- |
| Control Requirements       | What the organization must implement to meet the control.                                          |
| Implementation Standards   | Specific technical/procedural rules (often from laws or industry frameworks).                      |
| Overlays                   | Indicates which frameworks this control helps satisfy (PCI, FedRAMP, TX-RAMP, etc.).               |
| References                 | Citations from federal (e.g., NIST), state (e.g., TAC), and organizational (e.g., TxDOT) policies. |
| Discussion                 | Clarifies intent, scope, or implementation advice.                                                 |
| Related Controls           | Links this control to others with overlapping or supporting purposes.                              |
| PCI/CJIS/TX-RAMP Standards | Shows how the control aligns with those specific regulatory requirements.                          |

---

### 📌 Why It's Used:

- **Agency compliance**: Ensures alignment with state-mandated and federal cybersecurity policies.
- **Vendor assessment**: Helps third-party vendors prove their compliance with security controls under contracts.
- **Audit readiness**: Facilitates internal audits and third-party reviews through structured documentation and mappings.

---

### 🧑‍💼 Who Uses It

This type of matrix is primarily used by:

|**Role**|**Usage**|
|---|---|
|**Information Security Officers (ISOs)**|Define, manage, and review security controls across systems.|
|**Compliance Officers / GRC Analysts**|Document how the organization meets state and federal compliance; prepare self-assessments and audits.|
|**IT Security Auditors / Assessors**|Verify implementation and effectiveness of controls; validate internal controls against external requirements.|
|**System Owners / Developers**|Understand control implications for systems they manage or build.|
|**Policy Writers / Program Managers**|Align organizational policies with regulatory standards and language.|
|**Security Architects**|Design systems to meet multiple compliance certifications and frameworks.|

### 📊 How It’s Used

- During risk assessments, to identify gaps between current controls and required standards.
- Before or during audits, to prove due diligence and control implementation.
- In vendor management, when validating if cloud providers meet TX-RAMP/FedRAMP/PCI DSS standards.
- To drive implementation of security policies, by connecting each policy to real technical or procedural requirements.

### 📄 Example Use Case:

- An agency implementing **access control policies** would:
	- Refer to ISS AC-01.
	- See it's mapped to NIST AC-1, PCI DSS 7.1, and TX-RAMP Level 2 requirements.
	- Use the provided implementation standards and review checklist.
	- Document review dates and associated artifacts for compliance tracking.
- If you’re working with TX-RAMP, state contracts, or FedRAMP-aligned systems, the ISS matrix is an essential resource for compliance orchestration.

---

### 🧠 Summary

This table serves as a crosswalk tool and practical bridge between TxDOT’s internal cybersecurity requirements and external compliance frameworks. It is used by compliance, audit, and security teams to organize, implement, and validate security controls—ensuring alignment with both internal policy and external audit expectations. In practice, it provides a checklist of required implementations, the exact standards being satisfied, supporting legal and policy references, and guidance for drafting internal policies or configuring systems accordingly.

---

### WORKFLOW: Ensuring Account Management is Compliant with PCI DSS and FedRAMP

#### 📌 Goal:

You’re a TxDOT security analyst tasked with ensuring that your system’s user account management meets PCI DSS 8.2.4 and FedRAMP AC-2 requirements.

#### 🔍 Step-by-Step Usage

##### Step 1: Filter the Table by Control Topic

You search the table for anything related to:
- `AC-02` (Account Management)
- `PCI DSS 8.2.4`
- `FedRAMP AC-2`

##### Step 2: Locate the Row

You find the row with:

| Column                   | Value                                                                                                                                   |
| ------------------------ | --------------------------------------------------------------------------------------------------------------------------------------- |
| Control Requirements     | “Define and document types of accounts, assign managers, require criteria, approvals, monitor use, disable when no longer needed, etc.” |
| PCI Standards            | 8.2.4, 7.3.1–7.3.3, 7.2.6                                                                                                               |
| FedRAMP Correspondence   | AC-2, with detail on notification timelines                                                                                             |
| Implementation Standards | Includes emergency account disable rules, automated reviews, and access review processes                                                |
| Discussion               | Explains intent, logic, and how it applies to sensitive data and different account types (e.g., service, guest, emergency accounts)     |
##### Step 3: Apply to System

You now:
- Update your System Security Plan (SSP) to define account types and managers.
- Document access request/approval workflows for normal, group, and privileged accounts.
- Ensure your system disables unused accounts automatically within the specified timeframes (24–96 hours).
- Ensure access reviews are conducted every 6 months (as required by PCI).

##### Step 4: Cite the Mapping

In your audit documentation or compliance review, you cite:
- This TxDOT control as covering both PCI 8.2.4 and FedRAMP AC-2, and
- Show that your internal policy aligns with TxDOT’s implementation standards and FedRAMP-specific time thresholds (e.g., 8 hours for terminations).
