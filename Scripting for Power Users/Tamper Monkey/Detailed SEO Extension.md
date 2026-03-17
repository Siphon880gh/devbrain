**Detailed SEO Extension** is a Chrome extension that is useful for SEO professionals. It scans a webpage and gives you a quick snapshot of basic SEO elements, helping you see where the page is missing essentials and where it already meets common requirements.

Unfortunately, it also seems to randomly highlight links and videos in purple, or place a purple overlay on them. See:

![[Pasted image 20260317063419.png]]

![[Pasted image 20260317063921.png]]

Fix using Tamper Monkey with:
```
// ==UserScript==
// @name         Detailed SEO Extension Fix
// @namespace    http://tampermonkey.net
// @version      2026-03-17
// @description  Detailed SEO Extension could cause weird purple backgrounds on links and Facebook youtube posts randomly. Could be conflicts with other extensions. As of 3/2026. This fixes that glitch.
// @author       You
// @match        *://www.facebook.com/*
// @match        *://facebook.com/*
// @icon         https://www.google.com/s2/favicons?sz=64&domain=facebook.com
// @grant        none
// ==/UserScript==

(function() {
    'use strict';

const exec = () => {
    [...document.querySelectorAll('*')].forEach(el => {
        if (getComputedStyle(el).backgroundColor === 'rgb(124, 116, 255)') {
            el.style.removeProperty('background-color');
            el.style.removeProperty('color');
            // if (!el.getAttribute('style')?.trim()) el.removeAttribute('style');
        }
    });
}

let i = 0;
let si = setInterval(()=>{
  exec();
  i++;
  if(i===6) {
      clearInterval(si);
  }
}, 1000);

})();

exec();
```