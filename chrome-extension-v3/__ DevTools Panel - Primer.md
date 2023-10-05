TLDR Guided steps on making a simple sample Chrome extension
https://github.com/MicrosoftDocs/edge-developer/blob/main/microsoft-edge/extensions-chromium/developer-guide/devtools-extension.md

TLDR Chrome extension that extends elements inspector
https://www.youtube.com/watch?v=TNFKLZwnGW4

---

```
let panel = null

let panelWindow;

  

// notice panel.html is the page that will be loaded into the panel and it's at the third parameter of the signature line that follows

chrome.devtools.panels.create("Tailwind-Bootcamp Templates", "icon.png", "panel.html", panel => {

  

	// code invoked on panel creation
	panel.onShown.addListener((window) => {
		panelWindow = window;

	
		// You can also have eventListeners on the panel.html
		panelWindow.document.querySelector("#btn").addEventListener("click", ()=>{
			alert("Clicked the button")
		})


	});

  

	// if you define a function fakeAlert that alerts parameter at the panel.js that's connected from panel.html
	setTimeout(()=>{
		panelWindow.fakeAlert("panel.js loaded - from devTools")
	}, 2000)
```
