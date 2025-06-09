To support multiple environments (development, staging, production) while keeping sensitive information secure, follow these best practices for managing environmental variables and app configuration.

---

## 🌱 Environmental Variables Management

To manage environment-specific and machine-specific settings securely and consistently across team members and servers, here are two recommended approaches:

### ✅ Standard Approach with Multiple `.env.*` Files

- **Never commit real `.env.*` files.**  
    Add this to `.gitignore`:
    ```bash
    .env*
    ```

- **Split files by context or stage**:
    - `.env.dev` – for shared development environment variables
    - `.env.staging` – for pre-production or QA environments
    - `.env.production` – for final production values
    
- **Use `.env.ENV_TYPE.example`** files (`.env.dev.example`, `.env.production.example`) to document required variables without exposing secrets.

- **Optional:** Use `.env.local` for developer- or machine-specific overrides (e.g., log paths, local database)

### 🧩 Alternate Simpler Scheme: Fewer Env Files

In smaller teams or simpler projects, this streamlined alternative may be easier to maintain:

|File|Purpose|
|---|---|
|`.env`|Shared values for **both development and deployment environments**|
|`.env.local`|Developer- or machine-specific overrides(e.g., local DB, log path)|
Example Use Case:
- `.env` may include `API_URL=https://dev-api.example.com`
- `.env.local` on your machine overrides with `API_URL=http://localhost:3000`

### 🧩 Alternate Simpler Scheme: `.env.shared` for Monorepos

If you're working in a **monorepo** with many nested sub-projects:
- Create a top-level `.env.shared` that includes global/shared variables.
- Each subproject can reference or generate its own `.env` using a build step that merges `.env.shared` into it.

> This lets you centralize common variables like `NODE_ENV`, `ORG_NAME`, or `BASE_DOMAIN`, while still allowing per-project customization.


---

## ◾️ Why sh files and how to fix their executable permissions

In an enterprise environment, team members may need to run `.sh` files from their local copy of the repository. Shell scripts are often more portable and consistent than `npm` or Python scripts for setting up the workspace—especially when everyone is using the same Dockerized operating system (Eg. Debian).

If you are the one developing the .sh shell scripts, you can ask ChatGPT to adapt it to the target OS that everyone will use — for example, _“Make sure this shell script works for Debian.”_ Then, ensure all team members or environments spin up using that same OS image (e.g., Debian or Ubuntu) to avoid compatibility issues. AWS lets you spin up instances with the same operating system every time, which makes environment consistency much easier in production as well.

However, the sh files don't retain their executable permissions. A `Makefile` can help automate `chmod u+x` so the scripts become runnable right away.

Here's a basic `Makefile` that applies `chmod u+x` to all `.sh` scripts in the current directory (or recursively):

#### **Option 1: For all `.sh` files in the current directory**

Makefile:
```
.PHONY: setup  
  
setup:  
	chmod u+x *.sh
```

#### **Option 2: Recursive (subdirectories too)**

Makefile:
```
.PHONY: setup  
  
setup:  
	find . -name "*.sh" -exec chmod u+x {} \;
```

#### 🛠 Usage

Run:
```
make setup
```

---

### 🛠️ App Configuration Management

Use a structured JSON config file (e.g., `app.config.json`) to centralize non-sensitive, environment-specific settings:

```json
{
  "development": {
    "apiUrl": "http://localhost:3000",
    "enableConsoleLog": true,
    "logFilePath": "process.env.LOG_FILEPATH_DEV"
  },
  "staging": {
    "apiUrl": "https://staging.example.com",
    "enableConsoleLog": false
  },
  "production": {
    "apiUrl": "https://example.com",
    "enableConsoleLog": false
  }
}
```

**Benefits:**
- Keeps logic for switching environments clean
- Makes app behavior predictable across environments
- Avoids hardcoding machine-specific paths

#### 🧠 Tip: Dynamic Environment Variable Parsing

If you want the app config file to support dynamic values from the environment (like log file paths), you can adopt a convention like:

```json
"logFilePath": "process.env.LOG_FILEPATH_DEV"
```

Then, in your config loader:

1. Check if a value matches the pattern `process.env.XYZ`.
2. Extract the variable name (`XYZ`).
3. Read it from `process.env.XYZ`.

🛠 Example: `loadConfig.js`
```
const fs = require('fs');
const path = require('path');

/**
 * Recursively resolve "process.env.VAR_NAME" values in a config object.
 */
function resolveEnvRefs(obj) {
  if (typeof obj === 'string') {
    const match = obj.match(/^process\.env\.([A-Z0-9_]+)$/i);
    if (match) {
      const envVar = match[1];
      return process.env[envVar] || null;
    }
    return obj;
  }

  if (Array.isArray(obj)) {
    return obj.map(resolveEnvRefs);
  }

  if (typeof obj === 'object' && obj !== null) {
    const resolved = {};
    for (const key in obj) {
      resolved[key] = resolveEnvRefs(obj[key]);
    }
    return resolved;
  }

  return obj;
}

/**
 * Load and parse the config file for a given environment.
 */
function loadAppConfig(env = 'development') {
  const configPath = path.resolve(__dirname, 'app.config.json');

  if (!fs.existsSync(configPath)) {
    throw new Error(`Missing config file: ${configPath}`);
  }

  const raw = JSON.parse(fs.readFileSync(configPath, 'utf8'));

  if (!raw[env]) {
    throw new Error(`No config found for environment: ${env}`);
  }

  return resolveEnvRefs(raw[env]);
}

// Example usage:
const config = loadAppConfig(process.env.NODE_ENV || 'development');
console.log(config);
```

This adds flexibility while keeping your config format consistent and readable.