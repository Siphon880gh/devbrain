I'm self-hosting a web app and want to avoid relying on platforms like Heroku, which offer built-in protections for environment variables. Since I'm managing .env files myself, I'm concerned about potential vulnerabilities—such as Local File Inclusion (LFI), OS command injection, or accidental directory listing—that could expose sensitive environment data.

To reduce risk, I'm considering the following strategies:
- Avoid naming the file .env, .env.local, or any other common/default names.
    - *Explanation: Not naming the file `.env` makes it less discoverable in case of directory traversal or LFI attacks.*
- Store the file in a non-obvious directory (not named env, secrets, or config) to make it harder to guess or access if directory listing is enabled.
    - *Explanation: A non-obvious folder name helps reduce exposure from misconfigured directory listings or simple brute-force guessing.*
- Ensure that the app (e.g., PHP, Python, Node.js) explicitly loads the custom directory for environmental variables.
    - *Explanation: Having your app load the environment variables from a specific, isolated path gives you control and traceability.*
- Place a blank index.html file in that directory as a fallback in case directory listing is ever left on during a future server migration.


---

### 🔐 Additional Best Practices You Should Consider

1. **Web Server-Level Protections (Highly Recommended)**
    
    - **Deny access to  the custom env directories** entirely in Nginx or Apache:

        ```nginx
        location ~* /(your-secret-dir|.*\.env) {
            deny all;
        }
        ```
        
        ```apache
        <Directory "/var/www/your-secret-dir">
            Require all denied
        </Directory>
        <FilesMatch "^\.env">
            Require all denied
        </FilesMatch>
        ```
        
    - This works even if the file exists and directory listing is on.
        
2. **File Permissions**
    
    - Use **least privilege**: ensure that only the app process can read the file (e.g., `chmod 400` and owned by the web app user).
        
3. **Avoid Serving `.env` Files from Public Web Roots**
    
    - Never place `.env` or config files anywhere within a directory that could be served by the web server.
    - This may be more difficult to manage if you have multiple wep apps each using .env files and you wish the env file stays within the app folder to make migration easier.
    
        
4. **PHP/Python Security**
    
    - Sanitize all user input—LFI attacks usually rely on unvalidated file names.
    - Disable dangerous functions like `eval`, `system`, `exec`, or sandbox them carefully.
        
6. **Use Environment Variables at the OS Level (if viable)**
    
    - For production, consider:
        - Defining env vars in `systemd` unit files
	        - Per [[Secure Environment Variable Management for Modern Web Apps]]
	        - Besides systemd level, there are adjacent levels you can use.
	        - Unfortunately if you have multiple web apps using env files, it becomes difficult to manage (systemd or the adjacent levels).
        - Using Docker secrets            


---

### 🧩 Best Practice: Use `.env.example`

- Always include a `.env.example` with placeholder values to aid team onboarding—but never the real `.env` in Git.
- This balances quick orientation to the app's secret with security.
