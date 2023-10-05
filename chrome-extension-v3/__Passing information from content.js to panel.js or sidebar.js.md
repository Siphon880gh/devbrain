
When it comes to data other than textContent, eg. computed data from functions:

You **cannot** invoke functions at devtools.js / panel.js / sidebar.js that were defined at content.js and then retrieve their values

But you can connect with a port from content.js to background js and background.js becomes the intermediate coordinator that passes information to devtools.js or panel.js or sidebar.js. Reworded: In the context of Chrome extensions, the background script often serves as an intermediate coordinator or "messaging hub" to facilitate communication between various parts of the extension, such as content scripts, devtools scripts (`devtools.js`), panel scripts (`panel.js`), and sidebar scripts (`sidebar.js`).

Or you can have content.js create a hidden element that contains your computed information. The hidden element can be a script tag of type text/x-template with innerHTML of your computed information, and that hidden element can be appended to document.body. Your devtools.js can run eval on the inspected window for the information, and that devtools can also present the information into panel.html or sidebar.html (if you have assigned the created instance of panel/sidebar at onShown to a global variation at devtools)