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
<summary>### File Structure</summary>  
Bare minimum example:
manfiest.json
popup.js
popup.html
content.js

More fleshed out:
![](https://i.imgur.com/10ajaTK.png)

</details>