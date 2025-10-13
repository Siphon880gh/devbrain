
There is a wait for the XPath element to exist (similar to the `waitForSelect` that we learned back in [[1 - Visit, Click, Type, and press Enter]])

However, as of July 2025, this version of Puppeteer IDE is not reliable when it comes to waiting an element to emerge by their XPath

❌ Bad
```
const button = await page.waitForXPath('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]/a[1]');
```

it sadly does not work reliably. It's as if not found or timed out. Even XPath (not the full XPath) doesnt work. No loud errors.

Although lint auto suggestion claims the method works, it doesn't work:
![[Pasted image 20250701065827.png]]
You'll find that Puppeteer IDE has some quirks. This is one of them.