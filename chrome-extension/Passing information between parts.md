
### Principles of passing information between parts

You can pass messages from your popup script to your content script, and then log those messages to the console of the main webpage (the content script's execution environment). To achieve this, you can use the `chrome.runtime.sendMessage` method in your popup script to send a message, and then listen for that message in your content script using the `chrome.runtime.onMessage` event listener.  

  
### Here’s a basic example:  
  
#### 1. Popup Script (`popup.js`):  
```javascript  
document.getElementById('myButton').addEventListener('click', function() {  
chrome.runtime.sendMessage({type: 'log', message: 'Button in popup clicked!'});  
});  
```  
  
#### 2. Content Script (`content.js`):  
```javascript  
chrome.runtime.onMessage.addListener(function(request, sender, sendResponse) {  
if(request.type === 'log') {  
console.log(request.message); // This will log to the main page’s console.  
}  
});  
```  
  
#### 3. Manifest file (`manifest.json`):  
Ensure that both the popup and content script are properly declared in the manifest file.  
  
```json  
{  
"manifest_version": 3,  
"name": "Your Extension",  
"version": "1.0",  
"description": "A Chrome Extension",  
"permissions": ["activeTab", "storage"],  
"action": {  
"default_popup": "popup.html",  
"default_icon": {  
"16": "icons/icon16.png",  
"48": "icons/icon48.png",  
"128": "icons/icon128.png"  
}  
},  
"background": {  
"service_worker": "background.js"  
},  
"content_scripts": [  
{  
"matches": ["<all_urls>"],  
"js": ["content.js"]  
}  
],  
"icons": {  
"16": "icons/icon16.png",  
"48": "icons/icon48.png",  
"128": "icons/icon128.png"  
}  
}  
```  
  
#### Important Notes:  
- After making changes, don’t forget to reload your extension in `[chrome://extensions/](chrome://extensions/)`.  
- The content script's console logs will appear in the Developer Tools console of the web page (not the popup’s Developer Tools).  
- If you only want to log to the console and don’t need to execute more complicated tasks in the web page, this is a practical approach.  
- Ensure the content script is injected and is running on the page where you are testing, and that it is set to listen before you send the message. If the content script is not properly set up, it won’t catch messages sent from the popup.