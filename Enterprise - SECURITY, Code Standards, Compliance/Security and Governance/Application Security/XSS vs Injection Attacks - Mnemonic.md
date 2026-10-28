Required knowledge:
- [[XSS vs Injection Attacks - Client-Side and Server-Side Risks]]

---

Cross-site scripting (XSS) is a specific type of injection attack

The simplest distinction is:
- **XSS usually executes in the client:** malicious HTML or JavaScript runs in a victim's browser under the affected site's origin.
	- Mnemonic: XSS -> UX. Think user experience. Think user side
- **Other common injection attacks usually execute on the server:** malicious input changes a database query, system command, template, or another backend operation.
	- Mnemonic: Without the X in UX, it's all the other types of injections eg. server sided.