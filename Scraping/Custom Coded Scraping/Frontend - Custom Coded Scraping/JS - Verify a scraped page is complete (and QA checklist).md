Situation: You've scraped a page by hand: pasted its content into your notes, downloaded its files, saved its videos. Before moving to the next page, you want a quick check that nothing was missed. Across hundreds of pages, a skipped video or attachment is easy to miss and annoying to find later.

The answer is a **verification script**: a lighter version of the [[JS - Prep a page for copy and paste into notes app|copy-paste prep script]]. It doesn't select anything. It clears the console and prints a short checklist for the page (how many quizzes, downloads, and videos, with their URLs, plus the page number), then scrolls you down to the **Next** button.

Part of the workflow at [[Course Page Scraping Workflow - Copy-Paste, Downloads, Videos, Verify]].

---

## Verification script

Use the same `CONFIG` as your prep script, so both scripts count the same things.

```js
// Verify a scraped page. Run in DevTools Console AFTER you've pasted, downloaded files, and saved videos.
const CONFIG = {
  root: "#content",
  pageNumber: ".page-number",
  expanders: [".hint .toggle-title", ".pro-tip .toggle-title", ".deep-dive .toggle-title", ".hide-show-button"],
  videoSelectors: [".wistia_embed", "iframe[src*='wistia']", "iframe[src*='media']", "video"],
  downloadPrefixes: ["https://files.example.com", "https://example-bucket.s3.amazonaws.com", "https://github.com/example-org"],
};

const root = document.querySelector(CONFIG.root);
if (!root) throw new Error("Content root not found - did the session expire and redirect you to a login page?");

// Expand so nothing hidden is skipped in the counts
CONFIG.expanders.forEach((sel) => document.querySelectorAll(sel).forEach((el) => el.click()));

console.clear();

const videos = [...root.querySelectorAll(CONFIG.videoSelectors.join(","))];
const embeds = [...root.querySelectorAll("iframe")].filter((f) => !videos.some((v) => v === f || v.contains(f)));
const downloads = [...root.querySelectorAll("a[href]")].filter((a) =>
  CONFIG.downloadPrefixes.some((p) => a.href.startsWith(p))
);

if (embeds.length) console.log(`%c Quiz/Embed x${embeds.length} `, "color:lightgray; background-color:black;");

if (downloads.length) {
  console.log(`⭐️ %c Downloads x${downloads.length} `, "color:#F8D775; background-color:black;");
  downloads.forEach((a) => console.log(a.href));
}

if (videos.length) {
  console.log(`⭐️ %c Videos x${videos.length} `, "color:#c4302b; background-color:darkgray;");
  videos.forEach((v) => console.log(v.src || v.currentSrc || v.querySelector("iframe, source")?.src || v));
}

const pageNumber = document.querySelector(CONFIG.pageNumber)?.textContent.trim() || "(no page number)";
console.log("\nPage: " + pageNumber);

// Bring the Next button into view
setTimeout(() => window.scrollTo({ top: document.body.scrollHeight, behavior: "smooth" }), 500);
```

How to use the output:
- Compare **Downloads xN** with the files you saved for this page, and **Videos xN** with the video files named after this page number.
- Compare **Quiz/Embed xN** with the screenshots you pasted.
- The **page number** printed last is the prefix you should have used in your file names.

### Optional: keep a running log across pages

If you want a summary at the end instead of checking page by page, save each page's counts to `localStorage` (which persists across pages on the same site). Add this at the end of the script:

```js
const log = JSON.parse(localStorage.getItem("scrapeLog") || "{}");
log[pageNumber] = { url: location.href, videos: videos.length, downloads: downloads.length, embeds: embeds.length };
localStorage.setItem("scrapeLog", JSON.stringify(log));
```

Later, on any page of the same site:

```js
console.table(JSON.parse(localStorage.getItem("scrapeLog") || "{}"));
```

Compare that table with the folders of downloads and videos on your disk.

---

## QA checklist for your scraping scripts

Before trusting the scripts for a whole site (or several similar sites or courses), test them on a few pages of each kind. The requirements:

- [ ] Shows **downloads** with a count and their URLs.
- [ ] Shows **videos** with a count and their URLs.
- [ ] Works for **every video player type** on the site (see [[JS - Find video URLs by player type (Wistia, iframe players, video tags)]]). Sites often mix players, e.g. older modules on one player and newer ones on another.
- [ ] Shows **quizzes and other embeds** with a count.
- [ ] Doesn't count the same video twice (e.g. a player wrapper `div` *and* the iframe inside it).

Track it in a matrix, one row per site or course variant:

```
+-------------+------+--------------+--------------+------+
|  Site       | Dl's | Vids-Player A| Vids-Player B| Quiz |
+-------------+------+--------------+--------------+------+
| Course 1    | Y    | Y            | Y            | Y    |
| Course 2    | Y    | Y            | n/a          | Y    |
| Course 3    | T    | n/a          | Y            | Y    |
+-------------+------+--------------+--------------+------+
Y = verified, T = still testing, n/a = that course doesn't use it
```

For example, when scraping three bootcamp courses on the same LMS, one course used only one video player, another used only the other, and a third mixed both. A matrix like this showed which script paths had actually been tested.

---

## Related

- After the scrape, clean the text: [[Data Cleaning and Data Artifacts]].
- Missing content that won't paste at all: [[Copy-Paste into OneNote or Notes Apps - Manual Fix-ups]].

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
