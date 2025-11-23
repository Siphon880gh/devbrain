Keyboard shortcuts let your Chrome extension run code instantly when the user presses specific key combinations, without clicking anything. You do this in two steps:

1. **Declare the shortcut and command name in `manifest.json`.**
2. **Listen for that command in your background script and call a function.**
    
Once that’s in place, pressing the shortcut (e.g. `Ctrl+Shift+Y`) will trigger your handler.

---

## 1. The `commands` block in `manifest.json`

Here’s the basic snippet you showed:

```json
"commands": {
  "run-foo": {
    "suggested_key": {
      "default": "Ctrl+Shift+Y",
      "mac": "Command+Shift+Y"
    },
    "description": "Run \"foo\" on the current page."
  }
}
```

What this does:

- `"run-foo"` is the **command name** (an ID string).
    
- `"suggested_key"` defines the **keyboard shortcut** you’d like:
    
    - `"default": "Ctrl+Shift+Y"` for most platforms.
        
    - `"mac": "Command+Shift+Y"` on macOS.
        
- `"description"` is what users see in `chrome://extensions/shortcuts`.
    

This by itself **does not run any code yet**. It just tells Chrome:

> “If the user presses this shortcut, please fire a command called `run-foo` for my extension.”

You still need to **listen for that command** in your background script.

---

## 2. Minimal working example (folder layout)

Let’s build a tiny MV3 extension that changes the current page when you press the shortcut.

**Folder structure:**

```
my-extension/
  manifest.json
  background.js
  icons/
    icon16.png
    icon48.png
    icon128.png
```

We’ll focus on `manifest.json` and `background.js`.

---

## 3. `manifest.json`: wiring the command to your background script

Here’s a minimal `manifest.json` that includes the `commands` block and a background service worker:

```json
{
  "name": "Keyboard Foo Example",
  "description": "Press a keyboard shortcut to run foo on the current page.",
  "version": "1.0.0",
  "manifest_version": 3,

  "icons": {
    "16": "icons/icon16.png",
    "48": "icons/icon48.png",
    "128": "icons/icon128.png"
  },

  "permissions": [
    "scripting",
    "activeTab"
  ],

  "background": {
    "service_worker": "background.js"
  },

  "commands": {
    "run-foo": {
      "suggested_key": {
        "default": "Ctrl+Shift+Y",
        "mac": "Command+Shift+Y"
      },
      "description": "Run \"foo\" on the current page."
    }
  }
}
```

Key pieces:

- `"background"` points to `background.js`, which is where you’ll handle the command.
    
- `"permissions": ["scripting", "activeTab"]` let you inject code into the current tab.
    
- `"commands"` defines the shortcut + command name.
    

---

## 4. `background.js`: listen for the command and call your function

Now we create `background.js` and actually **run a function when the shortcut is pressed**.

```js
// background.js

// This is your "foo" function — put your logic here.
async function runFooOnCurrentPage() {
  // Get the active tab in the current window
  const [tab] = await chrome.tabs.query({ active: true, currentWindow: true });
  if (!tab || !tab.id) return;

  // Inject code into the page
  await chrome.scripting.executeScript({
    target: { tabId: tab.id },
    func: () => {
      // This function runs in the page context
      console.log('Foo command triggered!');

      // Example effect: toggle a thick outline around the page
      const existing = document.documentElement.dataset.fooOutlineEnabled === 'true';
      if (existing) {
        document.body.style.outline = '';
        document.documentElement.dataset.fooOutlineEnabled = 'false';
      } else {
        document.body.style.outline = '5px solid red';
        document.documentElement.dataset.fooOutlineEnabled = 'true';
      }
    }
  });
}

// Listen for commands from manifest.json
chrome.commands.onCommand.addListener((command) => {
  if (command === "run-foo") {
    // When the user presses Ctrl+Shift+Y (or Cmd+Shift+Y on Mac),
    // this code runs:
    runFooOnCurrentPage();
  }
});
```

Walkthrough:

- `chrome.commands.onCommand.addListener(...)` fires whenever **any** command for your extension is triggered.
    
- The `command` argument is a string, e.g. `"run-foo"`, which must match the key in `"commands"` in `manifest.json`.
    
- Inside that `if (command === "run-foo")`, you can call any function you want — here we call `runFooOnCurrentPage()`.
    
- `runFooOnCurrentPage` finds the active tab and uses `chrome.scripting.executeScript` to inject some JS into that page (our demo “foo” behavior).
    

So yes: **pressing the shortcut calls your function** (via this event listener).

---

## 5. How to test it in Chrome

1. **Create the files**  
    Put `manifest.json` and `background.js` into a folder (plus any icons).
    
2. **Open the extensions page**  
    Go to `chrome://extensions`.
    
3. **Enable Developer mode**  
    Toggle the “Developer mode” switch on the top right.
    
4. **Load unpacked**  
    Click **“Load unpacked”** and select your folder.
    
5. **Check keyboard shortcut**
    
    - Either use the **suggested shortcut** (e.g. `Ctrl+Shift+Y`).
        
    - Or customize it: click the hamburger menu on `chrome://extensions`, go to **Keyboard shortcuts**, and set/confirm the shortcut for “Run "foo" on the current page.”
        
6. **Try it on any webpage**
    
    - Go to any page.
        
    - Press your shortcut.
        
    - You should see the page outline toggle on/off and a log message in DevTools console.
        

---

## 6. Using multiple commands

You can have several shortcuts, each calling different functions. In `manifest.json`:

```json
"commands": {
  "run-foo": {
    "suggested_key": { "default": "Ctrl+Shift+Y" },
    "description": "Run foo on the current page."
  },
  "run-bar": {
    "suggested_key": { "default": "Ctrl+Shift+U" },
    "description": "Run bar on the current page."
  }
}
```

In `background.js`:

```js
chrome.commands.onCommand.addListener((command) => {
  switch (command) {
    case "run-foo":
      runFooOnCurrentPage();
      break;
    case "run-bar":
      runBarOnCurrentPage();
      break;
  }
});
```

Each shortcut (command) just becomes a different branch in your handler.

---

## TL;DR

- The `"commands"` section in `manifest.json` **defines keyboard shortcuts** and gives them a **command name**.
    
- Your **background script listens** for those commands with `chrome.commands.onCommand.addListener`.
    
- Inside that listener, you **call any function you want**: modify the current page, open a popup, send messages, etc.
    
- Pressing the shortcut → Chrome fires the command event → your handler runs → your function executes.
    

If you tell me what your real “foo” is supposed to do (e.g., “format JSON in the page” or “capture a screenshot”), I can rewrite the code to match your exact use case.