# Security - App Build Checklist

Use this as a practical baseline when building or reviewing an app. It distills the security and reliability practices from [10 Codex Tips to Avoid Generating Insecure or Buggy Code](https://medium.com/@bhagyarana80/10-codex-tips-to-avoid-generating-insecure-or-buggy-code-a7705a911d48), with implementation detail aligned to the OWASP Cheat Sheet Series.

## 1. Validate data at every trust boundary

- Validate requests on the server, even when the client validates them too.
- Parse safely, apply request-size limits, then validate schema, types, ranges, required fields, and allowed values before processing or storing data.
- Use allowlists where practical; do not try to make untrusted data safe by merely stripping characters.
- Encode output for its context (HTML, URL, JavaScript, etc.). Validation is not a substitute for output encoding.
- Treat uploaded filenames, MIME types, and file contents as untrusted. Apply size and content checks, store uploads safely, and serve unknown files as downloads rather than executable inline content.

See [[Requests - Multiple Layers of Request Errors - JSON, Payload Shape, and Signature Validation]].

## 2. Prevent injection

- Use parameterized queries or an ORM/query builder that binds values; never concatenate untrusted values into SQL.
- For dynamic query identifiers or sort directions, choose only from application-owned allowlists.
- Avoid shelling out with user input. If unavoidable, use an API that does not invoke a shell, allowlist the command and arguments, and validate every argument.
- Keep database and service accounts least-privileged so a compromise has limited blast radius.

## 3. Keep secrets out of source and clients

- Never hardcode passwords, API keys, tokens, private keys, or connection strings.
- Never put privileged secrets in browser or mobile-client code; route privileged operations through the backend.
- Store secrets in environment-specific secret storage or a managed vault, use separate credentials per environment, and keep real `.env` files out of Git.
- Give people and workloads distinct, least-privilege credentials. Monitor use, revoke leaked credentials, and make rotation routine and fast.

See [[API Key Best Practices]] and [[_Software Development Standards - Team Environment and App Configs]].

## 4. Use secure configuration and defaults

- Deny by default: require authentication and authorization for every protected action; check authorization separately from validation.
- Restrict CORS to the specific trusted origins, methods, headers, and credentials behaviour the app needs. Do not deploy `*` as a convenience default.
- Use HTTPS in production, redirect HTTP to HTTPS, and avoid mixed content.
- Use maintained dependencies and secure primitives: use a modern password hash such as Argon2id or bcrypt, never MD5/SHA-1 for passwords.
- Set appropriate security headers, especially a deliberate Content Security Policy, `frame-ancestors`/`X-Frame-Options`, `X-Content-Type-Options: nosniff`, and HSTS once HTTPS is stable.
- Disable debug mode and sample credentials in production. Do not expose directory listings, admin tools, or development-only endpoints.

## 5. Handle failures safely and observably

- Return consistent, user-safe errors. Do not expose stack traces, query details, paths, secrets, or internal implementation details.
- Log structured events for authentication failures, authorization denials, validation failures, sensitive actions, configuration changes, and unexpected errors.
- Do not log passwords, session tokens, API keys, authorization headers, or full sensitive request bodies. Escape or structure untrusted log fields to prevent log injection.
- Protect logs from public access, centralize them when appropriate, retain them according to policy, and alert on meaningful repeated or high-severity events.

See [[_Software Development Standards, Runtime - Error Handling]] and [[_Software Development Standards, Runtime - Logging]].

## 6. Test security and reliability before release

- Write automated happy-path, boundary, malformed-input, and unauthorized-access tests.
- Test authorization for both horizontal access (one user reading another user's data) and vertical access (a low-privilege user performing an admin action).
- Test error responses to confirm they contain no sensitive detail and test that logs do not contain secrets.
- Benchmark and profile critical paths with realistic data and concurrency; do not assume a working implementation will scale safely.
- Run dependency and static security scanning in CI, resolve meaningful findings, and update vulnerable dependencies promptly.

## Release review

Before production, confirm:

- [ ] All server inputs have size limits and schema/semantic validation.
- [ ] SQL, commands, and templates keep untrusted data separate from instructions.
- [ ] No secrets are in source, client bundles, examples, logs, or error responses.
- [ ] Authentication, authorization, CORS, transport security, and browser security headers are intentionally configured.
- [ ] Production errors are safe to users and actionable to operators.
- [ ] Security, authorization, and error-handling tests pass; dependencies have been scanned.

## References

- [Source article: 10 Codex Tips to Avoid Generating Insecure or Buggy Code](https://medium.com/@bhagyarana80/10-codex-tips-to-avoid-generating-insecure-or-buggy-code-a7705a911d48)
- [OWASP Input Validation Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Input_Validation_Cheat_Sheet.html)
- [OWASP SQL Injection Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html)
- [OWASP Secrets Management Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Secrets_Management_Cheat_Sheet.html)
- [OWASP Logging Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Logging_Cheat_Sheet.html)
