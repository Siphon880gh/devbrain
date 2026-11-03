Situation: A page has embedded videos you're allowed to keep (a course you bought, your own site, etc.). Before you can download a video you need its **real URL**, and where that URL lives depends on the **video player**. Find out which player you're dealing with first, then use the matching method.

For example, scraping a bootcamp's course pages on an LMS: one course used only Wistia, another mixed Wistia with the LMS's own media player, and the site was gradually switching older players to Wistia. The method had to be chosen per module.

Part of the workflow at [[Course Page Scraping Workflow - Copy-Paste, Downloads, Videos, Verify]].

---

## 1. Identify the player type

| Player | How to recognize it (Inspect the video) | Difficulty |
|---|---|---|
| **Plain `<video>` / `<source>`** | A `<video>` tag whose `src` or `<source src>` is an `.mp4` | Easy: the mp4 URL is right there |
| **Easy players visible in the Network tab** | Refresh with DevTools → Network open, and the file shows up as **Media** | Easy |
| **Player inside an iframe** (e.g. an LMS's own media tool) | `<iframe src="...">` pointing at a media or LTI launch URL (on Canvas, e.g. `custom_arc` in the URL). The mp4 is *inside* the iframe page | Moderate: several steps |
| **Wistia** | `<iframe class="wistia_embed" src="https://fast.wistia.net/embed/iframe/<ID>">`, or a `div` with class `wistia_async_<ID>` | Harder: needs a downloader that understands Wistia |
| **HLS streams (`.m3u8`)** | `.m3u8` requests in the Network tab, with no direct mp4 | Harder: see [[_Scrape videos circle.so - Decide type of download]] |

Sites change players over time. If one module's videos are easy and the next module's aren't, note which page range uses which player, and keep that note with your scraping notes.

---

## 2. All-purpose finder: list every iframe and `<source>` URL

Run this in the Console on any page. It prints every iframe `src` and every video `<source>` `src`, plus a suggested file name based on the page number and title:

```js
const urls = [...document.querySelectorAll("iframe")].map((el) => el.src)
  .concat([...document.querySelectorAll("video, source")].map((el) => el.src || el.currentSrc))
  .filter(Boolean);
urls.forEach((url) => console.log(url));

// Suggested filename (change the selectors to the site's)
const pageNum = document.querySelector(".page-number")?.textContent.trim() || "";
const pageTitle = document.querySelector(".page-title")?.textContent.trim() || document.title;
console.log(`${pageNum} ${pageTitle}`.trim());
```

From the output:
- An `.mp4` → download it directly.
- A `fast.wistia.net/embed/iframe/...` URL → Wistia, go to section 4.
- Any other iframe URL → probably a player inside an iframe, go to section 3.

---

## 3. Player inside an iframe

The page only embeds the player, and the actual mp4 is referenced inside the iframe's own page.

1. **Inspect** the video and find the `<iframe>`. Copy its `src` (or use the finder above). On an LMS this is often a media or LTI launch URL.
2. **Open that URL in a new tab.** You're still logged in, so it usually loads the player page on its own.
3. Find the mp4 there:
   - Inspect the `<video>` / `<source>` tag, **or**
   - open DevTools → **Network**, refresh, filter by **Media**, and open the request.
4. Save the file.

Shortcut: you can't read inside a cross-origin iframe from the parent page's scripts. But in Chrome DevTools you can switch the Console's context with the **"top" dropdown** at the top of the Console, choose the iframe, and run the finder from inside it.

---

## 4. Wistia

Wistia doesn't expose a plain mp4 in the page. First collect the **embed URL or video ID** for each video, then hand those to a tool that can download Wistia videos.

### Get the embed URLs (and ready-to-use lines for a batch script)

```js
// Print each Wistia embed URL with the page number, formatted as two JS lines
// you can paste into another script (e.g. a downloader or converter automation).
const pageNum = document.querySelector(".page-number")?.textContent.trim() || "";
const urls = [...document.querySelectorAll("iframe")].map((f) => f.src).filter((u) => u.includes("embed/"));
let out = "";
urls.forEach((url) => { out += `var url = "${url}";\nvar page = "${pageNum}";\n\n`; });
console.info(out);
```

### Other ways to find the Wistia ID

- **Search the page source** for `fast.wistia.net/embed/iframe/`. The part after it is the ID.
- **Async embeds**: instead of an iframe, some sites use a `div` with a class like `wistia_async_<ID>`. Search the source for `wistia_async_` (or run `document.querySelectorAll("[class*='wistia_async_']")`).
- **Embedded page data**: some sites put the raw page HTML, including the iframe, in a JavaScript global. See [[JS - Read page data from embedded JS globals (ENV, __NEXT_DATA__)]].

### Download

- **CLI:** `yt-dlp` has a Wistia extractor. Give it the embed URL, e.g. `yt-dlp "https://fast.wistia.net/embed/iframe/<ID>" -o "<page> <title>.%(ext)s"`.
- **Online converter page:** if you're using a web-based converter, you can automate it from the console. See [[JS - Automate an online video converter page]].

---

## 5. Network tab method (any player that loads a file)

Open DevTools → **Network** first, *then* refresh the page (requests made before DevTools was open aren't listed). The video shows up under **Media**. Right-click → Open in new tab → save. Some players only request the file once you press play. More: [[Chrome Network Tab Scraping]], [[Headed Chrome passing information to AI for scraping method]].

---

## Naming the files

Name videos `<page number> <title>.mp4` so they sort in lesson order and match your notes. Two clean-ups:
- Strip any leading number the downloader added on its own (it's often wrong): `name.replace(/^[0-9.]*\s/, "")`.
- Replace `:` (not allowed in file names on macOS/Windows): `name.replace(/:/g, " -")`.

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
