
When sending authenticated API requests over HTTPS, the standard way to include credentials is through the `Authorization` header. This header plays a critical role in telling the server **what type of authorization method is being used**, and it follows a specific structure that you should always adhere to.

---

### ✅ Standard Format: `Authorization` Header with a Prefix

The `Authorization` header must begin with a keyword that identifies the authentication scheme being used. This allows the server to apply the correct logic to validate the credentials.

#### Common Examples:

- **Bearer Token** (used with JWT, OAuth2):
    
```http
Authorization: Bearer eyJhbGciOi...
```
    
- **Basic Auth** (base64-encoded `username:password`):
    
```http
Authorization: Basic dXNlcjpwYXNz
```
    

In both cases, the **prefix (`Bearer`, `Basic`) is mandatory**. The key `"Authorization"` is standardized across HTTP — meaning the **only place** you can specify the auth type is in the **value** of the header.

In Postman, these two screens are equivalent:
![[Pasted image 20250609020728.png]]

![[Pasted image 20250609020757.png]]

---

### ❌ Why This Is Invalid: `Authorization: PlainPassword`

A header like this is **not valid or safe**:

```http
Authorization: mysecretpassword
```

Here’s why:

- There's **no prefix** to indicate the authentication method.
- The server won't know how to interpret it (is it a token? Basic auth? something else?).
- You're sending a **raw password**, which is risky.

Even though HTTPS encrypts the request (including headers and body), **this is still not secure enough** to justify sending plain credentials. Developers inspecting network traffic using Chrome DevTools can easily view this header — and so can anyone with local access to their machine.

---

### ✅ For Development Only: Custom Headers

If you absolutely must send a plain password (only for internal tools or dev environments), use a custom header like:

```http
X-Auth-Password: mypassword
```

And in Express:

```js
const password = req.headers['x-auth-password'];
```

Or a more thorough implementation can be:
```
  // Check for auth token that is process.env.DEVELOPER_ONLY_PASSWORD
  const authToken = req.headers?["x-auth-password];
  if (!authToken || authToken !== process.env.DEVELOPER_ONLY_PASSWORD) {
    return res.status(401).json({
      error: 'Unauthorized',
      message: 'Invalid or missing authentication token'
    });
  }
```

But again — this is for **development only**. Never ship this to production.