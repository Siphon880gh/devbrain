Situation: You have access to a large set of pages behind a login, such as an online course with hundreds of lessons, a members' library, or a knowledge base, and you want your own offline copy: the text and images in a notes app, plus the attached files and the videos. There's no export button, and full automation is either overkill or keeps breaking on pages that vary.

For the whole-course picture (scrape, then have an AI bot match the assets to the notes, then clean up), see [[Scraping Online Courses (like Bootcamps) - Three Pass Workflow]].

This is a **supervised, semi-manual** workflow. You click through the pages yourself, and small console scripts do the repetitive parts on each one. It's slower than a headless crawler but very reliable, because you see every page.

For example, scraping a bootcamp's course pages on an LMS like Canvas: several courses with a few hundred lesson pages each, mixed video players, embedded quizzes, and downloadable starter files on every few pages.

---

## The loop (for every page)

1. **Log in once** in a normal browser window (Incognito, one window per account if you have several). → [[Scraping behind a login - Sessions, multiple accounts, SSO]]
2. **Prep the page**: paste the prep script into the Console. It expands hidden sections, adds the title and narration, puts `<Video>` and `<Quiz/Embed>` placeholders where content won't paste, logs the file and video links, and selects the content. → [[JS - Prep a page for copy and paste into notes app]]
3. **Copy → paste** into your notes app (right-click → Copy). → [[Copy-Paste into OneNote or Notes Apps - Manual Fix-ups]]
4. **Manual fix-ups**: split the narration, replace duplicated images, screenshot quizzes. → same article
5. **Download the files** from the links the script logged.
6. **Download the videos**: work out the player type, get the real URL, download, and name the file `<page> <title>`. → [[JS - Find video URLs by player type (Wistia, iframe players, video tags)]], [[JS - Automate an online video converter page]], [[Chrome Network Tab Scraping]]
7. **Verify**: run the verification script and compare its counts with your note and your folders. It then scrolls you to **Next**. → [[JS - Verify a scraped page is complete (and QA checklist)]]
8. Click **Next** and repeat.

---

## Before you start

- **Survey the site first.** Open 5–10 pages from different sections and note: the content container's selector, the expanders, which video players are used and on which page ranges, which hosts the downloads come from, and whether there are quizzes. Put these into the scripts' `CONFIG`.
- **Pick the right account or copy.** Different accounts or roles may see different versions of the same content (see [[Scraping behind a login - Sessions, multiple accounts, SSO]]).
- **Test the scripts** against the [[JS - Verify a scraped page is complete (and QA checklist)|QA checklist]] on each kind of page before the long run.
- **Decide on naming and folders now**: page number + title for notes, files, and videos.
- Hidden data may be easier to read from page globals than from the DOM: [[JS - Read page data from embedded JS globals (ENV, __NEXT_DATA__)]]

## Want more automation?

- Run the prep or verification script **automatically on each page** with a Tampermonkey userscript, or let Puppeteer IDE click through the pages: [[Case Study - Headed Chrome TamperMonkey vs Puppeteer IDE]]
- Streaming-protected (`.m3u8`) videos: [[_Scrape videos circle.so - Decide type of download]]

## Afterwards

- Keep your logins private but available, so you can go back and **re-check any page** that looks wrong in your copy.
- If you later migrate the notes to Markdown or Obsidian, budget time for clean-up: [[Data Cleaning and Data Artifacts]].

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. Only archive content you have the right to keep. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
