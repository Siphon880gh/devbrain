## What This Error Means

When Puppeteer shows an error like:

```txt
Execution context is not available
```

or:

```txt
Execution context was destroyed, most likely because of a navigation
```

or:

```txt
Execution context is not available in detached frame
```

it usually means Puppeteer tried to run JavaScript on a page, frame, or DOM element that no longer exists.

In simple terms:

> Puppeteer was about to interact with the page, but Chrome had already changed or replaced the page context.

This often happens when the page navigates, refreshes, redirects, reloads an iframe, or updates its content through JavaScript.

---

## Common Causes

This error usually comes from one of these situations:

- The page refreshed while Puppeteer was running code.
    
- A button click triggered navigation.
    
- The site redirected to another URL.
    
- A single-page app replaced the current view.
    
- An iframe was removed, reloaded, or detached.
    
- Puppeteer reused an old `ElementHandle`.
    
- Puppeteer tried to evaluate JavaScript before the page was ready.
    
- The script continued too quickly after a click.
    

This is usually a **timing problem**, not a Chrome networking restriction.

---

## Misconception: “Do I Need to Free Up ≤2 Network Requests?”

Not exactly.

The “2 network requests” idea usually comes from Puppeteer’s `networkidle2` option.

For example:

```js
await page.goto(url, { waitUntil: 'networkidle2' });
```

`networkidle2` means Puppeteer waits until the page has **no more than 2 active network connections** for a short period of time.

But this does **not** mean Chrome prevents JavaScript execution until there are two or fewer network requests.

It only means Puppeteer is using network quietness as a signal that the page is probably done loading.

So the error is not caused by Chrome saying:

```txt
Too many network requests are active, so execution context is unavailable.
```

The real issue is usually:

```txt
The page context changed before Puppeteer finished running its command.
```

---

## Why This Happens in Puppeteer IDE / Chrome Workflows

Puppeteer IDE or recorder-style workflows often generate code that clicks something and immediately tries to read from the page.

Example:

```js
await page.click('.next-button');

const title = await page.$eval('.page-title', el => el.textContent);
```

This can fail if the click causes navigation.

The click happens, Chrome starts replacing the page, and Puppeteer immediately tries to read `.page-title` from the old page context.

That old context may already be gone.

Result:

```txt
Execution context is not available
```

---

## Fix 1: Wait for Navigation After a Click

If a click causes a normal page navigation, use:

```js
await Promise.all([
  page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
  page.click('.next-button'),
]);
```

Then scrape after the new page is ready:

```js
await page.waitForSelector('.page-title');

const title = await page.$eval('.page-title', el =>
  el.textContent.trim()
);
```

This tells Puppeteer:

> Click the button and wait for the page navigation before continuing.

---

## Fix 2: Use `domcontentloaded` Instead of `networkidle2`

Some pages keep network requests open because of analytics, video players, chat widgets, tracking scripts, polling, or background API calls.

In those cases, this can be unreliable:

```js
await page.goto(url, { waitUntil: 'networkidle2' });
```

A more stable pattern is often:

```js
await page.goto(url, { waitUntil: 'domcontentloaded' });

await page.waitForSelector('.page-title');
```

This waits for the basic HTML document to load, then waits for the exact element you need.

That is usually better than waiting for the entire network to become quiet.

---

## Fix 3: Wait for the Actual Element You Need

Instead of assuming the page is ready after navigation, wait for the specific selector you plan to scrape.

Example:

```js
await page.goto(url, { waitUntil: 'domcontentloaded' });

await page.waitForSelector('.product-title', {
  timeout: 15000,
});

const productTitle = await page.$eval('.product-title', el =>
  el.textContent.trim()
);
```

This is safer than scraping immediately after `goto()` or `click()`.

---

## Fix 4: Handle Single-Page Apps Differently

Some websites do not perform full page reloads. They update content dynamically with JavaScript.

In that case, this may not work:

```js
await page.waitForNavigation();
```

because the browser did not technically navigate.

Instead, wait for a selector, URL change, or DOM change.

### Wait for a selector

```js
await page.click('.next-button');

await page.waitForSelector('.new-content', {
  timeout: 15000,
});
```

### Wait for the URL to change

```js
const oldUrl = page.url();

await page.click('.next-button');

await page.waitForFunction(
  oldUrl => location.href !== oldUrl,
  {},
  oldUrl
);
```

### Wait for specific text to appear

```js
await page.click('.next-button');

await page.waitForFunction(() =>
  document.body.innerText.includes('Expected Text')
);
```

---

## Fix 5: Avoid Reusing Old Element Handles

This is a common cause of the error.

Risky code:

```js
const button = await page.$('.next-button');

await button.click();

// Page changes here

const text = await button.evaluate(el => el.textContent);
```

After the page changes, `button` may point to an element from the old page.

That old element no longer belongs to the current execution context.

Better:

```js
await page.click('.next-button');

await page.waitForSelector('.page-title');

const title = await page.$eval('.page-title', el =>
  el.textContent.trim()
);
```

The rule is:

```txt
After navigation or major page changes, re-select elements.
Do not reuse old ElementHandles.
```

---

## Fix 6: Re-Select Frames After Navigation

If you are scraping inside an iframe, the iframe may reload or detach.

This can cause errors like:

```txt
Execution context is not available in detached frame
```

Risky pattern:

