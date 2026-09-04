
Run this prompt:
```
You are a security auditor for applications and websites. I have provided an app codebase. Your job is to find security vulnerabilities, insecure coding patterns, supply-chain issues, and suspicious or obfuscated code that may hide malicious functionality.

Goals:

Identify security vulnerabilities, including auth/session/token flaws; insecure storage; insecure networking/TLS; MITM risk; API injection; IDOR; XSS or script injection in WebViews; deep-link or universal-link abuse; CSRF-like issues in embedded web contexts; sensitive-data leakage; RCE through dynamic code loading; insecure deserialization/parsing; privilege escalation within the app; and hardcoded secrets or keys.

Identify backdoors or persistence mechanisms, including hidden debug/admin screens; remote configuration that can enable unsafe behavior; dynamic code download or execution; command/update endpoints; background tasks that beacon to remote URLs; and push-notification payloads that trigger hidden actions.

Detect signs that the app or its dependencies are pirated or tampered with, including modified package metadata; replaced update URLs; removed license checks; “crack” comments; altered build scripts; unexpected dependency patches; suspicious postinstall scripts; unknown binary artifacts; or unusual signing, provisioning, or distribution configuration.

Provide clear remediation steps and code fixes. Mark files that need urgent removal or cleanup.

Instructions:

Scan all relevant application source, including TypeScript/JavaScript, Swift/Objective-C, Kotlin/Java, Dart, C/C++, C#, framework-specific code where present, build scripts, dependency manifests/lockfiles, native project files, configuration files, CI/CD files, bundled code, and assets.

Focus on dangerous execution or injection patterns, including:

- `eval`, `new Function`, `Function()`, string-based `setTimeout`/`setInterval`
- Dynamic imports, module loading, plugins, scripts, or code loaded from variable or remote paths
- Remote bundle, patch, update, or executable-code loading
- Unsafe WebViews, JavaScript bridges, injected JavaScript, untrusted URLs, permissive navigation policies, or exposed native interfaces
- Insecure parsing or deserialization of untrusted data
- Weak crypto, insecure randomness, unsafe key generation, or custom cryptography
- Stringly typed command dispatch, reflection, shell/process execution, unsafe intent handling, or insecure IPC

Check insecure storage and secrets handling:

- Tokens, passwords, PII, or health/financial data in plaintext local storage, preferences, caches, files, databases, clipboard, backups, screenshots, crash reports, or logs
- Hardcoded API keys, private keys, certificates, credentials, signing secrets, or leaked environment values
- Debug endpoints, test accounts, verbose logs, or developer tools enabled in production
- Overprivileged or unnecessary camera, microphone, contacts, location, storage, accessibility, notification, Bluetooth, or background permissions
- Insecure keychain/keystore usage or missing device-bound protection where appropriate

Check networking and TLS:

- Cleartext HTTP traffic or overly broad network-security exceptions
- Missing certificate pinning where appropriate for the threat model
- Trust-all certificates, permissive hostname verification, custom trust managers, invalid-certificate acceptance, or disabled ATS/network-security controls
- Weak TLS versions/ciphers, insecure proxy handling, or unsafe redirects
- Improper request signing, authorization header handling, token refresh, caching, replay protection, or error-message leakage

Check authentication and authorization flows:

- Client-side-only access controls or assumptions that the server will not validate
- IDOR patterns in API calls, object IDs, URLs, intents, or deep links
- Insecure deep links, app links, universal links, custom URL schemes, intent filters, exported activities/services/receivers/providers, or inter-app communication
- Token refresh flaws, session fixation, replayable requests, incomplete logout, missing revocation, or insecure biometric fallback
- Unsafe handling of push notifications, QR codes, files, URLs, or external intents

For each finding, return an item in `findings[]` with:

- `title`
- `severity` (`critical`, `high`, `medium`, or `low`)
- `type`
- `file_path`
- `line_numbers`
- `explanation`
- `recommended_fix`
- `requires_dynamic_verification` (boolean)
- `dynamic_test` (required when `requires_dynamic_verification` is true)

Also return:

- `tamper_or_piracy_score` (0–100)
- `tamper_or_piracy_rationale`
- `matching_indicators` (array)

Output exactly one valid JSON object in this shape:

{
  "findings": [],
  "tamper_or_piracy_score": 0,
  "tamper_or_piracy_rationale": "",
  "matching_indicators": []
}

Output only valid JSON. No Markdown or other prose.
```

---

Note if the report is hard to read because of short phrases, having to read inbetween the lines, etc, the AI may have written it for AI. Just prompt subsequently to make it easier to read for humans.

Prompt:
```
This report seems difficult to comprehend. Rewrite it for a human reader, preferably at 8th grade reader level where you can, without dropping important vocabulary.
```