## Scraping Video IDs or Video Links with Tampermonkey

Let’s say a course video page contains a **video ID** or **video link** somewhere in the **HTML source code** or on the **visible webpage**.

You may want to collect all of those video IDs or video links from a list of course lessons so you can process them later. For example, you might use them in another script to find M3U8 links, convert M3U8 streams into MP4 files, or download videos that you own or have permission to archive.

There are a few ways to do this. Two common approaches are:

1. **Semi-automated scraping with Tampermonkey**
2. **Fully automated scraping with Puppeteer IDE**

The main difference is how the pages are navigated.

With **Tampermonkey**, you still move through the course lessons yourself, but the script runs automatically each time a matching page loads.

With **Puppeteer IDE**, the browser automation can navigate through the lessons for you and collect the results into one long output.

This is not a headless Chrome but a headed Chrome. This means the browser is actually opened on your computer screen whether than in the background running scraping automation. You will see the automation take place. Both Tampermonkey and Puppeteer IDE are Chrome extensions given permissions to interact on user behalf or run browser console scripts on user behalf.

---

# Option 1: Semi-Automated Scraping with Tampermonkey

Tampermonkey is a Chrome extension that lets you run custom JavaScript on webpages that match a specific URL pattern.

For this workflow, you can use Tampermonkey to automatically run JavaScript whenever you open a course video lesson page.

The workflow looks like this:

1. You open a course video lesson page.
    
2. The URL matches your Tampermonkey script rule.
    
3. Tampermonkey immediately runs your JavaScript.
    
4. The script grabs the video ID or video link from the page.
    
5. The script prints the result to the browser console.
    
6. You go to the next course video lesson page.
    
7. Tampermonkey runs again on the new page.
    
8. You repeat this until you have gone through all the lessons.
    

This is **semi-automated** because Tampermonkey handles the scraping part, but you are still working through the course pages yourself.

---

## Why Tampermonkey Works Well Here

You could probably do this with Puppeteer, but Puppeteer introduces another automation syntax and workflow.

If you already know basic JavaScript and want something simpler, Tampermonkey is a good middle ground.

Instead of writing a full browser automation script, you can write a small JavaScript snippet that runs on every matching lesson page.

Then, by enabling **Preserve log** in Chrome DevTools, the console output stays visible even as you move from one lesson to another.

At the end, you can copy the whole console log and ask AI to clean it up by extracting only the video IDs or video links.

The copied console log may be messy. It may include browser warnings, JavaScript errors, unrelated console logs, or repeated output. That is okay. As long as your video IDs or video links are included, AI can help extract the useful parts.

---

# Example Tampermonkey Script

Many course video pages store video metadata inside a JSON-LD script tag.

For example, you may find the video ID or video link inside a tag like this:

```html
<script type="application/ld+json" id="w-json-player_...">
```

You can use a Tampermonkey script like this:

```js
setTimeout(() => {
  const el = document.querySelector(
    'script[type="application/ld+json"][id^="w-json-player_"]'
  );

  if (!el) {
    throw new Error("No matching JSON-LD script found");
  }

  const data = JSON.parse(el.textContent);

  console.log(data["@id"]);
}, 2000);
```

This script waits 2 seconds, then looks for the matching JSON-LD script tag.

If it finds the tag, it parses the JSON and logs the `@id` value to the console.

That `@id` may be the video ID or video link, depending on how the course platform stores its video data.

---

# Using Preserve Log in Chrome DevTools

Before you start moving through the course lessons, open Chrome DevTools and enable **Preserve log**.

This matters because many course platforms reload the page when you move from one lesson to the next. Without Preserve log enabled, Chrome may clear the console every time the page changes.

With Preserve log enabled, each logged video ID or video link remains in the console.

**Screenshot: Preserve Log enabled**

![[Pasted image 20260531015838.png]]

---

# Example: One URL Shown

As you move through the course, each lesson may have its own URL.

For example, when you open a lesson page, the Tampermonkey script runs because the page URL matches your script’s URL pattern.

