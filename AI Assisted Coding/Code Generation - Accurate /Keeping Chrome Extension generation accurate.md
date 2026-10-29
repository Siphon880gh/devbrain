# Keeping Chrome Extension generation accurate

Most models still mix Manifest V2 and Manifest V3. They will happily emit `browser_action`, `background.scripts`, `chrome.tabs.executeScript`, host URLs inside `"permissions"`, inline `onclick`, or a persistent background page — all of which are V2 and fail in current Chrome.

**Load this file as AI context** before asking an AI to write or convert an extension. Tell it: *Chrome extensions must be Manifest V3 only. Do not use any Manifest V2 APIs.*

The migration steps, official Google links, and sample list live in [[_ Migration from manifest v2 to v3]]. Attach that note too if the job is a V2 port. For a from-scratch extension, this cheat sheet plus one V3 sample is usually enough.

Chrome disabled Manifest V2 for everyone in Chrome 138 (July 2025). The Chrome Web Store finishes deleting leftover V2 listings on August 31, 2026. New generation **must** be V3.

---

## V2 vs V3 cheat sheet

If you are a model reading this file, treat the left column as **forbidden**. Emit only the right column.

| Do not generate (V2) | Generate this instead (V3) |
|---|---|
| `"manifest_version": 2` | `"manifest_version": 3` |
| `"background": { "scripts": ["background.js"], "persistent": true }` | `"background": { "service_worker": "background.js" }` |
| `"background": { "page": "background.html" }` | `"background": { "service_worker": "background.js" }` |
| `"browser_action"` / `"page_action"` | `"action"` |
| `chrome.browserAction` / `chrome.pageAction` | `chrome.action` |
| `chrome.tabs.executeScript(...)` | `chrome.scripting.executeScript({ target: { tabId }, files or func })` plus `"permissions": ["scripting"]` |
| `chrome.tabs.insertCSS(...)` | `chrome.scripting.insertCSS(...)` |
| Host URLs inside `"permissions"` (`"https://*/*"`) | `"host_permissions": ["https://*/*"]` |
| `"content_security_policy": "script-src 'self' 'unsafe-eval'; ..."` (string) | `"content_security_policy": { "extension_pages": "script-src 'self'; object-src 'self';" }` |
| Inline `<script>` in popup/options HTML | A separate `.js` file listed from the HTML |
| `onclick="..."`, `eval()`, `setTimeout("code", n)` | `addEventListener` and real functions |
| Remote JS (`https://cdn.../lib.js` as a script) | Bundle the file in the extension package |
| `chrome.extension.getBackgroundPage()` / `chrome.runtime.getBackgroundPage()` | `chrome.runtime.sendMessage` / `chrome.runtime.connect` |
| `chrome.webRequest` with `"webRequestBlocking"` | `declarativeNetRequest` + a `rules.json` |
| `chrome.runtime.onSuspend` | Persist to `chrome.storage`; the worker dies on idle |
| Sharing variables on a live background page | `chrome.storage` or messages — the worker is not always running |

V3 service-worker rules the model also gets wrong:

- No DOM, no `window`, no `document` in `background.js`.
- No reliable long `setTimeout` / `setInterval`. Use `chrome.alarms`.
- Listeners must be registered at the **top level** of the service worker, not inside `onInstalled` or a `then()`.
- State in a global variable is lost when Chrome kills the worker (~30s idle). Write it to `chrome.storage`.
- Work that needs a hidden document (audio, canvas, some DOM APIs) uses [`chrome.offscreen`](https://developer.chrome.com/docs/extensions/reference/api/offscreen).

A minimal V3 shape to copy:

```json
{
  "manifest_version": 3,
  "name": "<APP_NAME>",
  "version": "1.0",
  "action": { "default_icon": "icon.png" },
  "background": { "service_worker": "background.js" },
  "permissions": ["scripting", "tabs", "activeTab"],
  "host_permissions": ["https://*/*", "http://*/*"]
}
```

```javascript
chrome.action.onClicked.addListener((tab) => {
  chrome.scripting.executeScript({
    target: { tabId: tab.id },
    func: () => {
      document.body.style.backgroundColor = "blue";
    }
  });
});
```

---

## Prompt

Attach this article (and [[_ Migration from manifest v2 to v3]] if you are porting). Then constrain the model:

```
Write a Chrome extension. Manifest V3 only. Follow the V2 vs V3 cheat sheet in the attached article. Do not use browser_action, background.scripts, chrome.tabs.executeScript, host URLs inside permissions, inline script, or a persistent background page.
```

If the model still emits V2, point it back at the cheat sheet table and one matching V3 sample from [[_ Migration from manifest v2 to v3]]. Those two together are usually enough to stop the mix-up.

Useful samples to attach as extra context:

- Toolbar click + `chrome.scripting`: [[2a. Chrome extension foundational with popup]]
- Content script only: [[3. Content scripts to modify web page]]
- Popup ↔ worker messages: [[3. Two-Way Messaging (Popup and Background)]]
- Official starter: [tutorial.getting-started](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/tutorial.getting-started)
