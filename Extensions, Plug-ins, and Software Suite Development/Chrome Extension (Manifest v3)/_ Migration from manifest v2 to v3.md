
### **Chrome Extensions: Changes from Manifest V2 to V3**

Chrome **Manifest V3 (MV3)** introduced significant security, performance, and privacy improvements, but also removed some key features from **Manifest V2 (MV2)**.

Here’s a breakdown of what was **removed**, what was **added**, and what was **changed**:

---

## **🚫 Features Removed in Manifest V3**

### **1. Background Pages → Replaced with Service Workers**

- **MV2:** Extensions used **persistent background pages** (`background.html` or a background script).
- **MV3:** **Service workers** are now required instead.
    - Service workers **only run when needed**, reducing resource usage.
    - They **cannot use `setTimeout()` or long-running connections**.
    - `chrome.runtime.getBackgroundPage()` is no longer available.

✅ **Alternative: Use event-driven service workers.**

```json
{
  "background": {
    "service_worker": "background.js"
  }
}
```

---

### **2. `chrome.browserAction` & `chrome.pageAction` → Merged into `chrome.action`**

- **MV2:** Used `browserAction` (for global actions) and `pageAction` (for per-tab actions).
- **MV3:** Both are merged into `chrome.action`.

✅ **Example:**

```json
{
  "action": {
    "default_icon": "icon.png",
    "default_popup": "popup.html"
  }
}
```

---

### **3. `chrome.extension.getBackgroundPage()` Removed**

- **MV2:** Allowed retrieving the background page.
- **MV3:** Not available due to service workers.

✅ **Alternative:** Use `chrome.runtime.sendMessage()`.

---

### **4. `content_security_policy` Changes**

