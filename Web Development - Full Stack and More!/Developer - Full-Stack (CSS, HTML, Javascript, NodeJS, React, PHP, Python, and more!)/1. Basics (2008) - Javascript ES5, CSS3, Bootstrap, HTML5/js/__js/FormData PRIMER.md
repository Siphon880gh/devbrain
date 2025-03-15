Aka: Get Started

### **Understanding `FormData` in JavaScript**

The `FormData` object in JavaScript is used to construct and send key-value pairs, typically for HTTP requests that involve form submissions. It is especially useful when working with `fetch()` or `XMLHttpRequest()` for submitting data to a server.

---

### **Breakdown of Your Code:**

```javascript
const signInFormData = new FormData();
signInFormData.append('email', email);
signInFormData.append('password', password);
```

1. **Creating a `FormData` Object:**
    
    ```javascript
    const signInFormData = new FormData();
    ```
    
    - This initializes an empty `FormData` instance.
    - It will hold form data as key-value pairs.
2. **Appending Form Data Fields:**
    
    ```javascript
    signInFormData.append('email', email);
    signInFormData.append('password', password);
    ```
    
    - `.append(key, value)` method adds data to the `FormData` object.
    - Here, two fields are added:
        - `'email'` → Stores the value of the `email` variable.
        - `'password'` → Stores the value of the `password` variable.

---

### **How is `FormData` Used?**

The `FormData` object can be sent in an HTTP request, typically using `fetch()`. For example:

```javascript
fetch('/api/signin', {
    method: 'POST',
    body: signInFormData
});
```

- The `body` contains the `FormData` object, which automatically sets the `Content-Type` to `multipart/form-data`.
- It allows sending form fields efficiently without manually formatting them.

---

### **Why Use `FormData` Instead of JSON?**

|Feature|`FormData`|JSON|
|---|---|---|
|Supports File Uploads|✅ Yes|❌ No|
|Automatic `Content-Type` Handling|✅ Yes (`multipart/form-data`)|❌ No (must set manually)|
|Works with `<form>` Data|✅ Yes|❌ No|
|Easier to Inspect (in DevTools)|❌ No|✅ Yes|

#### **When to Use JSON Instead?**

If you're working with APIs that expect `application/json`, then using `JSON.stringify()` is more suitable:

```javascript
const signInData = JSON.stringify({
    email: email,
    password: password
});

fetch('/api/signin', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: signInData
});
```

---

### **Summary**

- `FormData` is useful for form submissions, especially when dealing with file uploads.
- It automatically formats data as `multipart/form-data`.
- You can append key-value pairs dynamically.
- Use JSON if working with APIs that require `application/json`.