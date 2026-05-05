If you're configuring access control in Apache using a `.conf` file and you intend to **block only one specific IP address**, such as `192.168.30.1`, it's crucial to understand how the `Order`, `Allow`, and `Deny` directives interact.

#### Problem
```
Order Deny,Allow
Allow from all
Deny from 192.168.30.1
```

**Intent:** Block access from IP `192.168.30.1` while allowing everyone else.

**Result:** Apache actually **grants access to all**, including `192.168.30.1`. This creates a serious security issue and directly contradicts the intended behavior.

---

### Why This Happens: The Role of `Order`

The `Order` directive determines **which rules are processed first** and how conflicts between `Allow` and `Deny` are resolved.

In `Order Deny,Allow`, Apache:
1. Applies all `Deny` rules first.
2. Then applies `Allow` rules.
3. **If an IP matches both**, the `Allow` overrides the `Deny`.

So in the example:

- `Deny from 192.168.30.1` — this IP is flagged as denied.
- But then `Allow from all` **overrides** it, effectively granting access to all IPs.

---

### Apache Source Code Insight

Here’s a simplified version of how Apache processes these rules:
```
int ret = OK; // default

if (a->order[method] == ALLOW_THEN_DENY) {
    ret = HTTP_FORBIDDEN;
    if (find_allowdeny(r, a->allows, method)) 
        ret = OK;
    if (find_allowdeny(r, a->denys, method)) 
        ret = HTTP_FORBIDDEN;
} 
else if (a->order[method] == DENY_THEN_ALLOW) {
    if (find_allowdeny(r, a->denys, method)) 
        ret = HTTP_FORBIDDEN;
    if (find_allowdeny(r, a->allows, method)) 
        ret = OK;
} 
else {
    if (find_allowdeny(r, a->allows, method) &&
        !find_allowdeny(r, a->denys, method))
        ret = OK;
    else
        ret = HTTP_FORBIDDEN;
}

```

In `DENY_THEN_ALLOW`, a matching `Allow` can override a previous `Deny`.

---

### Correct Configuration

To properly **block just one IP**, use either of the following:

#### Option 1 (Explicit Order):

```
Order Deny,Allow
Deny from 192.168.30.1
```

This works because there is **no overriding `Allow`**, so the denial stands.

#### Option 2 (Simplest form):

```
Deny from 192.168.30.1
```

Apache will use the default behavior and block the specified IP without needing an `Order` directive.

---

### Summary

When configuring IP restrictions in Apache:
- Avoid combining `Allow from all` with a `Deny` if your `Order` is `Deny,Allow`.
- Remember that `Allow` rules can override `Deny` ones depending on the order.
- For simple IP blocking, a single `Deny from` line is sufficient and safer.