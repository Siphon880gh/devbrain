### Syntax and Types

In a Chrome extension, the `"action"` key in `manifest.json` allows defining behaviors for the extension's toolbar button. Here are other properties you can use inside `"action"`:

Here are the full options of action:
```
"action": {
  "default_popup": "popup.html",
  "default_icon": {
    "16": "icon16.png",
    "48": "icon48.png",
    "128": "icon128.png"
  },
  "default_title": "My Extension Tooltip",
  "default_badge_text": "ON"
}
```

| Property           | Description                                                                                               |
| ------------------ | --------------------------------------------------------------------------------------------------------- |
| default_popup      | OPTIONAL. Specifies an HTML file (popup.html) that appears when clicking the extension icon.              |
| default_icon       | Defines the icon for the extension button (supports different sizes).                                     |
| default_title      | OPTIONAL. Sets a tooltip when the user hovers over the extension icon. Otherwise refers to your app name. |
| default_badge_text | OPTIONAL. Displays a small text badge over the icon. Otherwise refers to your app description.            |

Although popup is actually an action, not all actions are popup.

What Actions can do:
1. **Popup**    
    - Clicking the icon opens `popup.html`.
2. **Icon Click Event (without a popup)**
    - If `default_popup` is **not** defined, clicking the icon triggers `chrome.action.onClicked`.
3. **Badge Indicators**
    - Use `setBadgeText` and `setBadgeBackgroundColor` for notifications.


---

### **Two Main Ways to Use `action`**

1. **With a Popup (`default_popup`)**
    
    - Clicking the extension icon opens an HTML popup (e.g., `popup.html`).
    - No JavaScript event is fired when the icon is clicked.
    
    ```json
    "action": {
      "default_popup": "popup.html",
      "default_icon": "icon.png"
    }
    ```
    
    - Example: A settings or control panel for your extension.
      
2. **Without a Popup (Using `chrome.action.onClicked`)**
    
    - If `default_popup` is **not** defined, clicking the icon triggers an event listener (`chrome.action.onClicked`).
    - This allows running a function instead of opening a popup.
    
    ```json
    "action": {
      "default_icon": "icon.png",
      "default_title": "Click to perform an action"
    }
    ```
    
    - Then, in your **background script** (`background.js`):
        
        ```js
        chrome.action.onClicked.addListener((tab) => {
            console.log("Extension icon clicked on tab:", tab);
        });
        ```
    - Example: Toggle dark mode, open a new tab, or execute a script.
    - Remember for background.js to work, your manfest.json needs:
	```
	  "background": {
	    "service_worker": "background.js"
	  },
	```

---

#### **When to Use What?**

|Feature|Use a Popup|Use `onClicked`|
|---|---|---|
|Displaying UI|✅ Yes|❌ No|
|Running a Script|❌ No|✅ Yes|
|Opening a Tab|❌ No|✅ Yes|
|Changing Badge Text|❌ No|✅ Yes|

So, **actions are flexible**—you can use them with or without a popup, depending on what you need. 🚀

---

### **Programmatically Controlling Actions**

You can dynamically update the action using the `chrome.action` API in your background script:

#### **Change the popup dynamically**

```js
chrome.action.setPopup({ popup: "new_popup.html" });
```

#### **Change the Chrome Extension icon's action**

- You can dynamically **switch between a popup and a click event** using `chrome.action.setPopup()`.
    
    ```js
    chrome.action.setPopup({ popup: "new_popup.html" });
    chrome.action.setPopup({ popup: "" }); // Removes popup, enabling click event
    ```
    

#### **Change the icon dynamically**

```js
chrome.action.setIcon({ path: "new_icon.png" });
```

#### **Change the badge text**

```js
chrome.action.setBadgeText({ text: "NEW" });
chrome.action.setBadgeBackgroundColor({ color: "#FF0000" });
```

#### **Handle clicks manually (without a popup)**

Instead of a popup, you can handle icon clicks using an event listener:

```js
chrome.action.onClicked.addListener((tab) => {
    console.log("Extension icon clicked on tab:", tab);
});
```
