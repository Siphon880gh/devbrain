Paste this into an app-from-scratch prompt after the product requirements. Adapt the stack-specific parts as needed.

```text
Security requirements

Build security in from the first implementation. Follow the framework's current secure defaults and explain any security-relevant trade-offs.

- Validate all untrusted input on the server at every trust boundary: enforce request-size limits; validate schema, types, ranges, required fields, and allowed values; reject invalid input before use or storage. Client-side validation is only a usability aid.
- Prevent injection: use parameterized queries or safe ORM bindings for all database values; never build SQL, shell commands, or templates by concatenating user input. For dynamic identifiers or command choices, use strict application-owned allowlists.
- Prevent XSS: contextually encode output. If users can submit HTML, sanitize it with a maintained library. Treat uploaded files, filenames, and MIME types as untrusted; validate content and size and serve unsafe/unknown files as downloads.
- Never hardcode or expose secrets. Keep privileged keys on the server, use environment-specific secret storage, exclude real `.env` files from version control, and use least-privilege credentials that can be rotated.
- Make access control deny by default. Authenticate users, authorize every protected action on the server, and test both cross-user data access and low-privilege attempts to perform administrative actions.
- Use secure production configuration: HTTPS only; restrictive CORS for known origins; secure cookies when applicable (`HttpOnly`, `Secure`, and an appropriate `SameSite` value); maintained dependencies; no debug mode, sample credentials, or public development endpoints in production.
- Use safe cryptography: use standard, maintained libraries; hash passwords with Argon2id or bcrypt; never use MD5 or SHA-1 for password storage.
- Return user-safe errors with no stack traces, query details, paths, tokens, or secrets. Use purpose-specific, structured logging with explicit severity levels and destinations:
  - In production, do not write debug, security, or sensitive operational details to the browser/app console or expose them through client-facing error reporting. Keep development-only console output behind environment controls.
  - Record authentication/authorization failures, validation failures, sensitive or administrative actions, configuration changes, and unexpected errors in a protected server-side operational or security/audit log. Route security/audit events to a separate, access-controlled sink when appropriate; it must be available only to authorized operators, not application users or the public console.
  - Apply least-privilege access, encryption in transit and at rest where supported, retention/deletion policy, and alerting for meaningful repeated or high-severity events. Make audit records append-only or tamper-evident where the platform supports it.
  - Never log passwords, session IDs, tokens, API keys, authorization headers, full sensitive request bodies, or unnecessary personal data. Redact or minimize fields, use fixed structured fields/templates, and safely encode untrusted values to prevent log injection.
- Add appropriate browser security headers (at minimum a deliberate CSP, clickjacking protection, `X-Content-Type-Options: nosniff`, and HSTS after HTTPS is stable).
- Create automated tests for valid, invalid, boundary, unauthorized, and error cases. Add dependency/security scanning to CI and fix high-confidence findings before release.

Before finishing, provide a concise security checklist that maps each requirement above to the implementation and tests. Flag any requirement that cannot be completed rather than silently omitting it.
```

Related: [[Security - App Build Checklist]].
