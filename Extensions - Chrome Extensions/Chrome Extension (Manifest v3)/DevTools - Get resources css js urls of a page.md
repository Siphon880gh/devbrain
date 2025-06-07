
devtools.js:
```
let inspectedWindow = chrome.devtools.inspectedWindow;  
inspectedWindow.getResources(  
    ((resources) => {  
        console.log(`assets_Css_Fonts_Js_Img_etc: ${JSON.stringify(resources)}`);  
        console.log({resources}) // Inspector protocol error: Object reference chain is too long  
    })  
);
```

But it only shows in DevTool’s own console. If you need to show it at web content's main console, at DevTools, you'll have to send the `resources` as part of a message to a background.js which will executeScript on the web content. In the executeScript, instead of writing to the web content html, you can write to the webpage's console by using console log. It's been implemented in one of our level up tutorials: [[7. Walkthrough - DevToolsPanel with Inspected Window to Get Content Resources]]