Sometimes Puppeteer can open a page, show the correct URL, and maybe even navigate to the next page, but then the scraping code hangs.

Common examples:

```js
await page.goto(...)

await page.waitForSelector(...)

await page.evaluate(...)

await page.$(...)
```

The confusing part is that these hangs can come from **different problems**.

This tutorial separates them into clear levels.

---

# Big Picture: There Are Two Main Types of Hangs

## Problem A: Navigation hangs

This means Puppeteer gets stuck while loading the page.

Usually the hang happens here:

```js
await page.goto(...)
```

This is often related to:

```js
waitUntil: "networkidle2"
```

or:

```js
timeout: 0
```

---

## Problem B: Scraping hangs after navigation

This means the page loaded, but Puppeteer hangs when trying to inspect the page.

Usually the hang happens here:

```js
await page.evaluate(...)

await page.waitForSelector(...)

await page.$(...)
```

This is usually a different problem.

It means Puppeteer may not have a working JavaScript execution context inside the page.

---

# Add This First: Turn On Preserve Log in Chrome DevTools

Before testing, open Chrome DevTools.

Go to:

```txt
DevTools → Console → Preserve log
```

Also go to:

```txt
DevTools → Network → Preserve log
```

This is useful because the page may refresh, redirect, or navigate to the next page while you are debugging.

Without Preserve log enabled, Chrome may clear the console or network history when the page changes.

With Preserve log enabled, you can still see:

- console errors before navigation
    
- redirect behavior
    
- failed requests
    
- API calls
    
- video/player requests
    
- whether clicking “Next” caused a full page reload
    
- whether your script logged something before the page changed
    

