
## Instructions

1. Open Chrome Extensions page so you can install/reinstall your chrome extension as it’s being developed. Make sure “Developer Mode” on.

>[!note] Details
>Open in address bar: chrome://extensions
>Or: Chrome → ... -→ More Tools → Extensions. 
>
>Make sure "Developer mode" is on at the top right:
>![](P89AAGz.png)
>
>Decide on what parts you’ll need (popup when clicking extension, content, background, devtools sidebar, devtools panel).
>^ You can think of popup as popover because it's a HTML panel that appears over the top near where you clicked the pinned extension icon on Chrome

---


POPUP (Without Foundational - Quick Tutorial) - __Will split out

---


POPUP and Foundational
Reference Reading: Popup, content, background, devtools

Create manifest.json among other files which will be the popup html, css, js. Create also content.js to modify/read from the current webpage on the web browser.

>[!note] File Structure
>Bare minimum example:
>-manfiest.json
>-popup.js
>-popup.html
>-content.js
> 
> More fleshed out:
> ![](10ajaTK.png)
 

manifest.json for a popup (for learning foundations):
- Manifest version 3. Version 2 is on the way out. This is syntax and language Chrome Extension will use.
- Include your app name, version and description (affects Chrome extension store) and icons to show on the web browser pinned extensions area, the Google chrome extension store, etc.
- Includes Content Security Policy rules which is permission and scoping. Google is now focused on making chrome extensions more secured and less risky to add.
- Sections of markup for the type of panels/sidebars/pages that your chrome extension uses.
- For our purpose of learning foundations we will in this tutorial cover popup and content
	- popup (official name) is the popover small html ui that shows up after clicking a chrome extension icon that's pinned at the top of chrome. 
	- content or content js is the logic of reading from or writing to the webpage that's on the web browser. The manifest.json will have matching url pattern so it doesn't run on just any webpage you visit. Content code does not need the user to click the chrome extension to run - it will run automatically. Proof: If you have many chrome extensions that are enabled, visit a webpage and inspect, and you'll likely see chrome extension related code in the HTML. The manifest.json also points to your file that has the content logic (by convention, content.js)
	
manifest.json:
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
    "content_scripts": [{  
      "matches": ["<all_urls>"],  
      "js": ["content.js"]  
    }],  
    "content_security_policy": {  
        "extension_pages": "default-src 'self' https://google.com/; script-src 'self'; object-src 'self'; style-src 'self' 'unsafe-inline';"  
    },  
    "action": {  
        "default_icon": "icon.png",  
        "default_popup": "popup.html"  
    },  
    "permissions": [  
        "activeTab",  
        "tabs"  
    ]
}
```


  

manifest.json → popup:   

You need to set the html file that opens over the Chrome browser when you click the Chrome Extension. At manifest.json:

    "action": {  
        "default_icon": "icon.png",  
        "default_popup": "popup.html"  
    },

You have a popup.html and popup.js? You have to enable running code from popup.js.:

    "content_security_policy": {  
        "extension_pages": "script-src 'self'; object-src 'self';"  
    },  

  
Links in popup.html are blocked by Chrome. How to allow? Hint: See how I enabled links for content.js
  

manifest.json → content.js: For instance, you are injecting javascript into the active page from the chrome extension: Then you need to have a content.js and have that setup at manifest.json:

    "content_scripts": [{  
      "matches": ["<all_urls>"],  
      "js": ["content.js"]  
    }],  

  

popup.html:
```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup</title>
    <link rel="stylesheet" href="popup.css">
    
    <style>
	body {
	    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
	}
	</style>
</head>

<body>
    <h1>YOUR_APP</h1>

    <main>
        <div>
            By Weng:
        </div>

        <aside>
            <a target="_blank" href="https://www.github.com/Siphon880gh/" rel="nofollow">
                <img src="https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white"
                    data-canonical-src="https://img.shields.io/badge/GitHub-100000?style=for-the-badge&amp;logo=github&amp;logoColor=white"
                    style="max-width: 100%; height:20px;">
            </a>
            <a target="_blank" href="https://www.linkedin.com/in/weng-fung/" rel="nofollow">
                <img src="https://img.shields.io/badge/LinkedIn-blue?style=flat&logo=linkedin&labelColor=blue"
                    alt="Linked-In"
                    data-canonical-src="https://img.shields.io/badge/LinkedIn-blue?style=flat&amp;logo=linkedin&amp;labelColor=blue"
                    style="max-width:100%;">
            </a>
            <a target="_blank" href="https://www.youtube.com/@WayneTeachesCode/" rel="nofollow">
                <img src="https://img.shields.io/badge/Youtube-red?style=flat&logo=youtube&labelColor=red" alt="Youtube"
                    data-canonical-src="https://img.shields.io/badge/Youtube-red?style=flat&amp;logo=youtube&amp;labelColor=red"
                    style="max-width:100%;">
            </a>
        </aside>

        <div class="spacer-vertical"></div>
        <h2>TITLE:</h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus hic sit libero? Excepturi, optio aut reiciendis doloremque tempore, iste harum aspernatur et, officiis earum aliquam. Quibusdam cum nostrum quos commodi?</p>
    

        <div class="spacer-vertical"></div>
        <button id="change-style">Alert me</button>

        <div class="spacer-vertical"></div>
        <a href="popup2.html">Popup2.html</a>

        <script src="popup.js"></script>
    </main>