**Screenshot: URL shown**
![[Pasted image 20260531022542.png]]


---

# Example: Final Console Output

After you have gone through all the course video pages, your DevTools console may contain a long list of video IDs, video links, warnings, and other logs.

Because Preserve log was enabled, the console keeps the earlier results even after page navigation.

**Screenshot: All video IDs or video links logged**
![[Pasted image 20260531022558.png]]

At this point, copy the console output and ask AI to extract only the video IDs or video links.

For example:

```text
Extract only the video IDs or video links from this console log. Remove duplicates and return one per line.
```

---

# Option 2: Fully Automated Scraping with Puppeteer IDE

Tampermonkey is useful when you want to stay close to normal browser JavaScript and manually work through the pages.

However, Puppeteer IDE can take this further.

With a Puppeteer IDE Chrome extension, you can fully automate the process:

1. Open the first course lesson.
    
2. Grab the video ID or video link from the current page.
    
3. Find the **Next** button.
    
4. Read the URL attached to the Next button.
    
5. Navigate directly to that URL.
    
6. Repeat the process.
    
7. Concatenate all video IDs or video links into one long final string.
    

This is **fully automated** because Puppeteer IDE can keep moving from lesson to lesson without you manually opening each page.

---

## Important Puppeteer IDE Navigation Note

When using Puppeteer IDE, avoid triggering the **Next** button by clicking it.

Clicking the Next button can sometimes restart or break the Puppeteer execution context. This may cause errors such as the script losing access to the current page context.

Instead, a safer approach is:

1. Find the Next button.
    
2. Extract the URL from the button or link.
    
3. Use navigation, such as `goto`, to move directly to that next URL.
    

That way, Puppeteer stays in control of the browser flow and can continue collecting video IDs or video links.

---

# Tampermonkey vs Puppeteer IDE

## Tampermonkey

Tampermonkey is best when you want a simpler, semi-automated workflow.

You manually move from lesson to lesson, and Tampermonkey automatically runs the script each time the URL matches.

Tampermonkey does not automatically concatenate all video IDs into one final report unless you build that behavior yourself.

Instead, you can use **Preserve log** in Chrome DevTools to get a similar result. The console becomes your running collection of video IDs or video links.

At the end, you copy the console output and clean it up.

## Puppeteer IDE

Puppeteer IDE is better when you want full automation.

It can navigate through the course lesson pages for you, grab each video ID or video link, and concatenate everything into one final string.

In this workflow, you would not use the exact same script as the Tampermonkey version because the Puppeteer version usually needs extra logic for:

- Storing results
    
- Finding the next lesson URL
    
- Navigating to the next page
    
- Looping through all lessons
    
- Concatenating the final output
    

Puppeteer IDE gives you a cleaner final report, but it requires more automation logic.

---

# When to Use Each Method

Use **Tampermonkey** when:

- You want a simpler JavaScript-based workflow.
    
- You do not want to learn Puppeteer syntax yet.
    
- You are okay manually opening each lesson page.
    
- You want the script to run automatically when each lesson page loads.
    
- You are comfortable copying the preserved console log at the end.
    

Use **Puppeteer IDE** when:

- You want the browser to move through the lessons automatically.
    
- You want one final concatenated output.
    
- You want to extract the Next button URL and navigate with it.
    
- You want to avoid manually opening every lesson page.
    
- You are comfortable writing more automation logic.
    

---

# Summary

If the video ID or video link appears somewhere in the HTML source code or visible webpage, you can scrape it with JavaScript.

With **Tampermonkey**, the process is semi-automated. You open each lesson page, and Tampermonkey automatically runs your script when the URL matches. Preserve log in Chrome DevTools helps you keep a running list of results.

With **Puppeteer IDE**, the process can be fully automated. Puppeteer can grab the video ID or video link, find the next lesson URL, navigate directly to it, and build one final concatenated output.

Tampermonkey is easier to start with. Puppeteer IDE is better for full automation.