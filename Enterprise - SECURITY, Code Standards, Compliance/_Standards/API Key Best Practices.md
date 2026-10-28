
**1. Use a Unique API Key for Each Team Member**  
Each API key is a unique identifier tied to a specific user. These keys are meant to be used individually and should not be shared. Sharing API keys can violate usage policies and compromise security.

When adding team members, invite them through your platform’s account management system so they receive their own API key. This also allows you to assign individual permissions and track usage by user.

---

**2. Never Expose API Keys in Client-Side Code**  
Avoid placing API keys in frontend environments like browsers or mobile apps. Doing so allows others to view and misuse the key, which can lead to unauthorized usage, unexpected charges, or security breaches. All API requests should be routed through a secure backend server where keys are kept private.

---

**3. Don’t Commit API Keys to Code Repositories**  
Including API keys in your source code—especially in public repositories—is one of the most common ways they get leaked. Even private repos can be vulnerable to breaches. Use environment variables to store keys securely and keep them out of version control.

---

**4. Use Environment Variables to Store API Keys**  
Environment variables are system-level variables that keep sensitive data out of your codebase. Define a variable such as `API_KEY` and store your actual key as its value. This approach improves security and makes it easier for teams to collaborate without risking key exposure.

---
**5. Use a Key Management Service**  
To protect sensitive credentials, consider using a key management service (KMS) designed for securely storing and controlling access to API keys and other secrets. These tools encrypt your keys and store them separately from your application, reducing the risk of exposure in the event of a breach.

For production environments, adopting a KMS is a best practice to enhance your application’s security posture and maintain better control over who can access sensitive credentials.

---

**6. Monitor API Usage and Rotate Keys When Necessary**  
A leaked or compromised API key can give unauthorized users access to your account, leading to excessive usage, data exposure, unexpected charges, or service disruptions.

To maintain security:

- Regularly review usage data to ensure it aligns with your team’s activity.
    
- If your system supports multiple teams or environments, ensure each key is tracked and associated with the appropriate context.
    
- If you suspect a key has been exposed or misused, rotate it immediately and update your application with the new value.
    

Routine auditing and proactive key rotation can help mitigate risks and ensure continuous service availability.

---

Kubernetes supports rotating API keys and secrets as a security best practice. Rotating keys involves replacing old keys with new ones periodically to ensure data security.

---

## 7. Use least privilege and separate credentials

Use a different credential for each person, workload, service, environment, and integration where practical. Grant only the permissions needed for the task; do not give a client, CI job, or background worker an administrator-level key by default.

Separate development, staging, and production credentials so an incident in one environment cannot automatically expose another. Record the owner, purpose, permitted scope, and expiry/rotation procedure for each production credential.

---

## 8. Detect leaks and keep secrets out of logs

- Run secret scanning in local hooks and CI to catch accidental commits before release.
- Treat a committed secret as exposed: revoke or rotate it rather than only deleting it from the latest file revision.
- Never write API keys, passwords, session tokens, private keys, connection strings, or `Authorization` headers to logs, error reports, screenshots, or support tickets.
- Redact sensitive fields before sending diagnostic data to third-party monitoring tools.
