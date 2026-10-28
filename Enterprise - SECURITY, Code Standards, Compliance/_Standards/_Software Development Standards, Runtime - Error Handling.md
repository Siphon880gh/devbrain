### 🧠 Error Handling Standards

#### Graceful User-Facing Errors
- Never expose stack traces or internal messages to users.
- Always return a clean, user-friendly message with a **reference error code**:

```json
{
  "error": "Something went wrong. Please contact support with code A103."
}
```

---

#### Internal Error Logging

Use `try/catch` blocks to ensure runtime exceptions are logged and traceable:

##### ✅ Good Practice

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

##### ⚠️ Anti-pattern: Artificial Error Injection
- Masks the _real cause_ and _real location_ of the failure — because you're manually creating a generic error, rather than allowing a true exception to be captured with its original stack trace.
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

##### ❌ Worse: Unreachable exception
- Manually handles failure using an `if/else` block without letting actual exceptions throw, which means the `catch` block is only triggered if something unexpectedly crashes.

```js
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

---

### 🔐 Secure and Graceful 500 Handling

500-level errors can disrupt servers. A well-designed handler ensures:

1. ✅ The system **keeps running**
2. ✅ Logs are written for developers
3. ✅ Users get a **safe, helpful message**

#### 🔧 Graceful Handling Includes:

|Aspect|Description|
|---|---|
|**Catch the error**|Use `try/catch` or middleware to handle exceptions|
|**Log internally**|Write stack traces to a secure file or error tracking service|
|**Clean response**|Never expose raw errors; give users a reference code|
|**Stay online**|Don’t let exceptions crash the app|
|**Optional alerting**|Alert DevOps if 500s occur frequently|

#### ❌ No Handling = App Crash

```js
app.get('/api/data', (req, res) => {
  const result = databaseCallThatMayFail();
  res.send(result);
});
```

#### ✅ Proper Handling = Stability

```js
app.get('/api/data', async (req, res) => {
  try {
    const result = await safeDatabaseCall();
    res.json(result);
  } catch (err) {
    logToFile(err);
    res.status(500).json({
      error: "Something went wrong. Please contact support with code A104."
    });
  }
});
```

---

### 🗂️ Error Code Naming Strategy

Use structured error codes to streamline support, triage, and debugging.

#### Suggested Format

```
MODULE-SEVERITY-ID
```

Examples:

- `AUTH-E-101` – Authentication error
- `DB-W-002` – Database warning
- `UI-F-900` – UI failure

#### Track Your Codes In:

- A **shared spreadsheet**
- `error-codes.json` file
- `error-codes.csv` file
- Notion or Confluence


##### Examples Formats

Full format:

| Code        | Message                                 | Description            | Priority | Notes                        |
| ----------- | --------------------------------------- | ---------------------- | -------- | ---------------------------- |
| AUTH-E-103  | "Something went wrong. Contact support" | Generic fallback error | Medium   | Triggered on failed writes   |
| SERV-F-5001 | "Service temporarily unavailable"       | DB timeout             | High     | Escalate to DevOps on repeat |


Short format that doesn't have severity level (Your logging utility could look at the Severity column of your spreadsheet to determine whether to console log or to log file):

| Code  | Severity | Message                                 | Description            | Priority | Notes                        |
| ----- | -------- | --------------------------------------- | ---------------------- | -------- | ---------------------------- |
| A103  | Error    | "Something went wrong. Contact support" | Generic fallback error | Medium   | Triggered on failed writes   |
| S5001 | Fatal    | "Service temporarily unavailable"       | DB timeout             | High     | Escalate to DevOps on repeat |

More formats:

| Pattern                | Description               | Example               |
| ---------------------- | ------------------------- | --------------------- |
| Prefix + Number        | `DB1001`, `AUTH2002`      | Groups similar codes  |
| Module + Severity + ID | `CACHE-E-001`, `UI-W-003` | Clear triage levels   |
| Shortcode + Number     | `A103`, `B201`            | User-friendly         |
| HTTP-based Style       | `E5001`, `W3021`          | Mirrors HTTP statuses |

---

### Weng's Error Logger Utility

Checkout Weng's error logging utility for NodeJS at:
https://github.com/Siphon880gh/error-logger

---
### Key Point

✅ A strong logging and error handling system protects your users, simplifies debugging, and hardens your application.

---

### 🔒 Do not leak implementation details

Safe user-facing errors must not reveal stack traces, SQL/query details, filesystem paths, hostnames, tokens, session identifiers, configuration values, or whether a particular account/resource exists when that information is sensitive.

Return a stable, generic message and a reference code. Keep diagnostic context in protected internal logs, with secrets redacted.

### ✅ Test failures as part of the API contract

Automated tests should verify that malformed input, unauthorized access, forbidden actions, and unexpected server failures:

- return the intended status and stable error shape;
- do not include sensitive implementation detail; and
- produce the expected internal log or alert without logging secrets.
