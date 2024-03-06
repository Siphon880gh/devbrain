
Button or onloading of panel or sidebar affects content

Here is panel.js that injects create-elements.js. Then a function is passed to the web content every 50ms to see if the element has been created. When it has created, it sends a message to devtools, where devtools has an instance of panel.html after creation and onShown, and that instance used to present information about the created element into the panel.html

```
/* Panel JS loads */
window.injectedJS = false;
async function panelJSLoads() {

    if(!injectedJS) {
        injectedJS = true;
        chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
            let tab = tabs[0];
            chrome.scripting.executeScript({
                target: {tabId: tab.id},
                files: ['create-elements.js']
              });
              // alert("Content retrieval script loaded!")
              
              let waitForSaved1 = setInterval(()=>{
                chrome.scripting.executeScript({
                    target: {tabId: tab.id},
                    function: function() {
                      return document.querySelector('#ds-vm-colors');
                    }
                  }, (results) => {
                    // console.log("#ds-vm-colors innerHTML", results);
                    if (results[0].result) {
                      myData = results[0].result.textContent;
                      clearInterval(waitForSaved1);
                      chrome.runtime.sendMessage({type:"report-new-text-content", data:myData});
                    }
                }); // executeScript
              }, 50); // waitForSaved

          }); // query tab
          
    }

};
panelJSLoads();
```