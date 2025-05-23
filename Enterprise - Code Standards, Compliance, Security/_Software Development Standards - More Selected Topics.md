## 🧰 Engineering Standards: Git, Errors, and Team Conventions

This guide outlines essential team practices for Git workflows, error handling, logging, and configuration management. These standards promote consistency, collaboration, and safer production deployments.

---

## 🔀 Git Workflow & Branching

### **Understanding Roll Forward Branches**

In many workflows, a developer (e.g., John) may:

- Add multiple **feature branches over time**
- Branch off each new feature from the latest one, creating a **linear history** rather than divergent versions
- End up with a **final branch** that already includes all prior work (from older branches)— this is called a **roll forward**
    

> A **roll forward** is the latest branch that has already precluded earlier feature branches because all their commits are already included.

#### ✅ Merging Strategy

1. **Create a working branch** to combine John’s roll forward with Jane’s branch:
    
    ```bash
    git checkout -b merge-branch
    git merge feature-john
    git merge feature-jane
    ```
    
2. **Check if Jane’s branch is already included** in John’s:
    
    ```bash
    git log feature-jane ^feature-john
    ```
    
    - No output = Jane’s changes are already present in John's branch.
        
3. If no merge conflicts:
    
    - Merge the working branch into `main`:
        
        ```bash
        git checkout main
        git merge merge-branch
        ```
        
4. If there **are merge conflicts**:
    - Schedule a **merge conflict review meeting** to resolve collaboratively.

---

### 📛 Branch Naming Convention

Use a format that keeps branch names readable and sortable at Github.com:

Format:
```
YYYY.MM.DD-author-description-with-hyphens
```

Example:
```
2025.05.22-Weng-Dockerfile
```

Let's say instead you have all hyphens or periods, then it becomes a huge blur of lines at where the Branches would be:

![[Pasted image 20250523054104.png]]


---

## 🧠 Error Handling Standards

### Graceful User-Facing Errors

- Never expose stack traces or internal messages to users.
- Return clean, general error messages with a **safe error code** the user can report:
    
    ```json
    {
      "error": "Something went wrong. Please contact support with code A103."
    }
    ```
    

### Internal Error Logging

Use `try/catch` effectively so that a stack trace actually clues you into what line is the problem:
- Avoid adding unnecessary fallback messages if the `catch` already logs the problem.
- Keep responses clean and avoid duplication:
```js
app.put('/api/cache/config', async (req, res) => {
  try {
    updateConfig(req.body);
    res.json({ message: 'Cache config updated successfully' });
  } catch (error) {
    console.error('Error updating cache config:', error);
    res.status(500).json({ error: 'Failed to update cache config' });
  }
});
```

Bad because at `!success`, that error throwing is manually written, so it's not an actual runtime exception that can stack trace to the line in question:
```js
app.put('/api/cache/config', async (req, res) => {
  try {
    const success = updateConfig(req.body);
    if (!success) throw new Error('Update failed');
    res.json({ message: 'Cache config updated successfully' });
  } catch (error) {
    console.error('Error updating cache config:', error);
    res.status(500).json({ error: 'Failed to update cache config' });
  }
});
```

Even worse:
```
app.put('/api/cache/config', async (req, res) => {
  try {
    const success = updateConfig(req.body);
    if (success) {
      res.json({ message: 'Cache config updated successfully' });
    } else {
      res.status(500).json({ error: 'Failed to update cache config' });
    }
  } catch (error) {
    console.error('Error updating cache config:', error);
    res.status(500).json({ error: 'Failed to update cache config' });
  }
});
```


500-level errors can crash or disrupt a production server if not handled gracefully. Always log and respond cleanly so that the system:

1. **Stays running**
2. **Logs the error for developers**
3. **Returns a clean, helpful, and non-sensitive response to the user**

#### 🔧 Graceful Handling Includes:

|Aspect|What it means|
|---|---|
|**Catch the error**|Use `try/catch` or error middleware so that uncaught exceptions don't crash the app|
|**Log internally**|Log the full stack trace to a log file or service, not to the console in production|
|**Safe user message**|Respond with a friendly message and error code, not a crash dump or stack trace|
|**No service outage**|The app shouldn't crash or restart unless it's a fatal issue|
|**Optional: Alerting**|Trigger alerts for on-call teams if certain 500s happen repeatedly|

#### ❌ Non-graceful example:

```js
// No error handling
app.get('/api/data', (req, res) => {
  const result = databaseCallThatMayFail();
  res.send(result); // If it fails, app may crash
});
```