```js
const frame = page.frames().find(f => f.url().includes('example'));

await page.click('.reload-frame-button');

const text = await frame.$eval('.title', el => el.textContent);
```

The old frame may no longer exist.

Better:

```js
await page.click('.reload-frame-button');

await page.waitForSelector('iframe');

const frame = page.frames().find(f =>
  f.url().includes('example')
);

const text = await frame.$eval('.title', el =>
  el.textContent.trim()
);
```

Re-find the frame after anything that may reload it.

---

## Fix 7: Use `goto()` Instead of Clicking Through Pages

If you can collect URLs first, it is often more stable to visit each URL directly instead of clicking through pages one by one.

Less stable:

```js
await page.click('.next-button');
await page.waitForSelector('.page-title');
```

More stable:

```js
const urls = await page.$$eval('a.item-link', links =>
  links.map(a => a.href)
);

for (const url of urls) {
  await page.goto(url, { waitUntil: 'domcontentloaded' });

  await page.waitForSelector('.page-title');

  const title = await page.$eval('.page-title', el =>
    el.textContent.trim()
  );

  console.log(title);
}
```

This creates a cleaner navigation boundary for each page.

It also avoids carrying stale DOM state from one page to the next.

---

## Fix 8: Add Retry Logic Around Unstable Pages

Some pages are inconsistent. A redirect, reload, or slow script may occasionally break the execution context.

A small retry wrapper can make your scraper more reliable.

```js
async function safeEvaluate(page, fn, retries = 3) {
  for (let attempt = 1; attempt <= retries; attempt++) {
    try {
      return await page.evaluate(fn);
    } catch (err) {
      if (
        err.message.includes('Execution context') &&
        attempt < retries
      ) {
        await page.waitForTimeout(1000);
        continue;
      }

      throw err;
    }
  }
}
```

Usage:

```js
const data = await safeEvaluate(page, () => {
  return {
    title: document.querySelector('h1')?.textContent?.trim(),
    url: location.href,
  };
});
```

Retries should not replace proper waiting, but they help with unstable pages.

---

## Recommended Scraping Pattern

A safer general pattern is:

```js
await page.goto(url, { waitUntil: 'domcontentloaded' });

await page.waitForSelector('.target-element', {
  timeout: 15000,
});

const data = await page.evaluate(() => {
  return {
    title: document.querySelector('.target-element')?.textContent?.trim(),
    url: location.href,
  };
});

console.log(data);
```

For clicking:

```js
await Promise.all([
  page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
  page.click('.next-button'),
]);

await page.waitForSelector('.target-element');
```

For single-page apps:

```js
const oldUrl = page.url();

await page.click('.next-button');

await page.waitForFunction(
  oldUrl => location.href !== oldUrl,
  {},
  oldUrl
);

await page.waitForSelector('.target-element');
```

---

## When to Use `networkidle2`

`networkidle2` can be useful when a page loads important data through background requests and then becomes quiet.

Example:

```js
await page.goto(url, { waitUntil: 'networkidle2' });
```

But avoid depending on it for pages with:

- analytics scripts
    
- video embeds
    
- live chat widgets
    
- background polling
    
- websocket connections
    
- tracking pixels
    
- dashboards
    
- single-page apps
    
- pages that continuously fetch data
    

For those pages, prefer:

```js
await page.goto(url, { waitUntil: 'domcontentloaded' });
await page.waitForSelector('.target-element');
```

This is more direct and usually more reliable.

---

## Quick Checklist

When you see:

```txt
Execution context is not available
```

check these things:

### 1. Did a click trigger navigation?

Use:

```js
await Promise.all([
  page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
  page.click('.button'),
]);
```

---

### 2. Is the site a single-page app?

Use selector, URL, or DOM waiting instead of `waitForNavigation()`.

```js
await page.waitForSelector('.new-content');
```

---

### 3. Are you reusing an old `ElementHandle`?

Re-query the element after navigation.

```js
const title = await page.$eval('.title', el => el.textContent.trim());
```

---

### 4. Are you scraping an iframe?

Re-select the frame after reloads or navigation.

```js
const frame = page.frames().find(f => f.url().includes('example'));
```

---

### 5. Are you relying on `networkidle2` too much?

Try:

```js
await page.goto(url, { waitUntil: 'domcontentloaded' });
await page.waitForSelector('.target-element');
```

---

### 6. Is the page redirecting?

Wait for the final URL or final selector before scraping.

```js
await page.waitForFunction(() =>
  location.href.includes('/final-page')
);
```

---

## Simple Rule

Do not scrape immediately after a click.

First wait for one of these:

- navigation
    
- URL change
    
- selector
    
- iframe
    
- response
    
- DOM update
    

Then scrape.

The safest mental model is:

```txt
Click or navigate
→ wait for the new page state
→ re-select elements
→ scrape
```

---

## Bottom Line

The error:

```txt
Execution context is not available
```

does not usually mean Chrome is blocking execution because too many network requests are open.

It usually means Puppeteer is trying to run code in an old or destroyed page context.

Most fixes come down to:

- waiting after navigation
    
- avoiding stale element handles
    
- waiting for real selectors instead of network quietness
    
- re-selecting frames and elements after page changes
    
- using `page.goto()` when direct URLs are available
    

For most scraping workflows, this pattern is more reliable:

```js
await page.goto(url, { waitUntil: 'domcontentloaded' });
await page.waitForSelector('.thing-you-need');
const data = await page.evaluate(() => {
  // scrape page here
});
```