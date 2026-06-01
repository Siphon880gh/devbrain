# Official Puppeteer Documentation

The official Puppeteer docs live at:

**[https://pptr.dev/](https://pptr.dev/)**

Use this site when you need:

- Full API reference for `page`, `browser`, selectors, and events
- Method signatures, options, and return types
- Examples for Node.js Puppeteer (the library Puppeteer IDE is based on)

---

## How this vault relates to the official docs

The [[__Learn by Leveling up _ Puppeteer IDE|Learn by Leveling up]] series teaches Puppeteer through the **Puppeteer IDE** Chrome extension. You run scripts inside DevTools on a page you already have open.

The official docs assume you installed Puppeteer with npm and launch a browser from a Node.js script:

```js
import puppeteer from 'puppeteer';

const browser = await puppeteer.launch();
const page = await browser.newPage();
```

Most **page-level methods** (`page.goto`, `page.$`, `page.click`, etc.) work the same way in both environments. The main difference is setup: Puppeteer IDE skips `launch()` and `newPage()` because Chrome and the tab already exist.

> [!note] Puppeteer IDE vs Node.js Puppeteer
> Puppeteer IDE does not support every API the official docs list. Some methods fail silently or behave differently in the extension. When something odd happens, check the quirk notes in this vault (for example [[Puppeteer IDE Quirk - waitForXPath not working]]) before assuming the official docs are wrong.
> 

---

## Quick links

| Topic | URL |
|---|---|
| Homepage | [https://pptr.dev/](https://pptr.dev/) |
| `Page` API | [https://pptr.dev/api/puppeteer.page](https://pptr.dev/api/puppeteer.page) |
| `page.goto()` | [https://pptr.dev/api/puppeteer.page.goto](https://pptr.dev/api/puppeteer.page.goto) |
| `page.$()` | [https://pptr.dev/api/puppeteer.page._](https://pptr.dev/api/puppeteer.page._) |
| `ElementHandle` | [https://pptr.dev/api/puppeteer.elementhandle](https://pptr.dev/api/puppeteer.elementhandle) |
