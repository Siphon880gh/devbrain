
manifest.json (may be too much unrelated):
```
{
    "name": "Design Tailwind Bootcamp Components into Inspect Element",
    "description": "Add tailwind and/or bootcamp components into Inspect Elements even if a webpage does not support tailwind. In the future, various components will be selectable.",
    "manifest_version": 3,
    "version": "1.0",
    "icons": {
        "16": "icon16x16.png",
        "32": "icon32x32.png",
        "48": "icon48x48.png",
        "128": "icon128x128.png"
    },
    "content_security_policy": {
        "extension_pages": "default-src 'self' https://wengindustry.com'; script-src 'self'; object-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' *; connect-src 'self' https://wengindustry.com"
    },
    "permissions": [
        "activeTab",
        "tabs",
        "debugger",
        "scripting",
        "system.memory",
        "storage",
        "webNavigation",
        "webRequest"
      ],
    "host_permissions": [
        "https://wengindustry.com/",
        "http://*/*",
        "https://*/*",
        "<all_urls>"
    ],
    "action": {
        "default_icon": "icon.png",
        "default_popup": "popup.html"
    },
    "content_scripts": [
        {
            "matches": ["<all_urls>"],
            "js": ["content-enable-external-img.js"],
            "run_at": "document_start"
        }
    ],
    "devtools_page": "devtools.html"
}
```

sidebar:
```
fetch('https://wengindustry.com/main/engine/chrome-templates/')
    .then(response => {
        if(!response.ok) {
            console.error("Error fetching templates.html");
            console.error(response.status);
            console.error(response.statusText);
        }
        return response.text()
    })
    .then(html => {
        document.querySelector("#template-list").innerHTML = html;
        redrawTemplateList();
    })
```

I've also enabled CORS at the index.php header at wengindustry