# page.goto — Navigation and Timeout

Use `page.goto()` when your script needs to open a URL and wait for the page to reach a ready state before the next step runs.

---

## Basic usage

```js
await page.goto('https://example.com')
```

Puppeteer opens the URL in the current tab and waits for the page to finish loading according to the `waitUntil` option.

---

## What does it wait for?

By default, `page.goto()` waits until the page fires the **`load`** event. That means the main document and its subresources (images, stylesheets, etc.) have loaded.

You can change what “ready” means with `waitUntil`:

```js
await page.goto('https://example.com', {
  waitUntil: 'domcontentloaded'
})
```

Common `waitUntil` values:

| Value | Waits for |
|---|---|
| `load` | Full page load (default) |
| `domcontentloaded` | HTML parsed; DOM is ready, but images may still be loading |
| `networkidle0` | No more than 0 network connections for 500 ms |
| `networkidle2` | No more than 2 network connections for 500 ms |

If the page becomes ready **before** the chosen event, `page.goto()` returns right away. It does not wait longer than necessary.

---

## The timeout option

If the page is slow or never reaches the chosen state, Puppeteer stops waiting and throws a **navigation timeout error**.

```js
await page.goto('https://example.com', {
  timeout: 60000  // 60 seconds, in milliseconds
})
```

- Default timeout is **30 seconds** (30000 ms).
- Set `timeout: 0` to disable the timeout (wait indefinitely).

> [!note] Option name is `timeout`
> The option is spelled `timeout` (all lowercase), not `timeOut`. A typo in the option name means Puppeteer will ignore it and use the default 30-second limit.

---

## When navigation times out

A timeout usually means one of these:

1. **The page is genuinely slow** — heavy JavaScript, large assets, or a slow server.
2. **The page never reaches your `waitUntil` state** — for example, a site that keeps polling forever will never hit `networkidle0`.
3. **The URL is wrong or unreachable** — DNS failure, 404, or blocked request.

Things to try:

- Increase `timeout` for known slow pages.
- Switch to a lighter `waitUntil` value such as `domcontentloaded`.
- After `goto`, use `page.waitForSelector()` to wait for a specific element you care about instead of waiting for the entire network to go idle.

```js
await page.goto('https://example.com', {
  waitUntil: 'domcontentloaded',
  timeout: 60000
})

await page.waitForSelector('#main-content')
```

---

## Related

- [[Official Puppeteer Documentation]]
- [[2c - Read Page Title with page.title()]] — confirm you landed on the right page after navigation
- [[1 - Visit, Click, Type, and press Enter]] — first tutorial that uses `page.goto()`
