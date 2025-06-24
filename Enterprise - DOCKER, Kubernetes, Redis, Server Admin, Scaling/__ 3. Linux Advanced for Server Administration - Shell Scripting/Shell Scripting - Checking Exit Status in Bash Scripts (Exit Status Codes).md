
**Introduction:**  
Every command in Bash returns an **exit status** (aka return code). By checking this code, you can respond to success or failure in your scripts. This is a foundational concept in shell scripting for error handling, logging, or control flow.

---

### 🔢 What Is `$?`

- `$?` stores the exit code of the **last executed command**.
    
- `0` → Command succeeded.
    
- Non-zero → An error occurred.
    

---

### 🧪 Example

```bash
#!/bin/bash

echo "Checking if directory exists..."
ls /some/path

if [ $? -eq 0 ]; then
  echo "Directory found."
else
  echo "Directory not found or error occurred."
fi
```

Or more compactly:

```bash
if ls /some/path; then
  echo "Success"
else
  echo "Failed"
fi
```

For more examples, refer to 

---

### 🚧 Why This Matters

- Prevents silent failures
    
- Helps trigger alerts or fallback logic
    
- Improves debugging and script reliability
    

---

### 🛠 Best Practices

- Check exit codes **immediately** after commands
    
- Use `set -e` in scripts to exit on first failure (for strict mode)
    
- Consider using `trap` to handle unexpected failures or cleanup
    

---

### Summary

|Exit Code|Meaning|
|---|---|
|0|Success|
|1-255|Error (depends on app)|

Using exit codes effectively makes your scripts safer, clearer, and easier to maintain.