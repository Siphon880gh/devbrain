
### Runtime Message

You can pass messages from your popup script to your content script, and then log those messages to the console of the main webpage (the content script's execution environment). To achieve this, you can use the `chrome.runtime.sendMessage` method in your popup script to send a message, and then listen for that message in your content script using the `chrome.runtime.onMessage` event listener.  

  
  
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

----

### Port connections

You can also pass using port connections

Certainly! If you want to communicate directly between a content script (`content.js`) and a devtools panel script (`devtools.js` or `panel.js`) without involving a background script, you can use the `chrome.runtime.connect` API to establish a persistent connection. Here's how you can achieve this:

1. **Set Up the DevTools Panel**:
   In your `devtools.js`, create a devtools panel:

   ```javascript
   chrome.devtools.panels.create("My Panel", "icon.png", "panel.html", function(panel) {
     // Panel created
   });
   ```

2. **Establish a Connection from content.js**:
   In your `content.js`, establish a connection to the devtools:

   ```javascript
   const port = chrome.runtime.connect({name: "content-script"});
   ```

3. **Send a Message from content.js**:
   Still in your `content.js`, send a message through the established port:

   ```javascript
   let textContent = document.body.textContent;
   port.postMessage({type: "FROM_CONTENT", payload: textContent});
   ```

4. **Listen for the Connection in devtools.js**:
   In your `devtools.js`, listen for the connection:

   ```javascript
   chrome.runtime.onConnect.addListener(function(port) {
     console.assert(port.name === "content-script");
     port.onMessage.addListener(function(message) {
       if (message.type === "FROM_CONTENT") {
         // Handle the message in your devtools panel
         // For example, send it to panel.js or handle it directly here
         console.log(message.payload);
       }
     });
   });
   ```

5. **Update manifest.json**:
   Ensure that your `manifest.json` is set up correctly:

   ```json
   {
     "manifest_version": 3,
     "name": "My Extension",
     "version": "1.0",
     "permissions": ["tabs", "activeTab"],
     "content_scripts": [{
       "matches": ["<all_urls>"],
       "js": ["content.js"]
     }],
     "devtools_page": "devtools.html",
     "icons": {
       "48": "icon.png"
     }
   }
   ```

6. **Error Handling**:
   Always ensure to handle potential errors, especially when dealing with asynchronous operations and messaging.

By following these steps, you should be able to establish a direct communication channel between `content.js` and your devtools panel (`devtools.js` or `panel.js`) without the need for a background script.


---

### Background js

This is another approach.... (to expand on)