> [!warning] Clicking a link navigates away — use goto for scraping the next page
> Calling `.click()` on a link ElementHandle loads the next page in the same tab, like a real user click. That is fine for testing clicks, but it is **not** the usual way to scrape many pages in one script.
>
> After a click, the old ElementHandles are stale and your script must wait for the new page to load before scraping again. That is slower and harder to control than navigating directly.
>
> When you want Puppeteer to keep scraping the next page in the same session, **read the URL from the element and use `page.goto()`** instead of clicking:
>
> ```js
> const link = await page.$('a')
> const nextUrl = await page.evaluate(el => el.href, link)
> await page.goto(nextUrl)
> ```
> 

Goal: Learn what an **ElementHandle** is, how to get one with `page.$()`, and how to use it to click an element on the page.

This article explains the object type behind many Puppeteer selector methods. It pairs with [[6 - CHECKPOINT - Selectors in Puppeteer IDE]].

---

## What is an ElementHandle?

When Puppeteer finds an element on a page, it does not give you the raw DOM node directly. It gives you an **ElementHandle** — a wrapper that keeps a reference to that element so Puppeteer can interact with it later.

Think of it like a bookmark on a specific button or link. You hold the bookmark, then tell Puppeteer what to do with it (click, type, read text, etc.).

---

## Create an ElementHandle with page.$()

[`page.$()`](https://pptr.dev/api/puppeteer.page._) takes a CSS selector and returns the **first matching element** on the page, or `null` if nothing matches.

### In Puppeteer IDE

Open [https://example.com](https://example.com) in Chrome. In the Puppeteer IDE tab, run:

```js
await page.goto('https://example.com')

const hrefElement = await page.$('a')
await hrefElement.click()
```

What happens step by step:

1. `page.goto()` opens the page.
2. `page.$('a')` finds the first `<a>` link on the page and returns an ElementHandle.
3. `hrefElement.click()` clicks that link, just like a user would.

### In a Node.js Puppeteer script

The same pattern works when you run Puppeteer from a script:

```js
import puppeteer from 'puppeteer';

const browser = await puppeteer.launch();
const page = await browser.newPage();
await page.goto('https://example.com');
const hrefElement = await page.$('a');
await hrefElement.click();
// ...
```

Puppeteer IDE skips the `launch()` and `newPage()` lines because the browser tab is already open.

---

## ElementHandles stay alive until disposed

An ElementHandle prevents the DOM element from being garbage-collected while you still hold the handle. Puppeteer can keep using it for clicks, typing, and other actions.

You can manually release a handle with [`dispose()`](https://pptr.dev/api/puppeteer.jshandle.dispose):

```js
await hrefElement.dispose()
```

In most scripts you do not need to call `dispose()` yourself. ElementHandles are **automatically disposed** when:

- The frame navigates to a new page
- The parent browsing context is destroyed

After navigation, old handles point at elements that no longer exist. Create fresh handles on the new page.

---

## Use ElementHandles with evaluate methods

ElementHandle instances can be passed into [`page.$eval()`](https://pptr.dev/api/puppeteer.page._eval) and [`page.evaluate()`](https://pptr.dev/api/puppeteer.page.evaluate) when you need to run JavaScript in the page context.

Example — read the link text:

```js
const hrefElement = await page.$('a')
const text = await page.evaluate(el => el.textContent, hrefElement)
console.log(text)
```

Here `page.evaluate()` runs a function inside the page. The ElementHandle is passed in as the `el` argument.

> [!note] console.log and ElementHandles
> Logging an ElementHandle directly in Puppeteer IDE often prints an empty or unhelpful object. That does not mean the element is missing — it is a quirk of how handles appear in the Console. See [[3 - To Console Log - Puppeteer IDE]]. To inspect an element, use `page.evaluate()` to pull out a plain value like `textContent` or `href`.
> 

---

## page.$() vs similar methods

| Method | Returns |
|---|---|
| [`page.$()`](https://pptr.dev/api/puppeteer.page._) | One ElementHandle (first match), or `null` |
| [`page.$$()`](https://pptr.dev/api/puppeteer.page.__) | An array of ElementHandles (all matches) |
| [`page.$eval()`](https://pptr.dev/api/puppeteer.page._eval) | Result of a function run on the first match — not a handle |
| [`page.waitForSelector()`](https://pptr.dev/api/puppeteer.page.waitforselector) | Waits until the element exists, then returns an ElementHandle |

Use `page.waitForSelector()` when the element might not exist yet because the page is still loading. Use `page.$()` when you know the element is already there.

---

## Common mistakes

**`Cannot read properties of null (reading 'click')`**

`page.$()` returned `null` because no element matched your selector. Check the selector spelling or wait for the element first:

```js
const hrefElement = await page.waitForSelector('a')
await hrefElement.click()
```

**Click works on a stale handle after navigation**

If you called `page.goto()` or clicked a link that loads a new page, create a new handle on the updated page before interacting again.

---

## Retrospection

`page.$()` is one of the most common ways to grab a single element. The object it returns — an ElementHandle — is the handle you use for clicks, typing, and reading data. Once you are comfortable with ElementHandles, methods like `page.$$()`, `page.$eval()`, and `page.waitForSelector()` follow the same pattern.

See also: [[Official Puppeteer Documentation]], [[4 - Children - Puppeteer IDE]].