- **MV2:** Allowed `unsafe-inline` in `style-src` and `script-src`.
- **MV3:** **Removes `'unsafe-inline'` and `'unsafe-eval'`**.
    - No inline scripts (`<script>` tags in HTML won’t work).
    - No style block (`<style>...</style>`)... because it's no longer covered under unsafe-inline and will error in console as an error about inline. Use css file instead.
    - No script block (`<script>...</script>`)... because it's no longer covered under unsafe-eval and unsafe inline and will error in console. Use js file instead.
    - No inline event handlers (`onclick=""` won't work).
    - No `eval()` or `setTimeout("code", delay)`.
    
- Reworded: unsafe-inline no longer supported in v3
	```
	"content_security_policy": {  
	"extension_pages": style-src 'self' 'unsafe-inline';"  
	```
	- This policy in v2 disallows external css files and allows inline style `<div style="...`,
	- Supported in v2 but removed in v3 because inline style attributes are unsafe from a security standpoint.
	- V3 removed support to reduce the risk of Cross-Site Scripting (XSS) attacks.
	- Including this in V3 will not throw errors. It'll just silently be ignored.

✅ **Alternative to unsafe-eval:**

- Move scripts to separate `.js` files.
- Use event listeners instead of inline event handlers.

```javascript
document.getElementById("btn").addEventListener("click", myFunction);
```

---

### **5. `webRequest` Blocking API → Replaced with `declarativeNetRequest`**

- **MV2:** `webRequest` API allowed modifying/blocking requests dynamically.
- **MV3:** Blocking `webRequest` is **removed** and replaced with `declarativeNetRequest`.

✅ **Alternative: `declarativeNetRequest`** (More performant but less flexible):

```json
{
  "declarative_net_request": {
    "rule_resources": [
      {
        "id": "block_ads",
        "enabled": true,
        "path": "rules.json"
      }
    ]
  }
}
```

---

### **6. `chrome.runtime.onSuspend` Removed**

- **MV2:** `onSuspend` event triggered when the background page was about to close.
- **MV3:** Service workers **automatically terminate** when idle; no explicit suspend event.

✅ **Alternative:** Save state periodically to local storage.

---

## **✅ New Features Added in Manifest V3**

### **1. Service Workers for Background Scripts**

- Background scripts are replaced with service workers.
- Service workers **sleep when idle**, reducing memory usage.
- **Cannot use `setTimeout()`, `setInterval()`, or DOM APIs**.

✅ **Alternative:** Use `alarms` API.

```javascript
chrome.alarms.create("checkUpdates", { periodInMinutes: 15 });
chrome.alarms.onAlarm.addListener(() => {
  console.log("Checking for updates...");
});
```

---

### **2. `chrome.scripting` API for Content Scripts**

- **MV2:** Content scripts were managed via `tabs.executeScript()`.
- **MV3:** New `chrome.scripting.executeScript()` API.

✅ **Example: Injecting a script dynamically**

```javascript
chrome.scripting.executeScript({
  target: { tabId: someTabId },
  files: ["content-script.js"]
});
```

---

### **3. Improved Security & Permissions Model**

- Extensions must **declare all host permissions explicitly** in `manifest.json` (`activeTab` no longer allows access to all sites).
- **Optional permissions** can now be requested dynamically.

✅ **Example: Requesting host permissions at runtime**

```javascript
chrome.permissions.request({
  permissions: ["tabs"],
  origins: ["https://example.com/"]
});
```

---

### **4. New `declarativeNetRequest` API**

- **MV3's replacement for `webRequest` API**.
- Predefined rules in `rules.json` control network requests.
- Less flexible but more performant.

✅ **Example: Blocking ads**

```json
[
  {
    "id": 1,
    "priority": 1,
    "action": { "type": "block" },
    "condition": { "urlFilter": "ads.example.com", "resourceTypes": ["script"] }
  }
]
```

---

### **5. New Host Permission Model**

- In **MV2**, declaring `"host_permissions"` granted immediate access.
- In **MV3**, `"host_permissions"` must be **explicitly requested at runtime**.

✅ **Example:**

```json
{
  "host_permissions": ["https://example.com/"]
}
```


---

### **6. All scripts must be local in Manifest V3**

**All JavaScript must be included in the extension package itself.**
- ❌ Wildcards (`*`) or remote domains are **not allowed** for `script-src` in Chrome Extension CSP.  
- ✅ `'self'` is permitted.

Wildcards like `*` **were allowed** in `script-src` and `style-src`,  in V2, although **not recommended**. In V3, it’s completely not allowed.

---

### **7. `offscreen` API for Hidden Background Work**

- Allows running tasks like audio playback without a visible tab.
- Used when service workers **cannot handle background tasks**.

✅ **Example: Create an offscreen document**

```javascript
chrome.offscreen.createDocument({
  url: "offscreen.html",
  reasons: ["AUDIO_PLAYBACK"],
  justification: "Playing background music"
});
```

---

## **📌 Summary of Key Differences**

|Feature|Manifest V2|Manifest V3|
|---|---|---|
|**Background Scripts**|Persistent `background.js`|Uses **service workers** (no persistence)|
|**Inline Scripts & Styles**|Allowed (`unsafe-inline`)|🚫 **Blocked** (Use external scripts & styles)|
|**Blocking `webRequest` API**|Allowed|🚫 **Replaced with `declarativeNetRequest`**|
|**Permissions Model**|Implicit host permissions|🚫 **Must be declared explicitly**|
|**Executing Scripts**|`tabs.executeScript()`|🚀 **Use `chrome.scripting.executeScript()`**|
|**Event Handling**|`onclick=""` allowed|🚫 **Must use `addEventListener()`**|
|**Long-running Background Tasks**|Persistent pages|**Use `offscreen` API** or `alarms`|

✅ **Pros of Manifest V3**

- **Better performance** (less memory usage).
- **Stronger security** (no inline scripts, fewer attack vectors).
- **More efficient request handling** (`declarativeNetRequest`).
- **More granular permissions control**.

⚠️ **Cons of Manifest V3**

- **Service workers expire when idle** (requires event-driven coding).
- **Less flexible network request modification**.
- **No inline scripts or styles** (requires workarounds).

---

## **Final Thoughts**

- **New extensions must use MV3** (MV2 is no longer supported in Chrome Web Store).
- Existing MV2 extensions **will stop working by June 2025**.
- If your extension uses **persistent background scripts, blocking `webRequest`, or inline scripts**, you **must migrate**.