Chrome’s Console Preserve Log keeps console messages across page loads, and Network Preserve log keeps network requests across page loads until you disable it. ([Chrome for Developers](https://developer.chrome.com/docs/devtools/console/reference?utm_source=chatgpt.com "Console features reference | Chrome DevTools"))

---

# Important: Preserve Log Does Not Fix Puppeteer

Preserve log helps you **observe** the problem.

It does not fix:

```js
page.evaluate(...)
```

It does not fix:

```js
page.waitForSelector(...)
```

It does not fix:

```js
page.goto(...)
```

It also does not prevent:

```txt
execution context destroyed
```

Think of Preserve log as your black box recorder.

It helps you see what happened before the page changed.

---

# Level 0: Is `page.goto()` Hanging?

First figure out whether Puppeteer is stuck during navigation.

Example problem code:

```js
await page.goto("https://my-url.com/something", {
  waitUntil: "networkidle2",
  timeout: 0
});
```

This can hang because:

```js
timeout: 0
```

means “do not timeout.”

So Puppeteer may wait forever.

Also, `networkidle2` waits until there are no more than **2 network connections for at least 500 ms**. Puppeteer documents `networkidle2` as waiting until there are no more than 2 network connections for at least 500 ms. ([Puppeteer](https://pptr.dev/api/puppeteer.puppeteerlifecycleevent?utm_source=chatgpt.com "PuppeteerLifeCycleEvent type"))

That can be a problem on modern pages that keep background requests running.

Examples:
- analytics
- ads
- tracking pixels
- video players
- course platforms
- background API calls
- long-polling
- live chat widgets

So this may never finish:

```js
await page.goto("https://my-url.com/something", {
  waitUntil: "networkidle2",
  timeout: 0
});
```

Use a real timeout instead:

```js
await page.goto("https://my-url.com/something", {
  waitUntil: "networkidle2",
  timeout: 30000
});
```

This means:

> Wait for the page to become mostly network-idle, but give up after 30 seconds.

---

# Safer Navigation Option for Scraping

For scraping, this is often better:

```js
await page.goto("https://my-url.com/something", {
  waitUntil: "domcontentloaded",
  timeout: 30000
});
```

Then wait for the specific thing you need:

```js
await page.waitForSelector(".post-body-title", {
  timeout: 10000
});
```

Why?

Because you usually do not need every ad, tracker, image, or video request to finish.

You just need the DOM element you want to scrape.

---

# Level 1: Check Whether the Page Itself Is Usable

Run this test:

```js
console.log("URL:", page.url());

try {
  const title = await Promise.race([
    page.title(),
    new Promise((resolve) => setTimeout(() => resolve("TIMEOUT"), 3000))
  ]);

  console.log("TITLE:", title);
} catch (e) {
  console.log("ERR:", e.message);
}
```

## How to Read the Result

|Result|Meaning|
|---|---|
|URL correct + TITLE prints|Puppeteer can read basic page info|
|TITLE timeout|Page may be frozen or inaccessible|
|`execution context destroyed`|Page is navigating or reloading|
|URL wrong|Puppeteer is attached to the wrong tab/page|

If this test passes, that is good.

But it only proves Puppeteer can read basic metadata.

It does **not** prove that Puppeteer can run JavaScript inside the page.

---

# Level 2: Check Whether JavaScript Execution Works

These are the two functions that commonly hang:

```js
await page.waitForSelector(...)
```

and:

```js
await page.evaluate(...)
```

Run these three tests.

---

## Test 1: Is the page closed?

```js
var result = await page.isClosed();
console.log(result);
```

Result:

|Result|Meaning|
|---|---|
|`true`|The page object is closed/dead|
|`false`|The page object still exists|

Important:

```js
false
```

does not mean the page is fully usable.

It only means Puppeteer still has a page object.

---

## Test 2: Does `evaluate()` work at all?

```js
var result = await page.evaluate(() => "OK");
console.log(result);
```

Result:

|Result|Meaning|
|---|---|
|Prints `"OK"`|JavaScript execution works|
|Hangs|Puppeteer cannot run JavaScript inside the page|

If this hangs, then normal Puppeteer scraping is not safe in this environment.

---

## Test 3: Does Puppeteer see the selector?

```js
var result = await page.$(".post-body-title");
console.log(result);
```

Result:

|Result|Meaning|
|---|---|
|`null`|Selector is not in the DOM Puppeteer sees|
|`ElementHandle`|Selector exists|
|Hangs|Puppeteer cannot query through the normal page context|

---

# Example Result

You got:

```txt
Test 1: false
Test 2: hangs
Test 3: hangs
```

That means:

```js
page.isClosed() → false
page.evaluate(() => "OK") → hangs
page.$(".post-body-title") → hangs
```

So the page object exists, but Puppeteer cannot run JavaScript or selector queries inside it.

In plain English:

> Puppeteer is attached to something, but not to a healthy page execution context.

---

# What That Usually Means

This can happen when Puppeteer is attached to:

- the wrong tab
    
- a background page
    
- an extension page
    
- a DevTools page
    
- an old page target
    
- a detached frame
    
- a page that recently navigated
    
- a context where extension security blocks execution
    

That explains why this can return:

```js
false
```

```js
await page.isClosed();
```

But these still hang:

```js
await page.evaluate(...)
await page.$(...)
await page.waitForSelector(...)
```

The page object exists, but JavaScript execution is not working.

---

# Where Preserve Log Helps Here

Preserve log helps you confirm what happened before the hang.

For example, it can show:

```txt
execution context destroyed
```

or:

```txt
Navigated to ...
```

or:

```txt
Failed to load resource
```

or your own previous logs:

```js
console.log("before clicking next");
console.log("after goto");
console.log("before evaluate");
```

Without Preserve log, those messages may disappear when the page navigates.

With Preserve log, you can see where the script got before the page changed.

You can enable Preserve Log in Chrome Settings:
![[Pasted image 20260531034232.png]]

And:
![[Pasted image 20260531015838.png]]



---

# Level 1 Fix: Use Normal Puppeteer If `evaluate()` Works

If this works:

```js
var result = await page.evaluate(() => "OK");
console.log(result);
```

Then you can use normal Puppeteer:

```js
await page.goto("https://my-url.com/something", {
  waitUntil: "domcontentloaded",
  timeout: 30000
});

await page.waitForSelector(".post-body-title", {
  timeout: 10000
});

const title = await page.evaluate(() => {
  return document.querySelector(".post-body-title")?.innerText;
});

console.log("TITLE:", title);
```

This is the normal approach.

Use this when Puppeteer can run JavaScript inside the page.

---

# Level 2 Fix: Use CDP DOM If `evaluate()` Hangs

If this hangs:

```js
await page.evaluate(() => "OK");
```

then stop relying on:

```js
page.evaluate()
page.$()
page.waitForSelector()
```

Instead, use the **Chrome DevTools Protocol**, also called **CDP**.

CDP can ask Chrome directly for the DOM.

That means you are no longer asking the webpage to run JavaScript.

You are asking Chrome:

> “Show me the DOM and find this selector.”

Example:

```js
const client = await page.target().createCDPSession();

await client.send("DOM.enable");

const { root } = await client.send("DOM.getDocument", {
  depth: -1
});

const { nodeId } = await client.send("DOM.querySelector", {
  nodeId: root.nodeId,
  selector: ".post-body-title"
});

if (!nodeId) {
  console.log("NOT FOUND");
  return;
}

console.log("FOUND NODE:", nodeId);
```

---

# Get the HTML From That Element

Once you have the `nodeId`, you can get the element’s HTML:

```js
const { outerHTML } = await client.send("DOM.getOuterHTML", {
  nodeId
});

console.log(outerHTML);
```

Example output:

```html
<h1 class="post-body-title">Lesson 1: Introduction</h1>
```

Now you know the selector exists and CDP can see it.

---

# Simple Decision Tree

Use this when debugging.

## Step 1: Did `page.goto()` hang?

If yes, fix your navigation first.

Avoid this:

```js
await page.goto(url, {
  waitUntil: "networkidle2",
  timeout: 0
});
```

Use this:

```js
await page.goto(url, {
  waitUntil: "domcontentloaded",
  timeout: 30000
});
```

or:

```js
await page.goto(url, {
  waitUntil: "networkidle2",
  timeout: 30000
});
```

---

## Step 2: Did navigation finish, but scraping hangs?

Run:

```js
var result = await page.evaluate(() => "OK");
console.log(result);
```

If it prints:

```txt
OK
```

use normal Puppeteer.

If it hangs, use CDP DOM.

---

## Step 3: Did the page navigate or refresh while debugging?

Turn on:

```txt
Console → Preserve log
Network → Preserve log
```

Then rerun the test.

This helps you see what happened before the page changed.

---

# Recommended Debugging Template

Use this when asking AI or another developer for help.

```txt
I am using Puppeteer IDE Chrome extension.

Problem:
The script hangs while scraping.

Preserve log:
Console Preserve log is enabled.
Network Preserve log is enabled.

Navigation code:
paste page.goto code here

Test results:
1. page.isClosed():
result here

2. page.evaluate(() => "OK"):
result here

3. page.$(".post-body-title"):
result here

4. page.url():
result here

5. page.title():
result here

Where it hangs:
page.goto / page.waitForSelector / page.evaluate / page.$

Console errors shown with Preserve log:
paste errors here

Network behavior:
Does the page redirect, reload, or keep making requests?
```

---

# Final Rule

Use this mental model:

## `page.goto()` hangs

Usually a navigation waiting problem.

Check:

```js
waitUntil
timeout
networkidle2
```

---

## `page.evaluate()` hangs

Usually a JavaScript execution context problem.

Check:

```js
page.evaluate(() => "OK")
```

If it hangs, switch to CDP DOM scraping.

---

## Console/Network logs disappear

That is where **Preserve log** helps.

It does not fix the scraping issue, but it helps you keep the evidence after navigation.