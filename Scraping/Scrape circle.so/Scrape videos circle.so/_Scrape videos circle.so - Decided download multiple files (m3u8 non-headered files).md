Depends on if there's a download button on the video player

There's a Download button - so it's not protected:

![[Pasted image 20251123192028.png]]

If there's a download button, this document isn't the one to follow. Instead, refer to [[_Scrape videos circle.so - Decided download multiple files (mp4 direct files)]]

---

vs

---

There's no download button so likely it's protected
![[Pasted image 20251123191736.png]]


The likely protection mechanism is having a m3u8 playlist file that gets pieced together as the video plays on the webpage. Fortunately with ffmpeg command, it can both download and then piece them together into a video.

But it also depends on how protected the m3u8 playlist is. Usually there's an expiration token. If the token it already part of the m3u8 url, then it's likely okay to just ffmpeg the m3u8 directly (as long as it hasn't expired between the time you get the URL and the time you download with ffmpeg command). 

if the m3u8 playlist 4XX errors or authorization/forbidden errors when using ffmpeg even with tokens in the URL, then it requires headers that are sent when viewed on the actual page, which you can emulate in ffmpeg command but it requires some detective work to figure out.

**Recall that from** [[Scrape m3u8 without headers]], you get the m3u8 URL then run a ffmpeg command in your computer's terminal to both download and piece together the m3u8 playlist segments into a final video. 

Performing that on a page by page basis (for each lesson on the right) may be a drag. You'll want to **automate the whole sequence**: Sniffing out the m3u8 URL, move to the next page, sniffing out that page's m3u8 URL, then moving onto the next page, etc. You'd want a list of the m3u8 commands. Even better, you may want a **list of ffmpeg commands** that you can copy and paste into your terminal or sh file.

---


Let's proceed to downloading multiple m3u8 non-headed files. This is assuming the lessons are not gatekept behind headers. If they are, you'll continue with these same instructions but modify the steps to involve sniffing the headers.

Firstly, make sure the lessons are NOT checked (you can undo completion):

![[Pasted image 20251123221315.png]]

This is not good:
![[Pasted image 20251123221421.png]]

Script to list all the m3u8 ffmpeg commands:
```
// === Config  ===  
const upTo = 2;  
var OFFSET_START_FFMPEG = 1;  
var FILENAME = "lesson-"  
const BETWEEN_ITERATION_MS = 400;   // between lessons  
  
const sleep = (ms) => new Promise(r => setTimeout(r, ms));  
  
const srcs = [];  
  
for (let i = 0; i < upTo; i++) {  
  console.log(`Iteration ${i + 1} / ${upTo}`);  
  
  // Wait for the shadow host & its button to exist  
  await page.waitForSelector('media-theme');  
  await page.waitForFunction(() => {  
    const host = document.querySelector('media-theme');  
    return !!host?.shadowRoot  
  });  
  
  // Try to grab href immediately from the shadow button (or nested <a>)  
  let src = await page.evaluate(() => {  
    const sourceTag = document.querySelector("media-theme").querySelector("hls-video")?.shadowRoot.querySelector("source");  
  
    return sourceTag?.src  
  });  
  
  if (src) {  
    srcs.push(src);  
    console.log(`Found href: ${src}`);  
  } else {  
    console.warn('No src found this iteration.');  
  }  
  
  // Click the submit button; if it navigates, wait for it (don't fail if it doesn't)  
  await page.waitForSelector('[type="submit"]', { visible: true });   
  await Promise.all([   
    page.waitForNavigation({ waitUntil: 'domcontentloaded' })  
  .catch(() => null), page.click('[type="submit"]'), ]);  
  
  await sleep(BETWEEN_ITERATION_MS);  
}  
  
// Output as ffmpeg lines with 1-based index  
let straightCopy = '';  
console.log('--- FFMPEG COMMANDS ---');  
if(OFFSET_START_FFMPEG!==0) OFFSET_START_FFMPEG = OFFSET_START_FFMPEG - 1;  
srcs.forEach((url, idx) => {  
  straightCopy += `ffmpeg -i "${url}" -c copy ${FILENAME}${OFFSET_START_FFMPEG + idx + 1}.mp4\n`;  
});  
console.log(straightCopy);
```

It would automatically go to the next lessons one at a time:
![[Pasted image 20251123223515.png]]

![[Pasted image 20251123223537.png]]

![[Pasted image 20251123223559.png]]

And going to the Console tab when the Puppeteer IDE script finishes running:
![[Pasted image 20251123224626.png]]
```
--- cURL COMMANDS ---
ffmpeg -i "https://cdn-media.circle.so/bcdn_token=..&token_path=%2..%2F&expires=../../hls/playlist.m3u8" -c copy lesson-1.mp4
ffmpeg -i "https://cdn-media.circle.so/bcdn_token=..&token_path=%2..%2F&expires=../../hls/playlist.m3u8" -c copy lesson-2.mp4
```

The cURL would've been ran in terminal one by one or through a batched process like a .sh file:
![[Pasted image 20251123224741.png]]


---

Tip when downloading multiple times in the console (if not developing a sh file):

Pressing CMD+T opens a new tab in terminal to the same folder (as long it's not still loading from .bash_profile etc otherwise it will open to `~/`):

*Note here is not showing ffmpeg m3u8 command, but this tip still applies* 
![[Pasted image 20251123230802.png]]