Keyword Surfer and Keyword Everywhere are two SEO chrome extensions that are useful for SEO professionals. One of their features is enhancing Google Search page. Unfortunately, they do not place nice with each other:
![[Pasted image 20260317060750.png]]

Here's the TamperMonkey to make them stack vertically:
```
// ==UserScript==
// @name         Google Search - Reconcile Layouts Keyword Surfer and Keyword Everywhere CEs
// @namespace    WengIndustry
// @version      2026-03-13
// @description  Reconcile Layouts Keyword Surfer and Keyword Everywhere CEs
// @author       You
// @match        *://www.google.com/search*
// @match        *://google.com/search*
// @grant        none
// ==/UserScript==

const resolveCElements = () => {
    var widgetRoot = document.querySelector("keyword-surfer-sidebar");
    var target = document.querySelector("#xt-ke-widgets-root");
    target.appendChild(widgetRoot);
    observer.disconnect();
}

const resolveCElements2 = () => {
    var widgetRoot = document.querySelector("#xt-ke-widgets-root");
    var target = document.querySelector("#paa-container");
    target.appendChild(widgetRoot);
    observer.disconnect();
}

const hideAnnoyingCElements = () => {
    document.getElementById("xt-freeuser-root").style.visibility = "hidden";
    document.querySelector("keyword-surfer-branding").style.display = "none"
}

// Case: Observing for injections while loading, from Tampermonkey
//const observer = new MutationObserver(() => {
var exec = () => {
  var widgetRoot = document.querySelector("keyword-surfer-sidebar");
  var target = document.querySelector("#xt-ke-widgets-root");
  var extraTarget = document.querySelector("#paa-container");

  if (widgetRoot && target) {
    resolveCElements();
    hideAnnoyingCElements();
  }
  if (widgetRoot && extraTarget) {
    resolveCElements2();
  }
}

let i = 0;
const si = setTimeout(()=>{
    exec();
    i++;
    if(i===6) {
        clearInterval(si);
    }
}, 1000);

// Case: Immediately if all mutations already happened and you're running as console script
exec();

console.log("RAN: Google Search - Reconcile Layouts Keyword Sufer and Keyword Everywhere CEs")
```

Now fixed:
![[Pasted image 20260317061327.png]]
^ The other panel group "Keyword Everywhere" is underneath "Keyword Surfer" - not shown.