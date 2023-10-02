## If you prefer a more interactive approach, get guided by Copilot

[https://github.blog/2023-05-12-how-i-used-github-copilot-to-build-a-browser-extension/](https://github.blog/2023-05-12-how-i-used-github-copilot-to-build-a-browser-extension/)  

  
---

## Instructions

  

1. Open Chrome Extensions page so you can install/reinstall your chrome extension as it’s being developed. Make sure “Developer Mode” on.


<details>
<summary>Details</summary>

[chrome://extensions](chrome://extensions)  

Or: Chrome → ... -→ More Tools → Extensions. Make sure "Developer mode" is on at the top right  

![](https://i.imgur.com/P89AAGz.png)

</details>


2. Decide on what parts you’ll need (popup, content, background, devtools).

Reference Reading: Popup, content, background, devtools

Create manifest.json which will include your Content Security Policy rules which are often needed for your popup.html, the webpage your chrome activated on, etc to load in a .js file even if it’s from the chrome extension

<details>  
<summary>File Structure</summary>  
Bare minimum example:
manfiest.json
popup.js
popup.html
content.js

More fleshed out:
![](https://i.imgur.com/10ajaTK.png)

</details>


manifest.json:
```
{  
    "manifest_version": 3,  
    "name": "Stocks Technical Analysis",  
    "version": "1.0",  
    "description": "Feed TradingView's superchart into AI to recognize candlestick patterns and indicators right away.",  
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
        "extension_pages": "default-src 'self' https://tradingview.com/ https://platform.openai.com https://camo.githubusercontent.com https://www.linkedin.com https://www.youtube.com; script-src 'self'; object-src 'self'; style-src 'self' 'unsafe-inline';"  
    },  
    "action": {  
        "default_icon": "icon.png",  
        "default_popup": "popup.html"  
    },  
    "permissions": [  
        "activeTab",  
        "tabs"  
    ],  
    "author": "Weng Fei Fung"  
}
```


  

manifest.json → popup:   

You need to set the html file that opens over the Chrome browser when you click the Chrome Extension. At manifest.json:

    "action": {  
        "default_icon": "icon.png",  
        "default_popup": "popup.html"  
    },

You have a popup.html and popup.js? You have to enable running code from popup.js. For version 3 manifest:

    "content_security_policy": {  
        "extension_pages": "script-src 'self'; object-src 'self';"  
    },  

  
Links in popup.html are blocked by Chrome. How to allow? Hint: See how I enabled links for content.js
  

manifest.json → content.js: For instance, you are injecting javascript into the active page from the chrome extension: Then you need to have a content.js and have that setup at manifest.json:

    "content_scripts": [{  
      "matches": ["<all_urls>"],  
      "js": ["content.js"]  
    }],  

  

content.js: 

To allow links to external websites in your extension's popup, you can add the website's domain to the `default-src` directive in the extension's `manifest.json` file. Here's an example `manifest.json` file that allows links to `https://www.example.com`:

{  
  "name": "My Extension",  
  "version": "1.0",  
  "manifest_version": 2,  
  "content_security_policy": "default-src 'self' https://tradingview.com/ https://platform.openai.com; script-src 'self', object-src 'self'",  
  "browser_action": {  
    "default_popup": "popup.html"  
  }  
}

For more information on Content Security Policy that whitelists script sources and external links, refer to
Reference reading: Content Security Policy in manifest.json

Appearance of popup.html:

You can set the popup.html’s width controlling how it appears when the extension icon is clicked and a popover modal appears


```
<style>  
body {  
  width: 400px;  
}  
<style>  
```

  

But if you want scrolling inside a popup modal with a smaller height:
    
```
<style>  
	html, body {  
		height: 270px;  
		max-height: 270px;  
		overflow-y:scroll;  
	}  
	html {  
		width: 315px;  
	}  
	body {  
		width: 300px;  
		text-align: center;  
	}  
</style>  
```


^/^^ dont forget you’ll have to enable self permissions for style-src in manifest.json



4. Decide on an icon at flaticon and download biggest 128x128:
https://www.flaticon.com/free-icon/candlestick-chart_6353961?term=candlestick&page=1&position=6&origin=search&related_id=6353961

Run this command on your 128x 128 to generate various sized icons:
convert icon.png -resize 16x16 icon-16.png

For:
icon16x16.png
icon32x32.png
icon48x48.png
icon128x128.png

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