Run this code in Puppeteer IDE tab:
![[Pasted image 20250701063556.png]]

The code snippet for your convenience is:
```
var arr = [];
arr.push(1);
arr.push(2);
console.log(arr);
```

Note nothing webpage interacting or scraping has actually happen, which Puppeteer is often used for (as in [[1 - Visit, Click, Type, and press Enter]])

But learning how to console log is very important for debugging and scraping.

Where does the log go? To the Console log:
![[Pasted image 20250701063708.png]]

---

Caveat - About:blank

This fails to run at url `about:blank` , as in nothing will console to "Console" tab. May be tempting to try about:blank to test scripts out, but that's not a good idea. You can just try this at https://wikipedia.org

---

Caveat - x does not console log

$x will not console log:
- Test on your favorite webpage, replacing the x path with your full xpath:
```
const [button] = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]/a[1]');  
console.log(button) // nothing
```

But it WILL work for click:
- Change the console log to a click.
```
const [button] = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]/a[1]');  
await button.click(); // but click works!
```

That proves the x path to the element just isn't going to console log but the element it selects for actually exists, because you can make it clicked.

This is a quirk of Puppeteer IDE.