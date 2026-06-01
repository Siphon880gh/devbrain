Goal: Read the title of the current page and print it to the Console tab for debugging.

This builds on [[3 - To Console Log - Puppeteer IDE]] and [[2b - Checkpoint Console Log]].

---

## Run this in Puppeteer IDE

Open a normal webpage in Chrome, such as [https://wikipedia.org](https://wikipedia.org).

Open DevTools, switch to the **Puppeteer IDE** tab, paste this script, and click **Execute**:

```js
var t = await page.title()
console.log(t)
```

Switch to the **Console** tab (not Puppeteer IDE) to see the output. You should see something like:

```
Wikipedia
```

The exact text depends on the page you are on.

---

## What is happening?

Every web page has a **title**. You see it in the browser tab name.

- `page.title()` asks Puppeteer for that title string.
- `await` waits until Puppeteer gets the answer from the page.
- `console.log(t)` sends the title to the Console tab so you can read it.

This is useful when your script visits many pages. Logging the title helps you confirm you landed on the right page before you click or scrape anything.

---

## A slightly cleaner version

You can skip the extra variable if you want:

```js
console.log(await page.title())
```

Both versions do the same thing.

---

## Common mistakes

**Nothing shows in Console**

- Make sure you are on a real URL, not `about:blank`. See [[3 - To Console Log - Puppeteer IDE]].
- Check for a syntax error in lines above your `console.log`. See [[2b - Checkpoint Console Log]].

**Title is empty or wrong**

- The page may still be loading. Wait for a key element first with `page.waitForSelector()`, then read the title.
- Some single-page apps change content without changing the tab title right away.

---

## Retrospection

`page.title()` is a simple read-only call. It does not click, type, or change the page. Pair it with `console.log()` whenever you need a quick sanity check during a longer scraping script.
