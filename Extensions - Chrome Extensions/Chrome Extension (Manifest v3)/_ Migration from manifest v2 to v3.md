# Migration from Manifest V2 to V3

Chrome **Manifest V3 (MV3)** changed security, performance, and privacy. Persistent background pages, `browser_action` / `page_action`, blocking `webRequest`, host URLs inside `"permissions"`, and inline scripts are gone. New work and any remaining V2 port **must** be V3.

Chrome disabled Manifest V2 for everyone in Chrome 138 (July 2025) and removed the last enterprise policy in Chrome 139 (August 2025). The Chrome Web Store finishes deleting leftover V2 listings on August 31, 2026.

If you are asking an AI to write or convert an extension, attach [[Keeping Chrome Extension generation accurate]] so it does not emit V2 APIs.

Official Google guides:

- [Migrate to Manifest V3](https://developer.chrome.com/docs/extensions/develop/migrate)
- [Update the manifest](https://developer.chrome.com/docs/extensions/develop/migrate/manifest)
- [Migrate to a service worker](https://developer.chrome.com/docs/extensions/develop/migrate/to-service-workers)
- [Update API calls](https://developer.chrome.com/docs/extensions/develop/migrate/api-calls)
- [Replace blocking web request listeners](https://developer.chrome.com/docs/extensions/develop/migrate/blocking-web-requests)
- [Improve extension security](https://developer.chrome.com/docs/extensions/develop/migrate/improve-security)
- [MV2 deprecation timeline](https://developer.chrome.com/docs/extensions/develop/migrate/mv2-deprecation-timeline)

Related notes in this vault: [[__ Chrome Extension PRIMER]], [Learn by Leveling Up — Chrome Extension v3](https://github.com/Siphon880gh/devbrain/tree/main/Extensions%20-%20Chrome%20Extensions/Chrome%20Extension%20(Manifest%20v3)/___%20Learn%20by%20Leveling%20Up%20-%20Chrome%20Extension%20v3). Live search: [wengindustry.com/tools/devbrain](https://wengindustry.com/tools/devbrain/).

---

## V2 vs V3 cheat sheet

| V2 (do not keep) | V3 (use this) |
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

V3 service-worker rules that break a port if you ignore them:

- No DOM, no `window`, no `document` in `background.js`.
- No reliable long `setTimeout` / `setInterval`. Use `chrome.alarms`.
- Listeners must be registered at the **top level** of the service worker, not inside `onInstalled` or a `then()`.
- State in a global variable is lost when Chrome kills the worker (~30s idle). Write it to `chrome.storage`.
- Work that needs a hidden document (audio, canvas, some DOM APIs) uses [`chrome.offscreen`](https://developer.chrome.com/docs/extensions/reference/api/offscreen).

---

## Migration steps

Work through these in order. Do not add features while porting — a new permission warning disables the installed extension until the user accepts it.

### 1. Flip the manifest version and rename the toolbar key

**V2**

```json
{
  "manifest_version": 2,
  "browser_action": {
    "default_popup": "popup.html",
    "default_icon": "icon.png"
  }
}
```

**V3**

```json
{
  "manifest_version": 3,
  "action": {
    "default_popup": "popup.html",
    "default_icon": "icon.png"
  }
}
```

`page_action` also becomes `action`. In JavaScript, `chrome.browserAction.onClicked` becomes `chrome.action.onClicked`. See [[Action types - Chrome Extension]].

### 2. Replace the background page with a service worker

**V2**

```json
"background": {
  "scripts": ["background.js"],
  "persistent": true
}
```

**V3**

```json
"background": {
  "service_worker": "background.js"
}
```

Then change how the rest of the extension reaches that file:

- Delete any `background.html`.
- Delete `getBackgroundPage()` calls.
- If the old background used the DOM, split that work into an [offscreen document](https://developer.chrome.com/docs/extensions/develop/migrate/to-service-workers#offscreen).
- Replace `setInterval` keepalive loops with `chrome.alarms`.
- Move anything you used to stash on `window` into `chrome.storage.local` or `chrome.storage.session`.

```javascript
chrome.alarms.create("checkUpdates", { periodInMinutes: 15 });
chrome.alarms.onAlarm.addListener((alarm) => {
  if (alarm.name === "checkUpdates") {
    // do the work, then finish — do not spin a timer
  }
});
```

`chrome.runtime.onSuspend` is gone. Service workers terminate when idle; there is no explicit suspend event. Save state periodically to storage.

Offscreen example when the worker cannot own the work:

```javascript
chrome.offscreen.createDocument({
  url: "offscreen.html",
  reasons: ["AUDIO_PLAYBACK"],
  justification: "Playing background music"
});
```

### 3. Split API permissions from host permissions

**V2** lumped site access into `"permissions"`:

```json
"permissions": [
  "tabs",
  "storage",
  "https://www.example.com/*",
  "<all_urls>"
]
```

**V3** splits them so Chrome can ask for host access separately:

```json
"permissions": ["tabs", "storage", "scripting"],
"host_permissions": [
  "https://www.example.com/*"
]
```

Optional grants the user can approve later:

```json
"optional_permissions": ["bookmarks"],
"optional_host_permissions": ["https://*/*"]
```

```javascript
chrome.permissions.request({
  permissions: ["bookmarks"],
  origins: ["https://example.com/"]
});
```

`activeTab` still means "the tab the user just invoked this extension on." It is not a substitute for `"<all_urls>"`. See [[Permission activeTab - Chrome Extension]], [[Host permission - Fundamental, Chrome Extension]], [[Permission tabs - Chrome Extension]].

### 4. Switch script injection to `chrome.scripting`

**V2**

```javascript
chrome.tabs.executeScript(tabId, { file: "content.js" });
chrome.tabs.insertCSS(tabId, { file: "content.css" });
```

**V3** — add `"scripting"` to `"permissions"`, and a host permission or `activeTab`:

```javascript
chrome.scripting.executeScript({
  target: { tabId },
  files: ["content.js"]
});

chrome.scripting.executeScript({
  target: { tabId },
  func: () => {
    document.body.style.backgroundColor = "blue";
  }
});

chrome.scripting.insertCSS({
  target: { tabId },
  files: ["content.css"]
});
```

Static content scripts in the manifest still work. Their `matches` list is its own grant, separate from `host_permissions`. See [[3. Content scripts to modify web page]], [[Inject a css file or a js file from chrome extension into web content - Need]].

### 5. Tighten CSP and stop loading remote code

**V2** often used a string CSP and allowed `'unsafe-inline'` / `'unsafe-eval'`, or pulled jQuery from a CDN.

**V3**

```json
"content_security_policy": {
  "extension_pages": "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; object-src 'self';"
}
```

Rules that fail silently or at runtime if you ignore them:

- Every JS file Chrome executes for the extension must live **inside the package**. Wildcards (`*`) or remote domains are not allowed for `script-src`.
- No `<script>` blocks in popup / options / side panel HTML. `<script src="popup.js"></script>` is fine.
- No `<style>...</style>` blocks and no `style="..."` attributes on extension pages — use a CSS file.
- No `onclick="save()"` — use `addEventListener`.
- No `eval`, no `new Function`, no `setTimeout("...")`.
- `'unsafe-inline'` on `extension_pages` is ignored. Including the old V2 string policy in V3 will not throw; Chrome just drops it.

`web_accessible_resources` is now an object, not a string array:

```json
"web_accessible_resources": [
  {
    "resources": ["icon.png", "assets/*"],
    "matches": ["https://*/*"]
  }
]
```

See [[CSP - Fundamental]], [[CSP in manifest.json]], [[Allowing other webpages to use your chrome extension's assets - Sometimes need]].

### 6. Replace blocking `webRequest` with declarative rules

**V2**

```json
"permissions": ["webRequest", "webRequestBlocking", "<all_urls>"]
```

**V3**

```json
"permissions": ["declarativeNetRequest"],
"host_permissions": ["<all_urls>"],
"declarative_net_request": {
  "rule_resources": [
    {
      "id": "block_ads",
      "enabled": true,
      "path": "rules.json"
    }
  ]
}
```

```json
[
  {
    "id": 1,
    "priority": 1,
    "action": { "type": "block" },
    "condition": {
      "urlFilter": "ads.example.com",
      "resourceTypes": ["script"]
    }
  }
]
```

You can still *observe* requests with `webRequest`. You cannot block or rewrite them from a listener.

### 7. Retest each surface

After the manifest compiles:

1. Load unpacked from `chrome://extensions`.
2. Open the **service worker** console from the extension card — that is `background.js`.
3. Content-script logs are on the **tab**. Popup / options / side panel each have their own inspector.
4. Confirm the worker dies and comes back: leave it idle, then click the action. If a feature "forgot" its state, you stored it in a variable instead of `chrome.storage`.

See [[__ Debugging - View Chrome extension errors]], [[Debugging various presentations -  Chrome Extension]].

---

## How the V3 pieces talk (replaces the background page)

V2 code often treated the background page as shared memory. That is gone. These are isolated worlds:

| World | Has page DOM? | Survives idle? |
|---|---|---|
| Service worker | No | No (~30s) |
| Popup / options / side panel | No | Only while the page is open |
| Content script | Yes | Until the tab navigates |
| DevTools panel / sidebar | Only via `inspectedWindow` | While DevTools is open |

Use messages, not globals:

- One-shot: `chrome.runtime.sendMessage` / `chrome.tabs.sendMessage` — see [[3. Two-Way Messaging (Popup and Background)]]
- Port: `chrome.runtime.connect` — see [[2. From to with sendMessge]]
- Durable state: `chrome.storage.local` or `.sync` — see [[Storage - Local vs Sync]], [[1b. Save options that affect the rest of Chrome experience]]

---

## Sample apps

Load unpacked from `chrome://extensions` → Developer mode → **Load unpacked**.

### Notes in this vault

| Sample | What it proves after a V2 port | Note |
|---|---|---|
| Toolbar / action | `chrome.action` instead of `browser_action` | [[Action types - Chrome Extension]], [[2a. Chrome extension foundational with popup]] |
| Content script | Static `content_scripts` with CSS | [[3. Content scripts to modify web page]] |
| Web-accessible resources | V3 object form; `chrome.runtime.getURL` | [[Allowing other webpages to use your chrome extension's assets - Sometimes need]], [[5. Web resources, actions, content scripts, matching urls]] |
| Popup ↔ background ports | `runtime.connect` because `getBackgroundPage()` is gone | [[2. From to with sendMessge]] |
| Directed `sendMessage` | Popup, worker, and content script routing | [[3. Two-Way Messaging (Popup and Background)]] |
| Options page | `options_ui` Chrome-style dialog | [[Options page looking like Chrome settings]] |
| Options + `chrome.storage` | Persist settings after the worker dies | [[1b. Save options that affect the rest of Chrome experience]] |
| Side panel | `side_panel` + `sidePanel` permission (V3-only API) | [[2a. Create sidepanel for chrome extension icon click (Bonus - Sidepanel Action, setPanelBehavior)]] |
| Tab-specific side panel | Side panel plus a content script | [[6. Create sidepanel that only works for specific url]] |
| All surfaces | Popup, options, side panel, context menus | [[3. All presentations with checkboxes that changes web content (storage, sendMessage, tabs.onActivated)]] |
| DevTools panel + sidebar | `devtools_page` must be HTML, not a bare JS file | [[1. Concept - DevTools HTML as entry, Create DevTool Panel and SideBar Pane]] |
| Debugger / network log | `debugger` permission + CDP `Network` | [[4. Debugger Protocol to log network requests - Chrome Extension]] |
| Theme | `theme` key only — no scripts | [[1. Themes - Chrome Theme PRIMER]] |

A minimal V3 manifest:

```json
{
  "manifest_version": 3,
  "name": "<APP_NAME>",
  "version": "1.0",
  "action": { "default_icon": "icon.png" },
  "background": { "service_worker": "background.js" },
  "permissions": ["scripting", "tabs", "activeTab"],
  "host_permissions": ["https://*/*", "http://*/*"],
  "content_scripts": [
    {
      "matches": ["https://*/*", "http://*/*"],
      "js": ["content.js"],
      "run_at": "document_end"
    }
  ]
}
```

The matching worker uses V3 APIs only:

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

### Official Google samples

Clone [GoogleChrome/chrome-extensions-samples](https://github.com/GoogleChrome/chrome-extensions-samples) and load a folder under `functional-samples/`.

| Sample | Why it helps a V2 → V3 port | Link |
|---|---|---|
| Hello World | Smallest V3 popup | [tutorial.hello-world](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/tutorial.hello-world) |
| Getting started | Action + service worker + `scripting` | [tutorial.getting-started](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/tutorial.getting-started) |
| Reading time | Content script only | [tutorial.reading-time](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/tutorial.reading-time) |
| Page redder | Toolbar click injects a function | [sample.page-redder](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/sample.page-redder) |
| MV3 content scripts | Reference for the V3 injection model | [reference.mv3-content-scripts](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/reference.mv3-content-scripts) |
| Service worker lifetime | What happens when Chrome kills the worker | [tutorial.terminate-sw](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/tutorial.terminate-sw) |
| Declarative Net Request | Replacement for blocking `webRequest` | [sample.dnr-rule-manager](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/sample.dnr-rule-manager) |
| Global side panel | V3-only `sidePanel` API | [cookbook.sidepanel-global](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/cookbook.sidepanel-global) |
| Site-specific side panel | Enable the panel only on some hosts | [cookbook.sidepanel-site-specific](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/cookbook.sidepanel-site-specific) |
| Offscreen DOM | DOM work the service worker cannot do | [cookbook.offscreen-dom](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/cookbook.offscreen-dom) |
| Optional permissions | Runtime `permissions.request` | [sample.optional_permissions](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/sample.optional_permissions) |
| Theme | V3 theme package | [sample.theme](https://github.com/GoogleChrome/chrome-extensions-samples/tree/main/functional-samples/sample.theme) |

Google's browsable index: [developer.chrome.com/docs/extensions/samples](https://developer.chrome.com/docs/extensions/samples).

### Published V3 apps from this author

| App | Link |
|---|---|
| All Tabs Screenshot Report | [Siphon880gh/all-tabs-screenshot-report](https://github.com/Siphon880gh/all-tabs-screenshot-report) |
| Stocks Technical Analysis | [Siphon880gh/stocks-technical-analysis](https://github.com/Siphon880gh/stocks-technical-analysis) |
| Web Designer Chrome Extension | [Siphon880gh/web-designer-chrome-extension](https://github.com/Siphon880gh/web-designer-chrome-extension) |

---

## Summary of key differences

| Feature | Manifest V2 | Manifest V3 |
|---|---|---|
| **Background Scripts** | Persistent `background.js` | **Service workers** (non-persistent) |
| **Long-running Background Tasks** | Persistent pages | **Use `offscreen` API** or `alarms` |
| **`browserAction` / `pageAction`** | Two separate APIs | **Merged into `chrome.action`** |
| **`chrome.runtime.getBackgroundPage()`** | Available | **Removed** (use messaging instead) |
| **Inline Scripts & Styles** | Allowed (`unsafe-inline`) | **Blocked** (external files only) |
| **Blocking `webRequest` API** | Allowed | **Replaced with `declarativeNetRequest`** |
| **`chrome.runtime.onSuspend`** | Available | **Removed** (service workers suspend automatically) |
| **Executing Scripts** | `tabs.executeScript()` | **`chrome.scripting.executeScript()`** |
| **Permissions** | All in `permissions` | **Split into `permissions` + `host_permissions`** |
| **Event Handling** | Inline handlers (`onclick=""`) allowed | **Use `addEventListener()`** |
| **Scripts** | Remote scripts allowed (not recommended) | **Only local scripts allowed** |
| **`offscreen` API** | Not available | **New API for hidden background tasks** |
| **Dynamic Host Permissions** | Not supported | **`permissions.request()` at runtime** |

Pros: less memory, stronger CSP, declarative request handling, finer permissions.

Cons: the worker expires when idle, network rewriting is less flexible, no inline scripts or styles.

For AI generation constraints and the attach-this-file prompt, see [[Keeping Chrome Extension generation accurate]].
