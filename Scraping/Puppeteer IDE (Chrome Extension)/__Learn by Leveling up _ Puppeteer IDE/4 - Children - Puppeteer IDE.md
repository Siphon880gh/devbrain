Let's get all a hrefs:
[https://n8n.io/creators/n8n-team/](https://n8n.io/creators/n8n-team/)

Begin by modifying the container of all the `<a>` tags:
![[Pasted image 20250701070114.png]]

Right click -> Edit as HTML, then add attribute `id="target-me"`. Double check with this screenshot:
![[Pasted image 20250701070209.png]]

Now run Puppeteer IDE script:
```
const targetMe = await page.waitForSelector('#target-me')  
const children = await targetMe.evaluate(node => [...node.children]);  
console.log(children)  
console.log(children[0].evaluate(node => { console.log(node); }))
```

...as:
![[Pasted image 20250701070255.png]]

Then switch to console log to see some useless empty objects in an array of 10:
![[Pasted image 20250701070326.png]]

Scrolling down, you see there really are 10 links (because of "Load More"):
![[Pasted image 20250701070357.png]]


Thanks! You're almost there — just needs a few clarity, flow, and formatting tweaks for readability. Here's a revised version with improved structure, grammar, and inline clarity:

---

### What happened? Why are there empty objects for each link?

Let's revisit your Puppeteer IDE script:

```js
const targetMe = await page.waitForSelector('#target-me');  
const children = await targetMe.evaluate(node => [...node.children]);  
console.log(children);  
console.log(children[0].evaluate(node => { console.log(node); }));
````

The issue is that `targetMe` is a `Puppeteer ElementHandle`, not a regular DOM element. When you use `.evaluate()` like this, the function runs **in the browser context**, and the returned values are **serialized** — meaning DOM elements like `node.children` are converted into plain JavaScript objects. These objects lose all their DOM methods and properties, which is why the console shows empty or unreadable objects.

You also can’t call `.evaluate()` on `children[0]` in that example, because `children[0]` is no longer an ElementHandle — it’s a plain object that was serialized during the `.evaluate()` call. This should have errored but one of Puppeteer's quirks is that all errors will just fail silently. Hopefully a future version will display messages for errors.

---

### ✅ How to properly get child elements as ElementHandles

If you want to work with child elements in Puppeteer (e.g., click, extract attributes, etc.), you must use Puppeteer’s API — not `.evaluate()` — to get the children as **ElementHandles**:

```js
const targetMe = await page.waitForSelector('#target-me');          // Get parent
const childrenHandles = await targetMe.$$(':scope > *');            // Get all direct child elements

for (const child of childrenHandles) {
  const html = await child.evaluate(el => el.outerHTML);            // Access readable content
  console.log(html);
}
```

When you switch to console tab, you see it worked - it printed a bunch of html of the `<a>` tags:
![[Pasted image 20250701072309.png]]

---

### 🧠 Key Points

- `$$` is Puppeteer’s version of `querySelectorAll` — it returns an **array of ElementHandles**.
- `:scope > *` ensures that you’re selecting **direct children** relative to `targetMe`, not from the entire document.
- You can't just `console.log(child)` — ElementHandles don’t display usefully. Use `.evaluate()` to access readable data like `innerText`, `outerHTML`, or `tagName`.
- Always ensure `#target-me` exists when `waitForSelector` runs, or the script will hang or throw.


### ✅ Let's remove redundancy of waitForSelector

Wait! You don't have a goto line. And you wouldn't want to because we directly modified the DOM to have the id `target-me`. This means the line with `page.waitForSelector`, although works, it doesn't make sense and doesn't communicate your intention just right to the next developer using your Puppeteer IDE script

```js
const targetMe = await page.waitForSelector('#target-me');          // Get parent
const childrenHandles = await targetMe.$$(':scope > *');            // Get all direct child elements

for (const child of childrenHandles) {
  const html = await child.evaluate(el => el.outerHTML);            // Access readable content
  console.log(html);
}
```

You can change the `waitForSelector` to `$` which is the equivalent to `querySelector`:


```js
const targetMe = await page.$('#target-me');          // Get parent
const childrenHandles = await targetMe.$$(':scope > *'); // Get all direct child elements

for (const child of childrenHandles) {
  const html = await child.evaluate(el => el.outerHTML); // Access readable content
  console.log(html);
}
```

You'll find that it equally works.