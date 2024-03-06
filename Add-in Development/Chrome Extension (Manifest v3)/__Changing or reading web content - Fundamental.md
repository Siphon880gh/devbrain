You can either do this through devtool.js's inspectedWindow (and the naming makes sense because if you had DevTools opened, then that DevTools is inspecting your current webpage for more information, so the webpage is the Inspected window object)

**Or** you can do it through content.js (as long as that's setup to run from manifest.js onto the URL or wildcarded URL)

APPROACH: DevTool.js inspectedWindow:
```
/* SECTION: Panel.html */
let panel = null;
let panelWindow;
chrome.devtools.panels.create("Design Aspects Identifier", "icon.png", "panel.html", panel => {

    // code invoked on panel creation
    panel.onShown.addListener((window) => {
        panelWindow = window;
        
            chrome.devtools.inspectedWindow.eval(`
                document.body.querySelector("#info").textContent;
            `, (result, isException) => {
                
                if (isException) {
            
                    console.error(isException);
                }
                
                console.log(result); // console log the textContent to devtool's own instance of console
                panelWindow.document.querySelector("#report-info").textContent = result // to panel.html inside DevTools
        });
    });

});
```

^ downside is that any console log would go into the panel or sidebar's own console instead of the website content's console

^ To read webpage content into devtools.js, you can use the inspectedWindow.eval's second parameter for callback that receives a result (whatever is expressed in the eval expression first parameter, no need to write `return`). Remember it's the console.log of a panel or sidebar (devtool.js' instance of console, and not the web content's console).

^You can also change the webpage content here at the eval expression. Like `document.body.querySelector("#info").textContent = 'New text'`

Running functions from devtool.js' devtools.inspectedWindow? Yes you can run alert. No, you cannot run functions you defined from panel.js at devtools.js. Reworded: The `chrome.devtools.inspectedWindow` API provides methods to interact with the inspected window (the page being debugged); However, it doesn't directly access functions defined in your DevTools extension's panel script (`panel.js` or whatever you've named it).


OR APPROACH: content.js

manifest.json:
```
    "content_scripts": [
        {
            "matches": ["<all_urls>"],
            "js": ["content.js"],
        }
    ],
```

content.js:
```
document.querySelector("#btn").addEventListener("click", ()=>{
	alert("clicked")
});
```