</body>

</html>
```

content.js: 

To allow links to external websites in your extension's popup, you can add the website's domain to the `default-src` directive in the extension's `manifest.json` file. Here's an example `manifest.json` file that allows links to `https://www.example.com`:

```
{  
  "name": "My Extension",  
  "version": "1.0",  
  "manifest_version": 2,  
  "content_security_policy": "default-src 'self' https://tradingview.com/ https://platform.openai.com; script-src 'self', object-src 'self'",  
  "browser_action": {  
    "default_popup": "popup.html"  
  }  
}
```

For more information on Content Security Policy that whitelists script sources and external links, refer to
Reference reading: Content Security Policy in manifest.json

4. Appearance of popup.html:

popup.css:
```
.spacer-vertical {
    margin-top: 11px;
}
```

style block... refer to popup.html but as a brief recall:
```
<style>
body {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}
</style>
```

You can have style block or link tag to a css file (popup.css) but forget you’ll have to enable self permissions for style-src in manifest.json

4. Icons
You must have icon sets (differently sized icons) for your chrome extension to even be allowed to be installed. You can create the icon, and then use system's ImageMagick convert to create the other dimensions. OR you can use npm package sharp-cli to create an icon set of black squares.

If you dont have icons, the installation will fail with the error:
![[Pasted image 20250319004613.png]]

OR METHOD A: Decide on an icon at flaticon and download biggest 128x128:
https://www.flaticon.com/free-icon/candlestick-chart_6353961?term=candlestick&page=1&position=6&origin=search&related_id=6353961

Run this command on your 128x 128 to generate various sized icons:
```
convert icon.png -resize 16x16 icon-16.png
```

For:
icon16x16.png
icon32x32.png
icon48x48.png
icon128x128.png


OR METHOD B: Use npm package sharp-cli to create an icon set of black squares.

You'll make a folder, go into it to initiate a npm project, then install sharp-cli, then run nodejs code at the terminal to generate the multiple icon files:

```
mkdir generate_icons  
cd generate_icons  
npm install -y  
npm install sharp-cli  
node -e "const fs = require('fs'); const sharp = require('sharp'); [16,32,48,128].forEach(size => sharp({ create: { width: size, height: size, channels: 4, background: 'black' } }).png().toFile(\`icon\${size}x\${size}.png\`));"  
  
cp icon16x16.png icon.png
```

It’ll create icon files:
```
.  
├── icon128x128.png  
├── icon16x16.png  
├── icon32x32.png  
├── icon48x48.png  
├── node_modules  
├── package-lock.json  
└── package.json
```

An icon file may look like:
![[Pasted image 20250319003015.png]]

Copy the icon files to your chrome extension app folder

5. Implement the various parts (eg. popup.html, popup.js, content.js):

popup.html:
how the popup modal that appears on top of the Chrome extension looks. It would have a script src to popup.js at the same folder of the chrome extension code

// popup.js

    // Add event listener to button that prompts AI and gets insights to user  
    document.querySelector("#stock-insights-go").addEventListener("click", (e) => {  
        chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {  
            // Test URL is at tradingview.com  
            chrome.tabs.sendMessage(tabs[0].id, {type:"testURL", data: {}}, function(response) {  
                if(chrome.runtime.lastError) {  
                    console.error(chrome.runtime.lastError);  
                } else {  
                    console.log(response.data);  
                    if(response.data.toUpperCase().includes("PASSES")) {  
                        console.log("Successfully found tradingview.com, now scraping, querying AI, and reporting trade insights to user");  
                    } else {  
                        console.log("Failed")  
                    }  
                }  
            });  
        }); // chrome tabs  
    }); // event listener  

  

content.js

chrome.runtime.onMessage.addListener(async function(request, sender, sendResponse) {  
    switch(request.type) {  
        case "testAPIKey":  
  
            localStorage.setItem("ce__stocks_api_key", request.data);  
            appWFStocks.API_KEY = openAiApiKey;  
  
            //console.log(request.data); // This will log to the main page’s console. It's the API key.  
            sendResponse({data:"Success: Popup.js sent API Key to content.js where the scraper and AI prompter is housed"});  
            break;  
        case "testURL":  
            if(!window.location.href.toLowerCase().includes("tradingview.com")   
            || !window.location.href.toLowerCase().includes("/chart/")) {  
                sendResponse({data:"FAILS"});  
                alert("Please navigate to a TradingView chart page to use this extension.");  
            } else {  
  
                // Test API Key again  
                var openAiApiKey = localStorage.getItem("ce__stocks_api_key");  
                if(openAiApiKey) {  
                    appWFStocks.API_KEY = openAiApiKey;  
                    sendResponse({data:"PASSES"});  
                } else {  
                    alert("Critical Error: Please enter your OpenAI API Key in the extension.")  
                    sendResponse({data:"FAILS"});  
                    return;  
                }  
  
                // Offload scraping, AI querying, and reporting to content  
                loadingAnimation(true);  
                var [datasets, symbol] = await userJobsToDo();  
                console.log({datasets, symbol})  
                await promptAI(datasets, symbol);  
                loadingAnimation(false);  
  
            } // testURL  
            break;  
    } // switch  
});

