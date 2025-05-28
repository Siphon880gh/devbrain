#### 🟢 **Normally**

- Your backend sends emails as users submit forms in real time. It validates and sanitizes in the input before sending to your email. To protect against malicious hackers, you prevent the same IP address from sending too many form submissions in a short time.
- Alternatively, instead of real-time delivery, you can **throttle submissions**:
	- Form submission saved to persistent storage (appended file, database, etc)
	- Run cron job periodically to check the persistent storage (e.g., hourly)
	- Filter spam or duplicate submissions
	- Send those emails to yourself, but spaced out to avoid deliverability penalties

---

#### 🟡 **For Low-Traffic Sites with Limited Dev Time**

If you're short on development time and traffic is minimal, you can take some shortcuts (but be prepared to upgrade this setup later as traffic grows):

**🔁 Skip Real-Time Processing**  
Instead of validating and emailing each submission on the spot, save it as a **timestamped text file** to a specific folder via a simple backend script. A **cron job** can run every 6 hours to check for files created within that timeframe and send you an **alert email** if any are found.

**⚡ Simpler Option: Skip Timestamp Filtering**  
If you're in a rush, you can **skip checking timestamps** entirely. Just configure the cron job to notify you **whenever any text files are present**—reminding you to review and clear them from the server.

But a caveat if taking these shortcuts:

**🛡️ Avoid Sending Submission Content via Email with these Shortcuts**
Since you are saving time by saving the form submissions to text files, likely you are skipping sanitization too. In this case, never email the text files or their content directly to your mailbox. Just have your email message be to check the text folder for submissions. Review the submissions by opening the saved text files via **FTP, terminal, or a web browser with indexing enabled**.