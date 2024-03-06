Because direct communication between content scripts and DevTools panels (eg content js scrapes webpage then passes to viewing in DevTools custom panel or sidebar) isn't possible, you'll need to use a background script as a relay  

But if you still want to send a message directly from `content.js` to `panel.js` without the intermediary of a background script, you'll need to use a slightly different approach. This involves `chrome.runtime.connect` for establishing a persistent connection.

---

Background knowledge general:

Since the content script and the DevTools panel don't communicate directly, you'll typically use a background script as an intermediary.

So:
In Chrome extension development, if you want to send information from a content script (`content.js`) to a DevTools panel script (`panel.js`), you can use a combination of the `chrome.runtime.sendMessage` method and the `chrome.runtime.onMessage` event listener. Here's a step-by-step guide:

1. **Sending a Message from `content.js`**:
   ```javascript
   // content.js
   chrome.runtime.sendMessage({type: "FROM_CONTENT", payload: "Your data here"});
   ```

2. **Listening for the Message in `background.js`**:
   Since the content script and the DevTools panel don't communicate directly, you'll typically use a background script as an intermediary.

   ```javascript
   // background.js
   chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
       if (message.type === "FROM_CONTENT") {
           // Forward the message to the DevTools panel
           chrome.runtime.sendMessage({type: "FORWARD_TO_PANEL", payload: message.payload});
       }
   });
   ```

3. **Listening for the Forwarded Message in `panel.js`**:
   ```javascript
   // panel.js
   chrome.runtime.onMessage.addListener((message, sender, sendResponse) => {
       if (message.type === "FORWARD_TO_PANEL") {
           console.log("Data received in panel:", message.payload);
       }
   });
   ```

4. **Ensure Permissions in `manifest.json`**:
   Make sure you have the necessary permissions in your `manifest.json` file to use the messaging API.

   ```json
   {
       "manifest_version": 3,
       "name": "Your Extension",
       "version": "1.0",
       "background": {
           "service_worker": "background.js"
       },
       "permissions": ["activeTab", "storage", "webNavigation"],
       "content_scripts": [{
           "matches": ["<all_urls>"],
           "js": ["content.js"]
       }],
       "devtools_page": "devtools.html"
   }
   ```

5. **Establish a Connection (Optional)**:
   If you need more persistent communication between the content script and the DevTools panel, consider using `chrome.runtime.connect` to establish a connection and then send and receive messages on that connection.

Remember, the above method uses the background script as a relay. This is because direct communication between content scripts and DevTools panels is not straightforward. Using the background script as an intermediary is a common pattern to bridge this gap.
