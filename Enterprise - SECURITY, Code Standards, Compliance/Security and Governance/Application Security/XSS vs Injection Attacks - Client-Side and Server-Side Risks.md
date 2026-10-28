Cross-site scripting (XSS) is a specific type of injection attack that targets a web page's execution context in the user's browser. Injection is the broader vulnerability category: untrusted input is interpreted as instructions by an interpreter, such as a SQL database, operating-system shell, template engine, or browser.

The simplest distinction is:

- **XSS usually executes in the client:** malicious HTML or JavaScript runs in a victim's browser under the affected site's origin.
- **Other common injection attacks usually execute on the server:** malicious input changes a database query, system command, template, or another backend operation.

XSS is therefore not separate from injection. It is a browser-focused subtype with different execution contexts, consequences, and primary defenses.

## Key differences

| Feature | Cross-Site Scripting (XSS) | Other injection attacks (for example, SQL injection) |
|---|---|---|
| **Primary target** | Client-side browser and the affected site's users | Server-side interpreters such as databases, operating-system shells, and template engines |
| **Common language or payload** | JavaScript, HTML, or other browser-interpreted content | SQL, shell commands, template syntax, LDAP queries, or another interpreter's syntax |
| **How it works** | Untrusted content is inserted into a page and interpreted as executable browser content | Untrusted input changes the structure or meaning of a query, command, or expression |
| **Where it executes** | In a victim's browser, usually with the affected site's origin and permissions | In a backend interpreter or service with the application's privileges |
| **Typical impact** | Session theft, account actions as the victim, data exfiltration, page modification, phishing, or malicious redirects | Reading, modifying, or deleting backend data; bypassing authorization; executing server commands; or compromising connected systems |
| **Blast radius** | Often affects individual users who view or interact with the malicious content, though stored XSS can affect many users | Can affect an entire database, application, server, or downstream environment, depending on service privileges |
| **Primary defenses** | Context-aware output encoding, safe DOM APIs, HTML sanitization when HTML is allowed, and Content Security Policy (CSP) as defense in depth | Parameterized queries, structured APIs that keep data separate from instructions, allowlists for non-parameterizable values, strict input validation, and least privilege |

## The shared root cause

Both vulnerabilities cross the same trust boundary: data is allowed to become executable instructions.

```text
Untrusted input + unsafe interpreter context = injection vulnerability
```

The important question is not merely whether input was validated. It is whether the application keeps untrusted data separate from the syntax interpreted by the destination.

## Example: XSS

An application renders a user-supplied display name directly into HTML:

```html
<p>Welcome, <script>/* malicious code */</script></p>
```

If the browser interprets that value as markup rather than text, the script can run in the site's security context.

The application should use the framework's safe text-rendering behavior or context-appropriate output encoding. If users are intentionally allowed to submit HTML, the HTML must be sanitized with a well-maintained sanitizer. A restrictive CSP can reduce impact but does not replace safe rendering.

## Example: SQL injection

An application constructs a query by concatenating user input:

```text
SELECT * FROM users WHERE email = '<user input>'
```

Specially crafted input can change the query's meaning because the database cannot distinguish the intended value from SQL syntax.

The application should use a parameterized query or prepared statement so the query structure and the user-provided value are sent separately.

## Defense rule of thumb

- When sending data to **HTML, an attribute, a URL, JavaScript, or CSS**, encode it for that exact output context and prefer APIs that treat it as text.
- When sending data to a **database, shell, template engine, or another interpreter**, use parameterization or a structured API that prevents data from becoming instructions.
- Validate input at trust boundaries, but do not treat validation as a substitute for output encoding or parameterization.
- Limit privileges and use defense-in-depth controls to reduce the impact if a primary control fails.

See also [[Security - App Build Checklist]].
