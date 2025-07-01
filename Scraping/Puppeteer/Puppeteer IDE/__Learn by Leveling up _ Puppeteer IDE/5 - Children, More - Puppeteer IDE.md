Assuming `#target-me` is still setup at https://n8n.io/creators/n8n-team/ by manually adding that id attribute to the container of the `<a>` tags, as instructed in [[4 - Children - Puppeteer IDE]].

Print tag names of all the `<a>` tags in that container. Execute this for Puppeteer IDE:
```
const targetMe = await page.waitForSelector('#target-me');  
  
// Get direct children as ElementHandles  
const childrenHandles = await targetMe.$$(':scope > *');  
  
console.log('Children count:', childrenHandles.length);  
  
// Optional: Print tag names of each child  
childrenHandles.entries().$$eval()
```

Console tab should look like:
```
Children count: 10  
VM45155:1 Child 0: A  
VM45161:1 Child 1: A  
VM45166:1 Child 2: A  
VM45172:1 Child 3: A  
VM45177:1 Child 4: A  
VM45180:1 Child 5: A  
VM45182:1 Child 6: A  
VM45184:1 Child 7: A  
VM45186:1 Child 8: A  
VM45187:1 Child 9: A
```

----

Let's evaluate outerHTML instead. At Puppeteer IDE:
```
const targetMe = await page.waitForSelector('#target-me');

// Get direct children as ElementHandles
const childrenHandles = await targetMe.$$(':scope > *');

console.log('Children count:', childrenHandles.length);

// Optional: Print tag names of each child
for (const [i, handle] of childrenHandles.entries()) {
  const tag = await handle.evaluate(el => el.outerHTML);
  console.log(`Child ${i}:`, tag);
}
```

At console tab should be:
```
Children count: 10  
Child 0: <a href="/workflows/1789-add-a-note-to-pipedrives-contact-once-pr-is-added-on-github/" class="workflow-item flex flex-col gap-4 px-6 py-4 transition-colors hover:bg-white/5 md:flex-row md:items-center md:justify-between border-b border-white/20 rounded-t-2xl"><ul class="flex flex-wrap items-center justify-start gap-2 md:order-last"><li class="flex size-10 shrink-0 items-center justify-center rounded bg-white/[0.07] p-2"><div id="tooltip-v-2-1-10-17-0" class="html-tooltip-base group relative flex focus-within:outline-none flex flex-col items-center justify-center size-6" role=  
...
```

---

Let's get the href instead:
```
const targetMe = await page.waitForSelector('#target-me');

// Get direct children as ElementHandles
const childrenHandles = await targetMe.$$(':scope > *');

console.log('Children count:', childrenHandles.length);

// Optional: Print tag names of each child
for (const [i, handle] of childrenHandles.entries()) {
  const tag = await handle.evaluate(el => el.href);
  console.log(`Child ${i}:`, tag);
}
```

The console tab should look like:
```
Children count: 10
VM21357:1 Child 0: https://n8n.io/workflows/1788-add-a-new-lead-to-pipedrive-once-github-repo-is-forked/
VM21359:1 Child 1: https://n8n.io/workflows/1807-sync-zendesk-tickets-to-pipedrive-contact-owners/
VM21361:1 Child 2: https://n8n.io/workflows/1789-add-a-note-to-pipedrives-contact-once-pr-is-added-on-github/
VM21363:1 Child 3: https://n8n.io/workflows/1832-sync-zendesk-tickets-with-subsequent-comments-to-github-issues/
VM21365:1 Child 4: https://n8n.io/workflows/1806-send-zendesk-tickets-to-pipedrive-contacts-and-assign-tasks/
VM21367:1 Child 5: https://n8n.io/workflows/1828-create-or-update-mautic-contact-on-a-new-calendly-event/
VM21369:1 Child 6: https://n8n.io/workflows/1821-sync-zendesk-tickets-with-subsequent-comments-to-asana-tasks/
VM21371:1 Child 7: https://n8n.io/workflows/1777-add-new-products-to-stripe-when-product-added-to-pipedrive/
VM21373:1 Child 8: https://n8n.io/workflows/1929-v1-helper-find-params-with-affected-expressions/
VM21374:1 Child 9: https://n8n.io/workflows/1834-send-new-clockify-invoice-to-notion-database/
```

---

Okay, now lets continue getting the href one more time but with a more semantic and declarative change in the Puppeteer IDE script:
```
const targetMe = await page.waitForSelector('#target-me');

const hrefs = await targetMe.$$eval('a', anchors =>
  anchors.map(a => a.href)
);
console.log(hrefs);
```

The console tab looks like:
![[Pasted image 20250701073205.png]]

Notice the key method here is `$$eval`, which evaluates a function over **all elements** that match the selector within a given scope. In this context, it targets all matching elements that are **descendants of `targetMe`**.

Here are some important distinctions:
- If you use `$eval`, it only selects and evaluates the **first** matching element.
- If you write `await page.$$eval('a', ...)`, it will select **all `<a>` tags on the entire page**, not just those under `targetMe`.