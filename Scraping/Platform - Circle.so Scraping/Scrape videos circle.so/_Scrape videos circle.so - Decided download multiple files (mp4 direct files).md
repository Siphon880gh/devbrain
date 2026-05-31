What type of download depends on if there's a download button on the video player

If there's a Download button - it's not protected:

![[Pasted image 20251123192028.png]]
Clicking the download button will download a mp4 or video file, but you want to download all the lessons on the right.

So you want to **automate the whole sequence** — click the download button, move to the next page, click the download button again, move to the next page, and so on.

---

vs

---

If there's's no download button, it's likely protected
![[Pasted image 20251123191736.png]]

If this is the case, then following this document ain't it. Continue at [[_Scrape videos circle.so - Decided download multiple files (m3u8 non-headered files)]].

---

Let's proceed to downloading multiple direct mp4 files. 

Firstly, make sure the lessons are NOT checked (you can undo completion):
![[Pasted image 20251123221315.png]]

This is not good:
![[Pasted image 20251123221421.png]]

Script to download 5 at a time:
```
// Starting: Downloads starting from the page you're at.   
// Ended State: When done (X rounds), it'll be at another page that isn't downloaded yet.  
  
// Repeat the sequence X times  
var upTo = 5;  
for (let i = 0; i < upTo; i++) {  
  console.log(`Iteration ${i + 1} / ${upTo}`);  
  
  // Wait for <media-theme> and the shadow button to exist  
  await page.waitForSelector('media-theme');  
  await page.waitForFunction(() => {  
    const host = document.querySelector('media-theme');  
    return !!host?.shadowRoot?.querySelector('.download-button');  
  });  
  
  // Click the shadow-root DOWNLOAD BUTTON (do it inside page.evaluate to avoid stale handles)  
  await page.evaluate(() => {  
    const host = document.querySelector('media-theme');  
    const btn = host?.shadowRoot?.querySelector('.download-button');  
    if (btn) btn.click();  
  });  
  
  // Click the submit button; if it navigates, wait for it (don't fail if it doesn't)  
  await page.waitForSelector('[type="submit"]', { visible: true });  
  await Promise.all([  
    page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => null),  
    page.click('[type="submit"]'),  
  ]);  
  
  // Small pause between iterations (tweak as needed)  
  await page.waitForTimeout(3000);  
}
```

After running this script in the Puppeteer IDE, the browser would automatically go to the next lessons one at a time:
![[Pasted image 20251123223515.png]]

![[Pasted image 20251123223537.png]]

![[Pasted image 20251123223559.png]]

So far downloaded:
![[Pasted image 20251123222237.png]]

This might become a drag if you have to do it 5 at a time. If you wish to automate further, consider modifying the above automation script to console log all the curl commands at a larger batch instead of 5, eg. 41 here:
![[Pasted image 20251123223927.png]]

```
// Output as cURL lines with 1-based index
let straightCopy = '';
console.log('--- cURL COMMANDS ---');
if(OFFSET_START_CURL!==0) OFFSET_START_CURL = OFFSET_START_CURL - 1;
srcs.forEach((url, idx) => {
  straightCopy += `cURL -o ${FILENAME}${OFFSET_START_CURL + idx + 1}.mp4 ${url}\n`;
});
console.log(straightCopy);
```

And going to the Console tab when the Puppeteer IDE script finishes running:
![[Pasted image 20251123224626.png]]
```
--- cURL COMMANDS ---
cURL -o lesson-1.mp4 https://assets-v3.circle.so/llxu6n3ekb54aa1q4nptyt550wef
cURL -o lesson-2.mp4 https://assets-v3.circle.so/yyxu1n2ecb51ab0q3npuyt550wea
```

The cURL would've been ran in terminal one by one or through a batched process like a .sh file:
![[Pasted image 20251123224741.png]]

---

Tip when downloading multiple times in the console (if not developing a sh file):

Pressing CMD+T opens a new tab in terminal to the same folder (as long it's not still loading from .bash_profile etc otherwise it will open to `~/`):

![[Pasted image 20251123230802.png]]