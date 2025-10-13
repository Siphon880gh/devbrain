## XPath instead of Selector - When to do so
Sometimes selecting an element by ID or class just doesn’t work—especially when dealing with client-rendered JavaScript where no IDs were needed for hydration, or when the element relies entirely on Tailwind classes and you worry the design and class structure can change in the future. In those cases, it’s best to grab the full XPath of the element instead.

![[Pasted image 20250701064330.png]]

We made sure to grab the Full XPath of an `<a` tag.

Let's enter into the Puppeteer IDE:
```
const [button] = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]/a[1]');  
console.log(button)  
if (button) {  
  await button.click();  
} else {  
  console.log("No matching button found");  
}
```

^ Btw the console logs goes to your console tab (switch away from Puppeteer IDE tab). If you don't see the console log, then likely it means you have invalid syntax at the Puppeteer IDE at some line above the console log.

Notice where $x is the Full XPath to the `<a` tag. Execute from the Puppeteer IDE. You'll find the webpage changes. That's great - because the puppeteer script looks for the link element, and if it exists, then that link gets clicked, which opens the next page.

### waitForXPath Not Reliable, so waitForTimeout to the rescue

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


✅ Good
```
await page.goto('https://n8n.io/creators/n8n-team/')  
await page.waitForTimeout(3000);  
const [button] = await page.$x('/html/body/div[1]/section/div/div[2]/section[1]/div/div/div[2]/div[2]/a[1]');  
console.log(button)  
if (button) {  
  await button.click();  
} else {  
  console.log("No matching button found");  
}
```

Instead, we introduce some waiting (`waitForTimeout`) because the whole purpose is to wait for the element to emerge when the webpage is loading (especially after a `goto`).