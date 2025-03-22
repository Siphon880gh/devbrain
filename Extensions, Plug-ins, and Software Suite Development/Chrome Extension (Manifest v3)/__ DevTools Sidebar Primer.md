
To create a new sidebar (aka secondary panel) and it would be next to Styles, Computed, Layout etc if the primary tab is on the Elements tab, you need to use the chrome.devtools.panels.elements API.

Here is an example:

```js
// Background page

chrome.devtools.panels.elements.createSidebarPane("My Sidebar", 
  function(sidebar) {

  // Panel content
  const panel = document.createElement('div');
  panel.textContent = 'My sidebar content';

  sidebar.setPage('panel.html')
  sidebar.setHeight('100px');

  sidebar.onShown.addListener(function() {
    sidebar.setObject({someObject: true});
  });

});
```

The key points:

- Use `chrome.devtools.panels.elements` to target the Elements panel specifically.
- Call `createSidebarPane()` on it and give the pane a title.
- The callback gives you a `sidebar` object to configure the pane.
- Set the content by providing a HTML page in `setPage()`.
- Use `setHeight()` to set height.
- `onShown` listener to know when visible.
Just like you have object details of Event Listeners etc on an Element you inspected, that’s what `
  sidebar.onShown.addListener(function() {
    sidebar.setObject({someObject: true});
  });` does

- Use `setObject()` to pass data.

This will create a new sidebar pane in the Elements panel, along with the existing ones like Styles, Computed etc. You can add multiple panes by calling `createSidebarPane()` multiple times.

Let me know if you need any clarification on creating extensions for the DevTools Elements panel!


---


manifest.json:
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
        "extension_pages": "default-src 'self' https://cdn.tailwindcss.com; script-src 'self'; object-src 'self'; style-src 'self' 'unsafe-inline';"
    },
    "permissions": [
        "system.memory",
        "activeTab",
        "tabs"
    ],
    "action": {
        "default_icon": "icon.png",
        "default_popup": "popup.html"
    },
    "content_scripts": [{
      "matches": ["<all_urls>"],
      "js": ["content.js"]
    }],
    "devtools_page": "devtools.html"
}
```

Bare minimum:
```
{
    "name": "Design Tailwind Bootcamp Components into Inspect Element",
    "description": "Description.",
    "manifest_version": 3,
    "version": "1.0",
    "content_security_policy": {
        "extension_pages": "default-src 'self'; script-src 'self'; object-src 'self'; style-src 'self' 'unsafe-inline';"
    },
    "permissions": [
        "system.memory",
        "activeTab",
        "tabs"
    ],
    "devtools_page": "devtools.html"
}
```

Also bare minimum: 
you need a panel.html that shows up to the developer in DevTools panels

And you need a devtools.js:
This example shows you the memory stats
```
let availableMemoryCapacity;
let totalMemoryCapacity;
let panel; // so you can manipulate from an elements subpanel, for example

chrome.devtools.panels.create("Sample Panel", "icon.png", "panel.html", panel => {
    panel = panel;
    // code invoked on panel creation
    panel.onShown.addListener((extPanelWindow) => {
        availableMemoryCapacity = extPanelWindow.document.querySelector('#availableMemoryCapacity');
        totalMemoryCapacity = extPanelWindow.document.querySelector('#totalMemoryCapacity');
    });
});

setInterval(() => {
    chrome.system.memory.getInfo((data) => {
        if (availableMemoryCapacity) {
            availableMemoryCapacity.innerHTML = data.availableCapacity;
        }
        if (totalMemoryCapacity) {
            totalMemoryCapacity.innerHTML = data.capacity;
        }
    });
}, 1000);
```





---



Commonly will need

Re-dropped the extension into extension page? On the webpage you had DevTools panel opened for testing, you’re going to close that DevTools, refresh the page, click your extension icon, then re-open the DevTools.



Extending Inspect Element

The chrome.devtools.panels.onSelectionChanged event is triggered when the user selects or inspects a different element in the page while the DevTools panel is open.

It will NOT be triggered in these cases:

- Switching to a different DevTools panel (e.g. going from Elements to Console).
- Selecting a different iframe or window.
- Reloading the inspected page.
- Clicking inside the DevTools panel itself, but not selecting a new element.

So in summary:

- The event fires when selecting new elements in the page.

- It does not fire when changing DevTools tabs or panels.

- It also does not fire for selections within the DevTools UI itself.

One thing to note is that the selected element may not actually be visually highlighted yet when onSelectionChanged fires. So your panel may need to wait for the next tick before reading values from the newly selected element.

Let me know if this helps explain when this event does and does not get triggered!


----


No, in Manifest V3 (MV3) of Chrome Extensions, the <all_urls> permission is not used in the "permissions" field as it was in Manifest V2 (MV2). Instead, in MV3, you use the host_permissions field to specify host access.
Here's how you can request access to all URLs in Manifest V3:
json
Copy code
{ "manifest_version": 3, "host_permissions": [ "<all_urls>" ], ... }
The host_permissions field in MV3 replaces both the permissions and optional_permissions fields from MV2 for specifying host access. This change was made to simplify and clarify the permissions model in MV3.
Always ensure that you're referencing the latest official Chrome Extension documentation when working with MV3, as there have been several changes from MV2.