Situation: You have a list of video embed URLs (e.g. Wistia embed URLs collected with [[JS - Find video URLs by player type (Wistia, iframe players, video tags)]]), and you're converting them one at a time on a web-based video converter. Each video means pasting the URL, waiting, fixing the file name, choosing MP4, clicking Start, waiting, clicking Download, and closing pop-up ads. Over dozens of videos that gets tedious.

You can automate it from the converter page's own DevTools **Console**. Put the URL and page number at the top of a script, paste it, and let it run.

> If a CLI downloader supports the source (e.g. `yt-dlp` handles Wistia), prefer that for batches: it's scriptable and doesn't depend on a third-party site's layout. Use this pattern when only the web converter works for you.

---

## Two-step pattern

1. **On the source page**, run a snippet that prints ready-to-paste lines:
   ```js
   var url = "https://fast.wistia.net/embed/iframe/<VIDEO_ID>?seo=false";
   var page = "12.3.4";
   ```
   (The snippet is in [[JS - Find video URLs by player type (Wistia, iframe players, video tags)]], under Wistia.)
2. **On the converter page**, paste those two lines as the top of the script below and run it. It fills in the URL, renames the file, picks MP4, starts the conversion, downloads the result, and goes back to the start page for the next video.

---

## Converter automation script (template)

Every converter site has different element IDs, and they change over time. **Inspect the converter page and replace every selector in `SEL`.** The flow and the polling technique are the reusable part. The original was written against one converter site in 2021 and used that site's jQuery. This version is vanilla JS.

```js
var url = "https://fast.wistia.net/embed/iframe/<VIDEO_ID>?seo=false";
var page = "12.3.4";
// ^ Paste the two lines from the source page above. Run at the converter page's Console.

const SEL = {                       // <- replace with the converter's real selectors
  form: "form#converter",
  urlInput: "#mediaurl",
  submitForm: "#submiturl",       // the URL form, or its submit button
  optionsPanel: "#opt-convert",     // appears once the URL has been analyzed
  filename: "#filename",
  mp4Option: ".videoformat.mp4 > span",
  filetype: "#filetype",
  startButton: '[value="Start!"]',
  downloadButton: "#downloadbutton",
  adSelectors: [                    // overlays that keep popping up
    '[style="display: block !important;"]',
    '[style="padding: 5px 15px !important;"]',
  ],
  startPage: location.href,         // where to return for the next video
};
const $ = (s) => document.querySelector(s);

// 1. Keep removing ad overlays that appear intermittently
setInterval(() => SEL.adSelectors.forEach((s) => document.querySelectorAll(s).forEach((el) => el.remove())), 1000);

// 2. Stop the browser from autofilling an old filename/extension (e.g. a default .BIN)
$(SEL.form)?.setAttribute("autocomplete", "off");

// 3. Enter the URL and submit
$(SEL.urlInput).value = url;
const submitEl = $(SEL.submitForm);
if (submitEl.tagName === "FORM") submitEl.requestSubmit(); else submitEl.click(); // form or button

// 4. When the options appear: fix the filename, choose MP4, press Start
const waitForOptions = setInterval(() => {
  const panel = $(SEL.optionsPanel);
  if (!panel || getComputedStyle(panel).display === "none") return;
  clearInterval(waitForOptions);

  const original = $(SEL.filename).value;
  const cleaned = original
    .replace(/^[0-9.]*\s/gm, "")   // drop the often-wrong leading number
    .replace(/:/gm, " -");          // colons aren't allowed in filenames
  $(SEL.filename).value = page + " " + cleaned;

  $(SEL.mp4Option)?.click();
  if ($(SEL.filetype)) $(SEL.filetype).value = "MP4";

  setTimeout(() => $(SEL.startButton)?.click(), 1500);
}, 1000);

// 5. When the download button exists: click it, then go back for the next video
const waitForDownload = setInterval(() => {
  const btn = $(SEL.downloadButton);
  if (!btn) return;
  clearInterval(waitForDownload);
  btn.click();
  setTimeout(() => { window.location.href = SEL.startPage; }, 2000);
}, 1000);
```

---

## Techniques worth reusing elsewhere

- **Poll with `setInterval` until an element appears**, then `clearInterval`. It's simpler than a MutationObserver for one-off console scripts on pages that load in stages.
- **A delay (`setTimeout`) before clicking** buttons that have just appeared, because some sites ignore clicks until their own scripts finish.
- **`autocomplete="off"`** on a form stops the browser from filling in last time's values, such as a stale filename or extension.
- **Name the file from your own data** (page number + title), not from what the tool guesses.
- Navigating at the end resets the page, so nothing from the previous run (intervals, state) carries over.

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. Only download content you have the right to keep. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
