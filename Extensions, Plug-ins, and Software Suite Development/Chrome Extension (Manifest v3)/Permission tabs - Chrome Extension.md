### Permissions Breakdown

#### `"tabs"` permission

- Grants **extra privileges**, like:
    - Access to **tab properties** (e.g. `url`, `title`).
    - Ability to modify or interact with **tabs you don't own**, like reading the current tab’s URL.
- **You don’t need it** just to use `chrome.tabs.update()` or `chrome.tabs.create()` from a popup, as long as you’re only using them on the **active tab** and **not requesting tab details** like `url`.

#### `"activeTab"` permission

- Allows temporary access to the **currently active tab** when a user interacts with the extension (like clicking the popup).
- Useful if you want to **inject scripts** into the active tab **without** declaring `"tabs"` in `permissions`.

---

### Not needed for opening tabs:

You're only using:

```js
chrome.tabs.query({ active: true, currentWindow: true }, ...)
```

and

```js
chrome.tabs.update(...)
```

That doesn’t require the `"tabs"` permission if you're:

- Running from the **popup script**, and
- Not accessing restricted tab fields like `url`, `favIconUrl`, etc.
