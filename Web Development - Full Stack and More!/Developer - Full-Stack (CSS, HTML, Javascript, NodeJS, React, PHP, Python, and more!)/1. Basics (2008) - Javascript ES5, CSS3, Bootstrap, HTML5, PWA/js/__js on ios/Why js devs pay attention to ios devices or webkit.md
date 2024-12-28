iOS devices (include phone and iPad) uses the webkit engine browser which has unique quirks that can sometimes behave differently or enforce stricter rules when handling JavaScript or forcing a certain look on webpages.

eg. `event.target` doesnt work if you dont have event parameter in your click handler function whereas on other browsers, you dont need the event parameter
eg. Scrollbar is hidden unless user scrolls no matter your css.

Remember that Apple requires all browsers to use the WebKit engine, so that means all web browsers on ios phone and ipads have problem, making you think it's an ios device problem.

Therefore you must always test on a webkit engine browser to make sure your iOS users can use the js web app.

If you develop on a MacBook Pro, Chrome on Desktop is NOT required to adopt Webkit-based engine, so Chrome uses its preferred engine Blink. This means on MacBook Pro, you test on both Chrome and Safari. However, on iOS phone and ipads, Chrome and Safari acts the same.

Btw if you want to make sure Firefox users can use your web app, you should in addition test on Firefox which uses Gecko engine. However Firefox's Gecko user is not as quirky, fussy, and strict as WebKit browsers (Desktop Safari and all browsers on iPhone or iPad).