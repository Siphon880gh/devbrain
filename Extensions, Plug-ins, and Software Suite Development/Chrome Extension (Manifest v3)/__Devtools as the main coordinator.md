You can either use devtools.js or background.js to coordinate between different parts of the extension. As for devtools.js, here are the rules:

devtools.html is entry point from manifest.json to access devtools.js
devtools.js has direct access to creating panel or creating sidebar, and their querySelectors upon creating
 - (sidebar is the secondary panel of a primary panel)
 - if using panel.document.querySelector, or sidebar.document.querySelector, it’s used inside onShown
 eg. 
```
chrome.devtools.panels.elements.createSidebarPane("Design Templates", (mySidebar) => {
    mySidebar.setPage('sidebar.html')

    mySidebar.onShown.addListener(function(sidebarWindow) {
	    sidebar = sidebarWindow;
    });
}); // created sidebar
```

- But if you need to use elsewhere, you save globally. Globally you had a let sidebar = null 
- Same applies to panel

---

devtools.js does not have direct access to webpage content. You can however inspectWindow.eval expressions, either on selected element with DevTools panel/sidebar opened

- here’s getting textContent of a selected element (Inspect Element)
```
chrome.devtools.panels.elements.onSelectionChanged.addListener((info) => {
    chrome.devtools.inspectedWindow.eval("$0.textContent", (result, isException) => {
        if (isException) {
            return;
        }
        console.log(textContent)
    })
}        
```

- here’s getting textContent of a particular element by querying
```
chrome.devtools.panels.elements.onSelectionChanged.addListener((info) => {
    chrome.devtools.inspectedWindow.eval("document.querySelector('#info-box').textContent", (result, isException) => {
        if (isException) {
            return;
        }
        console.log(textContent)
    })
}   
```

You cannot invoke functions at devtools.js that were defined at content.js (reminder: content.js is injected into the webpage content if you have manifest.json to do so or you have a trigger from a devtools page (either panel.html or sidebar.html).