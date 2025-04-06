
In Chrome extensions, chrome.storage.sync and chrome.storage.local are both used to store data, but they have key differences:

| Feature                   | `chrome.storage.sync`                                        | `chrome.storage.local`                                          |
| ------------------------- | ------------------------------------------------------------ | --------------------------------------------------------------- |
| **Sync across devices**   | ✅ Yes, syncs via Google account                              | ❌ No, stored only on the local device                           |
| **Quota (Storage Limit)** | 100KB per extension, 8KB per item                            | 10MB per extension (or more with `unlimitedStorage` permission) |
| **Speed**                 | ⚡ Slightly slower (due to cloud sync)                        | ⚡ Faster (local access)                                         |
| **Best Use Case**         | User preferences/settings that should persist across devices | Large data storage, caching, or temporary data                  |

### When to Use:

- **Use `chrome.storage.sync`** for **user settings** that should follow the user across devices (e.g., theme preferences, notification settings).
- **Use `chrome.storage.local`** for **larger or temporary data** (e.g., cache, logs, downloaded content, session data).