#### ✅ Graceful example:

```js
app.get('/api/data', async (req, res) => {
  try {
    const result = await safeDatabaseCall();
    res.json(result);
  } catch (err) {
    logToFile(err); // log detailed error
    res.status(500).json({
      error: "Something went wrong. Please contact support with code A104."
    });
  }
});
```

---

> In short: **graceful 500 handling** means the server breaks _without breaking the experience or the system_. The user gets a clear message, the dev team gets the logs, and the system stays online.

---

#### ✅ Catch Block with the 500 Error is Acceptable

A `try/catch` block **catches runtime exceptions** that happen inside the `try`. Once caught:
- The server stays up
- The code in the `catch` runs (e.g., logging, sending an error response)

### 🖐️ In reality...

In reality, we don't simply console log all errors. In production, we log to a filepath and that filepath is never hard coded (it's a env variable). But for ease of development, when NODE_ENV is not productive, then it may console log. But doing all that would increase the complexity of the examples above. We'll talk about this approach in a later section at **Logging Strategy**.

---


## 🔉 Log Levels & Safe Output

|Level|Use Case|User-Facing|Notes|
|---|---|---|---|
|Info|Debugging / performance logs|❌|For internal use only|
|Warn|Non-breaking unexpected state|❌|Avoid exposing to users|
|Error|Recoverable failure|✅|Use generic message + code|
|Fatal|Unrecoverable system failure|✅|Should not reveal system internals|

> ✅ **For `Error` and `Fatal`**:  
> Include a **reference error code** in the response. This gives the user something to report, while keeping sensitive info secure.

---

### Logging Strategy

Use environment-based logging:

```js
if (process.env.NODE_ENV !== 'production') {
  console.log('Debug info');
} else {
  logToFile(process.env.LOG_PATH, 'Debug info');
}
```

#### 🛠 Best Practices:

- Create a `.env` file with a `LOG_PATH` variable:
    
    ```
    LOG_PATH=./logs/app.log
    ```
    
- Make sure `.env` is in your `.gitignore` to avoid leaking secrets.
- Provide an `.env.example` with sample values for new developers.
- **If using Heroku**, set `LOG_PATH` under **Settings → Config Vars**.

---

## 🗂️ Error Code Naming Strategy

Use structured error codes to help debugging and improve support workflows.

### Recommended Format

```
MODULE-SEVERITY-ID
```

Examples:

- `AUTH-E-101` – Authentication error
- `DB-W-002` – Database warning
- `UI-F-900` – Fatal UI issue

Track all codes in:
- A **shared spreadsheet**
- A file in your repo (`error-codes.json`)
- Internal documentation tools like Notion or Confluence

Each code entry should include:
- Code
- User-facing message
- Technical explanation
- Suggested developer action

Example spreadsheet:

| Code  | Message                                 | Description            | Priority | Notes                        |
| ----- | --------------------------------------- | ---------------------- | -------- | ---------------------------- |
| A103  | "Something went wrong. Contact support" | Generic fallback error | Medium   | Triggered on failed writes   |
| E5001 | "Service temporarily unavailable"       | Database timeout       | High     | Escalate to DevOps on repeat |


Alternate formats:

| Pattern                    | Description                                              | Example                                      |
| -------------------------- | -------------------------------------------------------- | -------------------------------------------- |
| **Prefix + Number**        | Group similar errors by prefix, then number sequentially | `DB1001` (DB error), `AUTH2002` (Auth error) |
| **Module + Severity + ID** | Include severity for quick triage                        | `CACHE-E-001` (`E` = error, `W` = warning)   |
| **Three-letter + Number**  | Short codes for user-facing errors                       | `A103`, `B201` (generic series)              |
| **HTTP-based**             | Mirror HTTP status categories                            | `E5001`, `E4040`, `W3021`                    |

---

## ⚙️ Config Management

Use a single config file like `app.config.json` to manage environment-specific settings:

```json
{
  "development": { "apiUrl": "http://localhost:3000" },
  "staging": { "apiUrl": "https://staging.example.com" },
  "production": { "apiUrl": "https://example.com" }
}
```

This approach keeps settings clean and environment-specific.

---

## 👨‍💻 Team Conventions

Enforce consistent formatting across the team:

- Use `.editorconfig` or `.vscode/settings.json`
- Standardize:
    - Indentation (e.g., 2 spaces)
    - Tabs vs. spaces
    - EOL characters
    - Trailing newlines

Helps reduce merge conflicts and improves code readability.