
Let's say you are creating a chrome extension that reads from a web stocks trading page (at tradingview.com). Then opening the chrome extension popup, you get some recommended strategies

---


manifest.json → content.js: For instance, you are injecting javascript into the active page from the chrome extension: Then you need to have a content.js and have that setup at manifest.json:

```
    "content_scripts": [{  
      "matches": ["<all_urls>"],  
      "js": ["content.js"]  
    }],  
```


content.js: 

To allow links to external websites in your extension's popup, you can add the website's domain to the `default-src` directive in the extension's `manifest.json` file. Here's an example `manifest.json` file that allows links to `https://www.example.com`:

```
{  
  "content_security_policy": "default-src 'self' https://tradingview.com/ https://platform.openai.com; script-src 'self', object-src 'self'",  
}
```

For more information on Content Security Policy that whitelists script sources and external links, refer to
Reference reading: Content Security Policy in manifest.json

5. Implement the various parts (eg. popup.html, popup.js, content.js). We add popup into manifest.json so that clicking the chrome extension icon will show a popup over the web browser:
- An action is clicking the Chrome extension:

```
  "browser_action": {  
    "default_popup": "popup.html"  
  }  
```

So the manifest.json file could end up looking like:
```
{
	"name": "My Extension",  
	"version": "1.0",  
	"manifest_version": 2,  
	{  
		"content_security_policy": "default-src 'self' https://tradingview.com/ https://platform.openai.com; script-src 'self', object-src 'self'",  
	},
	"content_scripts": [{  
		"matches": ["<all_urls>"],  
		"js": ["content.js"]  
	}],  
	"browser_action": {  
		"default_popup": "popup.html"  
	}  
}
```

---

You will be passing information from popup to content, and possibly from content back to popup.
Reference reading: [[__Passing information between parts]]



content.js
```
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
```

---
---


  The rest of the code here
  https://github.com/Siphon880gh/stocks-technical-analysis