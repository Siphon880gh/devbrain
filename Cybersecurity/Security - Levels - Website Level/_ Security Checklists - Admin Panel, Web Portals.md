To harden security for web portals like **cPanel**, here are key steps, including tunneling:

---

### 🔒 Basic Hardening Steps for cPanel or Similar Web Portals:

1. **Use Tunneling (SSH Port Forwarding):**

   * Disable direct web access (e.g., block port 2083) from the internet.
   * Instead, use SSH to tunnel:

     ```bash
     ssh -L 2083:localhost:2083 user@yourserver.com
     ```
   * Then access cPanel via `https://localhost:2083` on your local browser.

2. **Enforce HTTPS:**

   * Always access via `https://`, ideally with a valid SSL certificate.
   * Enable **HSTS** headers to force HTTPS.

3. **Use IP Whitelisting + Firewall:**

   * Allow access to the cPanel port only from specific IP addresses.
   * Use `csf`, `ufw`, or AWS/GCP firewalls.

4. **Enable Two-Factor Authentication (2FA):**

   * Add 2FA to the login for extra protection.

5. **Disable Unused Services & Ports:**

   * Turn off unnecessary cPanel features or plugins.
   * Close unused network ports.

6. **Limit Login Attempts / Fail2Ban:**

   * Prevent brute-force attacks by blocking repeated failed login attempts.

7. **Keep cPanel Updated:**

   * Regularly update to patch vulnerabilities.

8. **Use Strong Passwords:**

   * Enforce password policies for all users.
