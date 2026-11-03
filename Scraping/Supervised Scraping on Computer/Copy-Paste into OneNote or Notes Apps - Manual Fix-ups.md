Situation: You're scraping pages by copying them into a notes app. Even after a [[JS - Prep a page for copy and paste into notes app|prep script]] has done what it can, some things don't survive the paste. This is what to fix by hand after each paste, in the order that's fastest.

For example, scraping a bootcamp's course pages on an LMS into OneNote, one lesson per OneNote page, with OneNote sections for modules and a notebook per course.

Part of the workflow at [[Course Page Scraping Workflow - Copy-Paste, Downloads, Videos, Verify]].

---

## Why OneNote (or a similar app)

**OneNote** keeps rich formatting from a web paste (headings, lists, tables, code blocks, images) and organizes it well: notebook → section → page. You can migrate to Markdown or Obsidian later. Other notes apps work too, but test a paste with images and code blocks first.

**Browser:** use **Safari** on Mac, or Chrome. Some sites serve images from URLs with no file extension, and in other browsers those images may not come along with the paste.

---

## What a prep script can automate

- Expanding collapsed sections (hints, tips, "deep dives", accordions)
- Adding the title and any intro or narration box to the top, since these often don't copy otherwise
- Placeholders such as `<Video>` and `<Quiz/Embed>` where content can't paste
- Listing downloadable file links in the console
- Selecting the content

## What you must still do by hand (recommended order)

### 0. Copying itself
Use **right-click → Copy** on the selection. **Ctrl+C / Cmd+C sometimes doesn't register** after a script makes the selection.

### a. Split the narration into paragraphs
The narration or intro text gets added as one block. If it had several paragraphs, split them again after pasting.

### b. Replace wrong images ⚠️ the slow part
A known paste bug: **every pasted image turns into the same image**, usually the **last image on the page**, repeated. For each image on the web page, right-click → **Copy Image**, then paste it over the wrong one in your note. Expect this to take the most time. Count the images on the page first so you know how many to fix.

### c. Screenshot the quizzes and embeds
Quizzes, widgets, and other iframes don't paste. Wherever you see `<Quiz/Embed>`, take a screenshot of that area and paste it in:
- Mac: **Cmd+Shift+Ctrl+4** (area to clipboard)
- Windows: **Win+Shift+S** (Snipping Tool)

Expand or answer the quiz first if you want the answers in the screenshot.

### d. Download the files
The console lists file links (starter code, datasets, slides, zips). Download each one into a folder named after the page or module. Drag them into the note too if your app supports attachments.

### e. Videos
Wherever you see `<Video>`, download the video separately and name it after the page. See [[JS - Find video URLs by player type (Wistia, iframe players, video tags)]].

### f. Verify
Run the [[JS - Verify a scraped page is complete (and QA checklist)|verification script]] and compare its counts with what's in your note and your downloads folder.

---

## Tips

- **One page = one note.** Put the page number in the note title (e.g. `3.2.4 Lesson Title`) so notes, downloads, and videos all sort the same way.
- **Do the fix-ups right away**, while the page is still open. Going back to fix images on hundreds of pages later costs far more.
- After migrating the notes to Markdown, you'll probably need some text clean-up: [[Data Cleaning and Data Artifacts]].

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
