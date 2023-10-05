
    "content_scripts": [
        {
            "matches": ["<all_urls>"],
            "js": ["content-enable-external-img.js"],
            "run_at": "document_start"
        },
        {
            "matches": ["<all_urls>"],
            "js": ["css-frameworks/bootstrap.bundle.min.js"]
        },
        {
            "matches": ["<all_urls>"],
            "css": ["css-frameworks/bootstrap.min.css", "css-frameworks/tailwind.min.css"]
        }
    ],

If you want more control when they’re injected/executed, you have to use background.js (which is a service worker property in manifest 3)

Or at panel.js or sidebar.js
if(!injectedCSS) {
        injectedCSS = true;
        chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
            let tab = tabs[0];
            chrome.scripting.insertCSS({
              target: {tabId: tab.id},
              files: ['css-frameworks/bootstrap.min.css', 'css-frameworks/tailwind.min.css']
            });
            chrome.scripting.executeScript({
                target: {tabId: tab.id},
                files: ['css-frameworks/bootstrap.bundle.min.js']
              });
            // alert("CSS and JS injected for Bootstrap 5 / Tailwind 2!")
          });
          
    }