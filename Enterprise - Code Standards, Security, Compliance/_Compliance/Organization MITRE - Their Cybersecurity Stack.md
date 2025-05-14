Here’s a visual-style breakdown of how they connect in a **top-down threat lifecycle**:
```
        [ ATT&CK ]  
     ↙            ↘  
[ CAPEC ]       [ CVE ]  
     ↘            ↙  
        [ CWE ]
```

### 🔁 Explanation:

- **ATT&CK** defines _what attackers do_ — their goals, tactics, and techniques in real environments.
- **CAPEC** explains _how_ attackers perform those techniques — in the form of **generalized attack patterns**.
- **CVE** catalogs _specific vulnerabilities_ in real-world software (e.g., Log4Shell).
- **CWE** categorizes the _underlying weaknesses_ that make CVEs possible (e.g., input validation failure).

So:
- **CWE** → Root cause
- **CAPEC** → Exploitation method
- **CVE** → Real-world example
- **ATT&CK** → Adversary behavior in the wild

## ✅ Summary

MITRE provides a complete ecosystem of cybersecurity intelligence tools:

- **CWE** helps developers write more secure code.
- **CVE** gives defenders a way to track specific software flaws.
- **CAPEC** helps analysts understand and simulate attack scenarios.
- **ATT&CK** helps blue teams detect and respond to adversary behavior in real time.

These resources are **interconnected**, widely supported by cybersecurity tools (e.g., SIEMs, scanners, IDS), and used in **government, enterprise, and compliance frameworks** worldwide.