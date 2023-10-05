
Call a function from panel.js or sidebar.js once devtools done creating their panel or sidebar - Need

Example:
```
let panel = null

let panelWindow;

  

// notice panel.html is the page that will be loaded into the panel and it's at the third parameter of the signature line that follows

chrome.devtools.panels.create("Tailwind-Bootcamp Templates", "icon.png", "panel.html", panel => {

  

	// code invoked on panel creation
	panel.onShown.addListener((window) => {
		panelWindow = window;
	});

  
  

	// if you define a function fakeAlert that alerts parameter at the panel.js that's connected from panel.html
	setTimeout(()=>{
		panelWindow.fakeAlert("panel.js loaded - from devTools")
	}, 2000)
```