
## Basics

To make your Chrome extension popup look like a native Chrome menu, follow these steps:

### 1. **Mimicking Chrome’s UI with CSS**

Apply styles that match Chrome’s menu:

```css
/* Use Chrome's default font */
body {
  font-family: 'Roboto', Arial, sans-serif;
  font-size: 13px;
  color: #3c4043;
  background: #fff;
  margin: 0;
  padding: 8px;
  min-width: 200px;
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
  border-radius: 8px;
  border: 1px solid rgba(0, 0, 0, 0.1);
}

/* Menu item styling */
.menu-item {
  display: flex;
  align-items: center;
  padding: 8px 12px;
  border-radius: 4px;
  cursor: pointer;
}

.menu-item:hover {
  background: rgba(0, 0, 0, 0.1);
}

/* Separator */
.menu-separator {
  height: 1px;
  background: rgba(0, 0, 0, 0.1);
  margin: 6px 0;
}
```

---

### 2. **HTML for a Chrome-like Popup Menu**

Create a simple HTML popup:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chrome-Like Popup</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="menu">
        <div class="menu-item">Option 1</div>
        <div class="menu-item">Option 2</div>
        <div class="menu-separator"></div>
        <div class="menu-item">Settings</div>
        <div class="menu-item">About</div>
    </div>
</body>
</html>
```

---

### 3. **Dynamic Theme Adaptation (Optional)**

To match Chrome’s theme, use the `chrome.theme` API

```js
chrome.theme.getCurrent((theme) => {
    if (theme && theme.colors) {
        document.body.style.background = `rgb(${theme.colors.frame.join(",")})`;
    }
});
```

---

### 4. **Making the Popup Floating & Natural**

To ensure the popup behaves more like a Chrome menu:

- Use `min-width` instead of `width` so it auto-adjusts.
- Avoid `overflow: auto;` unless necessary.
- Ensure a smooth, native-looking shadow.

---

## Night/Day Theming

#### **1. Match System Theme (`prefers-color-scheme`)**

- If your goal is to adapt to dark or light mode, you can use CSS:
    
    ```css
    @media (prefers-color-scheme: dark) {
        body {
            background: #202124;
            color: #e8eaed;
        }
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }
    }
    ```
    

#### **2. Try `chrome.storage.sync` to Save a User’s Preferred Theme**

- Since you **cannot** get Chrome’s theme, you can **let the user select their theme** in your popup settings and store it.
    
    ```js
    chrome.storage.sync.get(['theme'], function (result) {
        if (result.theme === 'dark') {
            document.body.classList.add('dark-mode');
        }
    });
    ```
    
    Then, in CSS:
    
    ```css
    .dark-mode {
        background: #202124;
        color: #e8eaed;
    }
    ```
    
