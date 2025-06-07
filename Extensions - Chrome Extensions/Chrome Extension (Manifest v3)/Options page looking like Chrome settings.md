Let's make your **Options page** look like native **Chrome settings** (like `chrome://settings`). That means: minimal, clean, lots of whitespace, subtle shadows, and Roboto font with light grays and blues.

---

## 🧭 Overview of Chrome Settings Aesthetic

- **Font**: Roboto, same as popup
- **Spacing**: Generous padding, consistent vertical rhythm
- **Headers**: Medium-bold, gray
- **Input controls**: Flat look, slight rounding
- **Colors**: Background `#f1f3f4`, text `#3c4043`, primary blue `#1a73e8`
- **Toggle switch styles**, checkboxes, and subtle section dividers

---

## 1. **CSS for Chrome-like Settings Page**

```css
/* Base font and layout */
body {
	font-family: 'Roboto', Arial, sans-serif;
	font-size: 14px;
	color: #3c4043;
	background-color: #f1f3f4;
	margin: 0;
	padding: 24px;
	min-width: 90vw;
	height: fit-content;
  }
  
  /* Section block */
  .settings-section {
	background: #fff;
	border-radius: 8px;
	padding: 16px 20px;
	margin-bottom: 20px;
	box-shadow: 0 1px 3px rgba(60, 64, 67, 0.15);
  }
  
  /* Section titles */
  .settings-section h2 {
	font-size: 16px;
	font-weight: 500;
	margin-bottom: 12px;
	color: #202124;
  }
  
  /* Labels */
  .settings-label {
	display: flex;
	justify-content: space-between;
	align-items: center;
	margin: 12px 0;
  }
  
  /* Checkbox + Text */
  .settings-label input[type="checkbox"] {
	transform: scale(1.2);
	accent-color: #1a73e8;
  }
  
  /* Toggle Switch Base */
.switch {
	position: relative;
	display: inline-block;
	width: 36px;
	height: 20px;
  }
  
  .switch input {
	opacity: 0;
	width: 0;
	height: 0;
  }
  
  /* Slider */
  .slider {
	position: absolute;
	cursor: pointer;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	background-color: #dadce0;
	transition: 0.3s;
	border-radius: 999px;
  }
  
  .slider:before {
	position: absolute;
	content: "";
	height: 14px;
	width: 14px;
	left: 3px;
	top: 3px;
	background-color: white;
	transition: 0.3s;
	border-radius: 50%;
  }
  
  /* Checked State */
  input:checked + .slider {
	background-color: #1a73e8;
  }
  
  input:checked + .slider:before {
	transform: translateX(16px);
  }
  
  /* Text Input */
  .settings-label input[type="text"] {
	padding: 6px 10px;
	border: 1px solid #dadce0;
	border-radius: 4px;
	font-size: 14px;
	width: 100%;
	max-width: 200px;
  }
  
  /* Save button */
  button.save-btn {
	background-color: #1a73e8;
	color: white;
	border: none;
	padding: 8px 16px;
	border-radius: 4px;
	font-weight: 500;
	cursor: pointer;
  }
  
  button.save-btn:hover {
	background-color: #1765cc;
  }

```

---

## 2. **HTML Structure for the Options Page**

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Extension Settings</title>
  <link rel="stylesheet" href="options.css" />
</head>
<body>
<div class="settings-label">
    <label for="darkMode">Enable Dark Mode</label>
    <label class="switch">
        <input type="checkbox" id="darkMode">
        <span class="slider"></span>
    </label>
    </div>

  <div class="settings-section">
    <h2>User Preferences</h2>
    <div class="settings-label">
      <label for="username">Display Name</label>
      <input type="text" id="username" placeholder="Your name" />
    </div>
  </div>

  <button class="save-btn" id="saveBtn">Save Settings</button>

  <script src="options.js"></script>
</body>
</html>
```

---

## 3. **JavaScript to Handle Options Storage (`options.js`)**

```js
// Load saved settings
document.addEventListener('DOMContentLoaded', function () {
	chrome.storage.sync.get(['darkMode', 'username'], function (result) {
	  document.getElementById('darkMode').checked = result.darkMode || false;
	  document.getElementById('username').value = result.username || '';
	});
});

// Save settings
document.getElementById('saveBtn').addEventListener('click', function () {
	const darkMode = document.getElementById('darkMode').checked;
	const username = document.getElementById('username').value;
	
	chrome.storage.sync.set({ darkMode, username }, function () {
	  alert('Settings saved.');
	});
});
```

---

### ✅ Final Result:

Your Options page now:

- Looks like Chrome’s built-in settings
- Automatically loads and saves settings via `chrome.storage.sync` (Across all your devices with the same Google Chrome user signed in).
- Adapts nicely to user-friendly layout expectations

If you're testing this, here's manifest.json:
```
{  
    "manifest_version": 3,  
    "name": "<APP_NAME>",  
    "version": "1.0",  
    "description": "<APP_DESCRIPTION>.",  
    "author": "Weng Fei Fung",
    "icons": {  
        "16": "icon16x16.png",  
        "32": "icon32x32.png",  
        "48": "icon48x48.png",  
        "128": "icon128x128.png"  
    },
    "content_security_policy": {  
        "extension_pages": "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self'; object-src 'self';"
    },
    "host_permissions": [
        "https://*/*",
        "http://*/*"
    ],
    "permissions": [
        "storage", "tabs", "activeTab"
    ],
    "options_ui": {
      "page": "options.html",
      "open_in_tab": false
    }
}
```

And don't forget to generate the icon set (which you've learned at the level up series).

Your options page should look like:
![[Pasted image 20250405035529.png]]

---

Challenge: Add more setting types like dropdowns, radio buttons, or toggle switches styled like Chrome’s Material toggles.