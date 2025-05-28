
### 💻 Use Cases for a CLI-Based Emailer

- **Website Contact Form**  
    Nodemailer as the backend to email you, whether as yourself or as the visitor's gmail. If emailing as yourself, make sure the body contains the visitor's email.
    
- **Crash Alert Notifications**  
    When a fatal error occurs, a shell script is triggered that uses the CLI emailer to send an alert. The message body includes details like the error code, associated username (if available), and the exact timestamp of the incident—helpful for diagnosing issues even if the email is delayed.