Situation: You have access to an online course, like a coding bootcamp on an LMS, with hundreds of lesson pages, videos, images, and starter or project files. You want all of it in your own notes vault, with every video, image, and zip sitting in the right lesson. Doing it in one go rarely works. Split the job into **three passes**: scrape everything, let an AI bot connect the pieces, then clean up what's left.

The per-page mechanics (console scripts, manual fix-ups, finding video URLs) are covered in [[Course Page Scraping Workflow - Copy-Paste, Downloads, Videos, Verify]]. This article is the bigger picture across a whole course.

---

## First pass: scrape the lesson pages and the assets

### Lesson pages
There are two approaches:
1. **Use AI.** Give an AI agent your course logins and have it browse and scrape the pages for you. See [[Scraping behind a login - Sessions, multiple accounts, SSO]] for how logged-in scraping works.
2. **Scrape manually** into something like **OneNote** or **Obsidian**. Obsidian is much better: the notes are plain Markdown files that an AI bot can read and edit in the second pass. Tools: [[JS - Prep a page for copy and paste into notes app]] and [[Copy-Paste into OneNote or Notes Apps - Manual Fix-ups]].

Wherever a video, image, or quiz can't come along, leave a **placeholder** such as `<Video>` in the note. The second pass looks for these.

![[online-course-scrape-placeholder-example.png]]
*Example: a lesson note after the first pass. The `<Video>` placeholder is still waiting for the second pass to swap in the real video, and the module already has an `Attachments` folder.*

### Images and videos
You may use a different scraping procedure for images and videos ([[JS - Find video URLs by player type (Wistia, iframe players, video tags)]], [[JS - Automate an online video converter page]], [[Chrome Network Tab Scraping]]). Scrape them into a **separate folder**, but **name the media files the same as the document or page** they belong to.

### Starter and project files
For starter or project files, you may need to download their zips manually.

### The one rule
Either way, **your assets should be named after your pages' names** (e.g. lesson number + title). That's what makes the second pass possible.

![[online-course-assets-named-by-lesson.png]]
*The asset folder: videos and zips named after the lesson pages (lesson number + title), so they can be matched to the notes by filename.*

Before moving on, run [[JS - Verify a scraped page is complete (and QA checklist)]] on the pages so the first pass is as complete as it can be.

---

## Second pass: have an AI bot match the assets to the notes

Connect an AI bot like **Grok Bot** to two places:
- the folder of lesson pages (aka the vault)
- the folder of assets (images, videos, and project or starter files in zips)

Then give it a prompt like this:

```text
Go through every single file in Bootcamps content and look for placeholders such as <VIDEO>, and then replace them with Obsidian markdown syntax to the most likely file found in the assets folder. You can just match by filename. If there are filenames that are the same inside the asset folder, let me know. Move the asset into an Attachments folder next to the note that uses it so that it can actually be displayed. If there are placeholders you can't match, let me know. You can keep those in two list text files.

If there's a more automated way to scrape, like an API for the bootcamp service, do not use it because it may get detected. Instead, browse as if you're a user and look at titles, and then update my vault's filenames from the titles. Ask me for logins if needed.

And look at the curriculum compared to my file tree. Any lessons missed?

And go to only those pages I seem to only have mp4's etc for that haven't been moved yet from the asset folder. Then determine where the video/image should be.

Some asset files may be folders containing misc file types like html. Those are considered project files. In those cases, we might want to zip it and then make it available for download? Do the official lesson pages show zip files to download? Make sure to move them to the vault folders.

You might want to track with:

_missing-lessons TXT
_placeholders-duplicate-assets TXT
_placeholders-moved-assets TXT
_placeholders-unmatched TXT
_rename-log TXT
```

### What each tracking file is for

Have the bot keep these at the root of the vault. They let you review its work and pick up where it left off:

| File | What it records |
|---|---|
| `_missing-lessons.txt` | Lessons in the official curriculum that aren't in your file tree, i.e. pages you still need to scrape |
| `_placeholders-duplicate-assets.txt` | Placeholders that matched **more than one** asset with the same filename, so you need to decide which one |
| `_placeholders-moved-assets.txt` | Each placeholder that was replaced, and which asset was moved into which `Attachments` folder (your undo and audit trail) |
| `_placeholders-unmatched.txt` | Placeholders with **no** matching asset: videos or images still to find or download |
| `_rename-log.txt` | Notes the bot renamed to match the official lesson titles (old name → new name) |

Why "browse as a user" instead of an API: a course platform may flag unusual API traffic on your account. Slower, human-like browsing is less likely to get noticed. (A related technique, if you're logged in yourself: [[JS - Read page data from embedded JS globals (ENV, __NEXT_DATA__)]].)

---

## Third pass: clean up the leftovers

Check the asset folder for any images, videos, or zips (or unzipped folders) that remain. These are the assets the second pass couldn't place. Work through them with the AI agent or bot, or handle them manually yourself.

Prompt:

```text
For all remaining videos, why can't we put them where the filename suggested? Did we check out the original source? Ask me to log in if needed for the original sources.
```

Use `_placeholders-unmatched.txt` and `_missing-lessons.txt` as the to-do list for this pass. When the asset folder is empty (or only holds files you've decided not to keep), the course is done.

---

## Afterwards

- Keep the logins private but available, so you or an AI can go back and check a lesson that looks scraped wrong.
- Clean up the migrated text if needed: [[Data Cleaning and Data Artifacts]].

Disclaimer: This scraping information is intended for educational use only. It's important to respect the terms of service of other platforms. Only archive courses you have the right to keep. I cannot be held accountable for any harm caused. See [[__Scraping - Disclaimer - READ FIRST]].
