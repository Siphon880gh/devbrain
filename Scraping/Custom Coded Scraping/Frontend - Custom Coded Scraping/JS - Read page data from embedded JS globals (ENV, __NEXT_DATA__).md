Situation: The thing you want to scrape (a video ID, the page's raw HTML, an ID, a title, a list of items) is awkward to get from the rendered page. It might be inside an iframe, created late by JavaScript, or split across many elements. But many server-rendered apps also put the page's data into the HTML as a **JavaScript global** or a JSON `<script>` block, so the frontend can start up from it. Reading that object is often cleaner than scraping the DOM.

For example, scraping a bootcamp's course pages on an LMS like Canvas: every page has an inline `ENV = {...}` object, and `ENV.WIKI_PAGE.body` holds the page's raw HTML, including the Wistia iframe embed URL. That's an easy way to collect video URLs without dealing with the rendered player.

---

## Common places page data hides

| Where | How to read it in the Console |
|---|---|
| **Canvas LMS** `ENV` (and `INST`) | `ENV.WIKI_PAGE`, `ENV.COURSE_ID`, `ENV.current_user` … |
| **Next.js** | `JSON.parse(document.getElementById("__NEXT_DATA__").textContent)` |
| **Nuxt** | `window.__NUXT__` |
| **Redux-style apps** | `window.__INITIAL_STATE__`, `window.__PRELOADED_STATE__`, `window.__APOLLO_STATE__` (names vary) |
| **SEO structured data** | `[...document.querySelectorAll('script[type="application/ld+json"]')].map(s => JSON.parse(s.textContent))` |
| **Anything else** | View Source (`view-source:` + URL) and search for `= {` near the top, or for a value you can see on the page |

Tip: search the **page source** (View Source, or DevTools → Sources) rather than the Elements panel. The globals are in inline `<script>` tags, and the Elements panel shows the DOM *after* JavaScript has changed it.

---

## Find the site's custom globals

This lists everything on `window` that isn't a browser built-in. It compares against a blank iframe's `window`:

```js
const blank = document.createElement("iframe");
blank.style.display = "none";
document.body.appendChild(blank);
const builtins = new Set(Object.keys(blank.contentWindow));
blank.remove();
console.log(Object.keys(window).filter((k) => !builtins.has(k)));
```

Look for names like `ENV`, `INST`, `__INITIAL_STATE__`, `appData`, `pageData`, `config`. (Top-level `const`/`let` in a page script doesn't create a `window` property, so search the source too.)

---

## Example: pull embedded video URLs out of a page's raw HTML

When a global holds HTML as a string (as Canvas's `ENV.WIKI_PAGE.body` does), parse it with `DOMParser` and query it like a normal page:

```js
const html = ENV.WIKI_PAGE.body;          // raw page HTML stored in the global
const doc = new DOMParser().parseFromString(html, "text/html");

const iframes = [...doc.querySelectorAll("iframe")].map((f) => ({ title: f.title, src: f.src }));
console.table(iframes);
// e.g. { title: "Module 0 Introduction Video", src: "https://fast.wistia.net/embed/iframe/<VIDEO_ID>?seo=false" }

console.log(ENV.WIKI_PAGE.title, ENV.WIKI_PAGE.html_url, ENV.WIKI_PAGE.updated_at);
```

Other useful fields in a Canvas page's `ENV` include the course ID, the URL paths for modules and pages, and the page's title, URL, and last-updated time, which are handy for naming files and building a list of pages to visit.

To save the whole object for study, Chrome DevTools has a `copy()` helper that puts it on the clipboard:

```js
copy(JSON.stringify(ENV, null, 2));
```

---

## Gotcha: these objects contain your session details

Page-data globals usually include **who you are and your session**: user ID, display name, roles, page-view or CSRF tokens, sometimes API URLs signed for you. Before you paste one into notes, a published article, or an AI chat, **delete those fields** (or copy only the part you need, e.g. `ENV.WIKI_PAGE`). For feeding page data to AI for a scraping plan, see [[Headed Chrome passing information to AI for scraping method]].

---

## Related

- Video IDs and player types: [[JS - Find video URLs by player type (Wistia, iframe players, video tags)]]
- Data that arrives later via XHR/fetch instead of inline: [[Chrome Network Tab Scraping]]
- Parsing scraped HTML outside the browser: [[NodeJs - jQuery styled selectors in Node to parse scrapped HTML]]

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
