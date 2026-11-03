Situation: You can read a page in the browser (often a page behind a login, like a course lesson), but there's no export. You want its content in a notes app like OneNote, Obsidian, or Notion with the formatting kept. A plain Select All → Copy misses things: collapsed sections stay collapsed, the title doesn't copy, and videos and quizzes silently disappear.

The fix is a small script you paste into the DevTools **Console** on every page. It prepares the page so a single copy-paste picks up as much as possible, and it lists in the console whatever still needs manual work.

For example, scraping a bootcamp's course pages on an LMS like Canvas: each lesson page had collapsed "Hint / Pro Tip / Deep Dive" boxes, embedded videos, embedded quizzes, and links to downloadable starter files.

Part of the workflow at [[Course Page Scraping Workflow - Copy-Paste, Downloads, Videos, Verify]].

---

## What the script does

1. **Browser check**: warns if you're not in Safari or Chrome. Some sites serve images from URLs with no file extension (`.png`, `.jpg`), and other browsers may not paste those images into a notes app.
2. **Makes hard-to-copy text copyable**: the page title and any narration or intro box often sit outside the main content container, or are styled so they don't copy. The script copies their text as plain `<p>` paragraphs to the top of the content.
3. **Expands collapsed sections** by clicking every toggle (hints, tips, "show more", accordions).
4. **Leaves placeholders** where content won't paste:
   - `<Video>` before each video player, with the video URLs logged in red.
   - `<Quiz/Embed>` before every other iframe (quizzes, widgets), with the count logged.
5. **Lists downloadable files**: links whose URL starts with a host you configure (file CDN, S3 bucket, GitHub org), logged in yellow. The page gets a yellow outline so you notice.
6. **Selects the content container** so you only need to copy.

Then: **right-click → Copy**. Ctrl+C / Cmd+C sometimes doesn't register after a script makes the selection. Paste into your notes app, and do the [[Copy-Paste into OneNote or Notes Apps - Manual Fix-ups|manual fix-ups]].

---

## The script

Inspect the page first, and change the `CONFIG` selectors to match the site. The values below are placeholders.

```js
// Prep page for copy & paste into a notes app. Run in DevTools Console on every page.
// Reload the page before running again (otherwise the title/markers get added twice).
const CONFIG = {
  root: "#content",                         // main content container you want to copy
  title: [".page-number", ".page-title"],   // pieces joined into one title line
  narration: ".narrative",                  // optional intro box that doesn't copy well
  expanders: [                              // things to click so hidden text is revealed
    ".hint .toggle-title",
    ".pro-tip .toggle-title",
    ".deep-dive .toggle-title",
    ".hide-show-button",
  ],
  videoSelectors: [                         // video players (see "Find video URLs by player type")
    ".wistia_embed",
    "iframe[src*='wistia']",
    "iframe[src*='media']",                 // e.g. an LMS's own media player iframe
    "video",
  ],
  downloadPrefixes: [                       // links starting with these are "files to download"
    "https://files.example.com",
    "https://example-bucket.s3.amazonaws.com",
    "https://github.com/example-org",
  ],
};

const root = document.querySelector(CONFIG.root);
if (!root) throw new Error("Content root not found: " + CONFIG.root);

// 1. Browser check
const isSafari = /Apple/.test(navigator.vendor) && !/CriOS|FxiOS/.test(navigator.userAgent);
const isChrome = !!window.chrome;
if (!isSafari && !isChrome) {
  console.warn("Use Safari or Chrome. Other browsers may not paste images whose URLs have no file extension.");
}

// 2. Narration, then title, prepended as plain paragraphs (title ends up on top)
const prependText = (text) => {
  if (!text || !text.trim()) return;
  const p = document.createElement("p");
  p.textContent = text.trim();
  root.prepend(p);
};
prependText(document.querySelector(CONFIG.narration)?.textContent);
const titleText = CONFIG.title.map((s) => document.querySelector(s)?.textContent.trim() || "").join(" ");
prependText(titleText);

// 3. Expand collapsed sections
CONFIG.expanders.forEach((sel) => document.querySelectorAll(sel).forEach((el) => el.click()));

// 4. Placeholders for videos and other embeds
const addMarker = (el, label) => {
  const span = document.createElement("span");
  span.textContent = `<${label}>`;
  el.before(span);
};
const videos = [...root.querySelectorAll(CONFIG.videoSelectors.join(","))];
const embeds = [...root.querySelectorAll("iframe")].filter((f) => !videos.some((v) => v === f || v.contains(f)));
videos.forEach((el) => addMarker(el, "Video"));
embeds.forEach((el) => addMarker(el, "Quiz/Embed"));

if (videos.length) {
  console.log(`%c Videos x${videos.length} `, "color:#c4302b; background-color:darkgray;"); // YouTube red
  videos.forEach((v) => console.log(v.src || v.currentSrc || v.querySelector("iframe, source")?.src || v));
}
if (embeds.length) {
  console.log(`%c Quiz/Embed x${embeds.length} `, "color:lightgray; background-color:black;");
}

// 5. Downloadable files
const downloads = [...root.querySelectorAll("a[href]")].filter((a) =>
  CONFIG.downloadPrefixes.some((prefix) => a.href.startsWith(prefix))
);
if (downloads.length) {
  console.log(`%c Downloads x${downloads.length} `, "color:#F8D775; background-color:black;"); // folder yellow
  downloads.forEach((a) => console.log(a.href));
  document.body.style.outline = "6px solid #F8D775";
}

// 6. Select the content so it's ready to copy (then right-click -> Copy)
window.getSelection().selectAllChildren(root);
```

---

## Tips and gotchas

- **Color-code the console output** (red = videos, yellow = downloads, black = quizzes). After 100+ pages you'll scan for the color, not read the text.
- **Expanders**: the clickable element is often the title bar inside the box (e.g. `.hint .blockquote-title`), not the box itself. Inspect it.
- **Download link prefixes**: open a few pages and hover the attachment links to find which hosts the site really uses. A course can have several, e.g. the LMS's own file host, one or two S3 buckets, and a GitHub org.
- **Don't make the page `contenteditable`.** It's tempting so you can tidy up before copying, but it makes the page glitchy, and it's inherited by buttons and links so navigation breaks. Tidy up in the notes app instead.
- **Optional:** scroll to the bottom (to the "Next" button) when done:
  ```js
  window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" });
  ```
- If the site has jQuery loaded, you can write the same thing shorter with `$()`. The vanilla version above works whether or not jQuery is there.
- To run it automatically on every lesson page instead of pasting it, wrap it in a Tampermonkey userscript. See [[Case Study - Headed Chrome TamperMonkey vs Puppeteer IDE]].
- After pasting, re-check the page with [[JS - Verify a scraped page is complete (and QA checklist)]].

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
