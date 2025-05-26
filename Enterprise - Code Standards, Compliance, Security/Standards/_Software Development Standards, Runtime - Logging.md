### 🔉 Log Levels & Safe Output (Local and Staging Servers)

| Level | Use Case                          | User-Facing | Console | File Log | Notes                                    |
| ----- | --------------------------------- | ----------- | ------- | -------- | ---------------------------------------- |
| Info  | General app activity              | ❌           | ✅       | ✅        | Internal-only event messages             |
| Warn  | Unexpected but non-breaking state | ❌           | ✅       | ✅        | Log and review for trends                |
| Error | Recoverable failure               | ✅           | ❌*      | ✅        | Generic message + internal log           |
| Fatal | Unrecoverable system failure      | ✅           | ❌*      | ✅        | App stays up; user sees fallback message |

> \* In production, `console` output for `error` and `fatal` levels is either disabled or replaced with a generic message like `"Error occurred. Please see logs."` This prevents exposing sensitive stack traces and keeps terminals clean—since full error details are easier to read and navigate in a log file using a text editor (or a cli text editor like vim).  Logging a simple message to the console can still be helpful during development or automated testing, especially when there's no user-facing UI to alert the developer to the error.  


Guidelines:
> ✅ Show simple, user-friendly error messages to users, and keep full technical details in internal logs for developers.  
> ✅ In development, console logs are helpful since developers usually have the terminal open while coding and testing in real time.
> ✅ In production, logs should go to files, which developers can review later as needed without exposing internal details to users. 
> ✅ In production, fatal errors should trigger alerts to developers—such as an email, text message, or notification—so they're aware of critical issues immediately.
> ✅ Returning a graceful error message with a reference code keeps the experience professional and non-technical for the user, while still giving developers a traceable identifier to debug the issue.
> ✅ Log file paths may vary across environments—for example, between macOS and a production Linux server. To handle this consistently, add a configurable layer (e.g., `environments.config.json`) to define environment-specific paths.


#### 🚫 Production Mode (`NODE_ENV === 'production'`)

- **All levels** → **file only**
- **No console logging**
- Ensures no sensitive data leaks to terminal, browser, or error pages

Here's an example logging utility Winston for NodeJS. Notice that we check if the environment is production or not before console logging.
```js
const winston = require('winston');

const transports = [];
if (process.env.NODE_ENV !== 'production') {
  transports.push(new winston.transports.Console());
}
transports.push(new winston.transports.File({ filename: process.env.LOG_PATH || 'logs/app.log' }));

const logger = winston.createLogger({
  level: process.env.LOG_LEVEL || 'info',
  format: winston.format.json(),
  transports
});

module.exports = logger;
```

---

### 🔐 Why No `console.log()` in Production?

`console.log()` in production is dangerous:

|Risk|Explanation|
|---|---|
|🔍 Leaks sensitive data|Stack traces, tokens, user info may be exposed via logs|
|🌐 Visible to attackers|Browser `console` or public error pages may reveal debug info|
|📦 Accidental exposure|Hosting platforms or logs may surface unfiltered console output|
|🧨 Exploitable crash traces|Poorly handled exceptions may expose last console messages in 500 pages|
|🧪 DevTools analysis|Frontend logs are easily scraped or reverse-engineered from browser devtools|

> In short: `console.log()` in production gives attackers clues. Always route logs to protected files instead.

---

### ✅ Use `.env` for Logging Paths

```env
NODE_ENV=production
LOG_LEVEL=info
LOG_PATH=./logs/app.log
```

- Keep `.env` in `.gitignore`
    
- Share `.env.example` for onboarding
    
- On platforms like Heroku, set these in Config Vars
    

---

### 📦 Log File Security Best Practices

- Place logs **outside the app folder** if possible.
    
- If inside the app, block access:
    

**NGINX:**

```nginx
location ~* /logs/ {
  deny all;
}
```

**Apache (.htaccess):**

```apache
<Directory "/path/to/app/logs">
  Deny from all
</Directory>
```

- Git-ignore all logs:
    

```gitignore
logs/
*.log
```

---

### 🧰 Logging Libraries

#### Node.js – Use `Winston`

```js
const winston = require('winston');

const transports = [];
if (process.env.NODE_ENV !== 'production') {
  transports.push(new winston.transports.Console());
}
transports.push(new winston.transports.File({ filename: process.env.LOG_PATH || 'logs/app.log' }));

const logger = winston.createLogger({
  level: process.env.LOG_LEVEL || 'info',
  format: winston.format.json(),
  transports
});

module.exports = logger;
```

#### Python – Use `logging` or `loguru`

Logging:
```python
import logging

logging.basicConfig(
    level=logging.INFO,
    format="%(asctime)s - %(levelname)s - %(message)s",
    handlers=[
        logging.StreamHandler(),
        logging.FileHandler("app.log")
    ]
)
logger = logging.getLogger("app")
logger.info("Info log")
logger.error("Error log")
```

Loguru:
```
from loguru import logger

# Configure loguru to log to a file
logger.add("logs/app.log", rotation="1 MB", retention="7 days", level="INFO", format="{time} {level} {message}")

# Usage examples
logger.debug("This is a debug message")
logger.info("User logged in successfully")
logger.warning("Disk space running low")
logger.error("Failed to connect to database")
logger.critical("System crash: shutting down")

# Exception logging
try:
    1 / 0
except ZeroDivisionError:
    logger.exception("An error occurred")

```

### Weng's Error Logger Utility

Checkout Weng's error logging utility for NodeJS at:
https://github.com/Siphon880gh/error-logger

---
### Key Point

✅ A strong logging and error handling system protects your users, simplifies debugging, and hardens your application.
