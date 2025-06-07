In Chrome extension development:

- **`chrome.storage` (sync or local)** is used to persist settings. When the options page (or any other part of the extension) is opened fresh, it can read from storage to restore the saved settings. You can store at the local Chrome or to all Chrome across your devices where you signed in.
- **`chrome.runtime.sendMessage` & `chrome.runtime.onMessage`** enable real-time communication between different parts of the extension (popup, options, background script, content script). This is useful for applying changes live without needing a refresh.

### Example Workflow:

1. **Load settings on page load:**
    
    ```js
    chrome.storage.sync.get(["theme", "notifications"], (data) => {
        document.body.classList.toggle("dark-mode", data.theme === "dark");
        document.querySelector("#notifications").checked = data.notifications;
    });
    ```
    
2. **Save settings and notify other parts of the extension:**
    
    ```js
    document.querySelector("#saveButton").addEventListener("click", () => {
        let theme = document.querySelector("#themeSelect").value;
        let notifications = document.querySelector("#notifications").checked;
    
        chrome.storage.sync.set({ theme, notifications }, () => {
            chrome.runtime.sendMessage({ type: "settingsUpdated", theme, notifications });
        });
    });
    ```
    
3. **Listen for real-time changes (e.g., in content scripts or other pages of the extension):**
    
    ```js
    chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
        if (message.type === "settingsUpdated") {
            document.body.classList.toggle("dark-mode", message.theme === "dark");
        }
    });
    ```
    

This ensures settings persist across sessions (via storage) while also allowing instant updates (via messages).


----


In Chrome extensions, `chrome.storage.sync` and `chrome.storage.local` are both used to store data, but they have key differences:

|Feature|`chrome.storage.sync`|`chrome.storage.local`|
|---|---|---|
|**Sync across devices**|✅ Yes, syncs via Google account|❌ No, stored only on the local device|
|**Quota (Storage Limit)**|100KB per extension, 8KB per item|10MB per extension (or more with `unlimitedStorage` permission)|
|**Speed**|⚡ Slightly slower (due to cloud sync)|⚡ Faster (local access)|
|**Best Use Case**|User preferences/settings that should persist across devices|Large data storage, caching, or temporary data|

### When to Use:

- **Use `chrome.storage.sync`** for **user settings** that should follow the user across devices (e.g., theme preferences, notification settings).
- **Use `chrome.storage.local`** for **larger or temporary data** (e.g., cache, logs, downloaded content, session data).

### Example Usage:

#### **Sync Storage (Persist Across Devices)**

```js
chrome.storage.sync.set({ theme: "dark" }, () => {
    console.log("Theme saved to sync storage.");
});
```

```js
chrome.storage.sync.get("theme", (data) => {
    console.log("Theme:", data.theme);
});
```

#### **Local Storage (Faster, More Space)**

```js
chrome.storage.local.set({ cacheData: "some_large_data" }, () => {
    console.log("Data saved locally.");
});
```

```js
chrome.storage.local.get("cacheData", (data) => {
    console.log("Cache Data:", data.cacheData);
});
```

For extensions that need more than 10MB of storage, you can request the `unlimitedStorage` permission in `manifest.json`:

```json
"permissions": [
    "storage",
    "unlimitedStorage"
]
```

### Conclusion:

- If you need **sync across devices**, use **`sync`**.
- If you need **more space or faster access**, use **`local`**.