You will be passing information from popup to content, and possibly from content back to popup.
Reference reading: Passing information between parts
  

6. When debugging / refreshing the chrome extension:

  

- When debugging background scripts, content scripts, popup scripts, and devtools all have different Developer Tools instances. So, always make sure to open the Developer Tools for the correct context when debugging different parts of your extension. For example, you’d right click → inspect → console on the popup modal for popup.js errors, not content.js errors.
- You have to refresh the page when changing content.js for things to reflect

- You may want to clear Errors if an Errors button appear for the extension at the Extensions page before dropping a newer copy of the folder. It preserves previous errors from console. Then you’ll know if there are fresh errors when you re-run the chrome extension.
- Suggested workflow: Leave one Chrome tab opened to extensions. Have Finder/explorer showing the folder of your code. You could run `open .`  or `explorer .`  from VS Code’s integrated terminal, then go up a directory if required (CMD+Up on Mac). You’ll drag and drop between the chrome window and the window of the folder.

---

When updating the Chrome extension:

You’ll drag and drop between the chrome window and the window of the folder.
No need to remove the old chrome extension first.
It will not prompt you that it got updated or replaced.

---
---

Drag and drop into chrome extensions to install:

![[Chrome-Extension-Drag-Drop.gif]]

---

After drag and drop installing the chrome extension, see if popup images load:
![[Pasted image 20250319002125.png]]


You'd inspect the chrome extension's popup HTML, by right clicking inside the popup and going to Inspect:

![[Chrome-Extension-Popup-Inspect.gif]]

You may see images blocked from other origins:
![[Pasted image 20250319002238.png]]

---


Let's add ability to have multiple pages in the popup:

Create a popup2.html

Have popup.html link to it. Place some spacing and a link to popup2.html above popup.js script tag (Add two lines):
```
<div role="spacer-vertical" style="margin-top:11px"></div>
<a href="popup2.html">Popup2.html</a>


<script src="popup.js"></script>
```

At popup2.html, it'll have a link back to popup.html and the Lorem text changes to all caps so you can visually see the page changed

popup2.html:
```
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup</title>
    <link rel="stylesheet" href="popup.css">
</head>

<body>
    <h1>YOUR_APP</h1>

    <main>
        <div>
            By Weng:
        </div>

        <aside>
            <a target="_blank" href="https://www.github.com/Siphon880gh/" rel="nofollow">
                <img src="https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white"
                    data-canonical-src="https://img.shields.io/badge/GitHub-100000?style=for-the-badge&amp;logo=github&amp;logoColor=white"
                    style="max-width: 100%; height:20px;">
            </a>
            <a target="_blank" href="https://www.linkedin.com/in/weng-fung/" rel="nofollow">
                <img src="https://img.shields.io/badge/LinkedIn-blue?style=flat&logo=linkedin&labelColor=blue"
                    alt="Linked-In"
                    data-canonical-src="https://img.shields.io/badge/LinkedIn-blue?style=flat&amp;logo=linkedin&amp;labelColor=blue"
                    style="max-width:100%;">
            </a>
            <a target="_blank" href="https://www.youtube.com/@WayneTeachesCode/" rel="nofollow">
                <img src="https://img.shields.io/badge/Youtube-red?style=flat&logo=youtube&labelColor=red" alt="Youtube"
                    data-canonical-src="https://img.shields.io/badge/Youtube-red?style=flat&amp;logo=youtube&amp;labelColor=red"
                    style="max-width:100%;">
            </a>
        </aside>

        <div class="spacer-vertical"></div>
        <h2>Title:</h2>
        <p>LOREM IPSUM DOLOR SIT AMET CONSECTETUR ADIPISICING ELIT. REPELLENDUS HIC SIT LIBERO? EXCEPTURI, OPTIO AUT
            REICIENDIS DOLOREMQUE TEMPORE, ISTE HARUM ASPERNATUR ET, OFFICIIS EARUM ALIQUAM. QUIBUSDAM CUM NOSTRUM QUOS
            COMMODI?</p>

        <div class="spacer-vertical"></div>
        <button id="change-style">Alert me</button>

        <div class="spacer-vertical"></div>
        <a href="popup.html">Popup.html</a>

        <script src="popup.js"></script>
    </main>
</body>

</html>
```


---
---


As proof that popup is its own html, you can inspect the code of any chrome extension you pin. Take a look at Awesome Screenshot's html being inspected and us changing the popup style using javascript:
![[Chrome-Extension-Popup-Inspect.gif]]

By the way, you could've also changed the Awesome Screenshot chrome extension backgound to green if you edited the Sidepanel "Styles" after selecting the element "<body.." at the Element panel.

---

Popup 

Tabbars. There's no tab bar component or anything from Chrome extension. It's all CSS and HTML.

![[Pasted image 20250318220914.png]]

