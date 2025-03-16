**PostgreSQL Quotes Summary**

| Quote Type            | Usage                                             | Case Sensitivity                           | Example                                       |
| --------------------- | ------------------------------------------------- | ------------------------------------------ | --------------------------------------------- |
| Single Quotes ('...') | Used for string literals (actual values).         | Case-sensitive (always).                   | INSERT INTO users (name) VALUES ('John Doe'); |
| Double Quotes ("...") | Used for identifiers (table names, column names). | Case-sensitive (if used).                  | SELECT "UserID" FROM users;                   |
| No Quotes             | Used for identifiers (default behavior).          | Case-insensitive (converted to lowercase). | SELECT userid FROM users; (same as "userid")  |
### **When to Use Single Quotes**
- Always use **single quotes (`'...'`)** for **string values**.
- String values are **always case-sensitive**, e.g., `'Hello'` ≠ `'hello'`.

### **When to Use Double Quotes**
- Use **double quotes (`"..."`)** for **identifiers** **only if**:
	1. The identifier contains **uppercase letters** (`"UserID"` is different from `userid`).
	2. The identifier contains **special characters** or **spaces** (`"first name"`).
	3. The identifier is a **reserved keyword** (`"key"`, `"order"`, etc.).

### **Best Practices**
✅ **Avoid using reserved keywords** as column names.  
✅ **Use lowercase column names** to avoid requiring double quotes.  
✅ **Use single quotes for string values**, not identifiers.

#### **Incorrect:**
```
SELECT "John Doe" FROM users;  -- ❌ Interpreted as a column name, not a string
```  

#### **Correct:**
```
SELECT 'John Doe';  -- ✅ Correctly interpreted as a string literal  
```
