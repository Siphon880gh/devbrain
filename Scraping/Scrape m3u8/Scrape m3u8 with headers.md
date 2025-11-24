A m3u8 URL fails to fetch using ffmpeg command in terminal. It complains about 4XX errors or authorization/forbidden errors, very likely this file is protected asset. 

An asset is usually protected in either one of these ways:
- Token in the URL
- Certain expected headers. We don't know if it's expecting just a token header or it also expects user agent or even more headers. That depends on how much protection is implemented.

If you need to pass headers, the ffmpeg command could get long. eg.
```
ffmpeg -headers "Hvar1: hvalue1\r\nHvar2: hvalue2\r\nHvar3: hvalue3\r\n" -i "http://media.link/mediafile.m3u8" -t 30 -c copy output.mkv -loglevel debug
```

What headers are you passing? On the webpage showing the video, if you sniff m3u8 at the Network tab, it will clue you in.

If you open DevTools → **Network** tab and:

1. Load the page with the video.
2. Filter by `m3u8`, `media`, or `xhr/fetch`.
3. Click the `.m3u8` request (and sometimes the segment requests like `.ts`, `.m4s`).

Then under **Request headers**, you’ll see:
- `User-Agent`
- `Referer`
- `Origin`
- `Cookie`
- `Authorization` (if used)
- Any custom headers like `x-auth-token`, `x-client-id`, etc.

These are exactly the things you often need to replicate in `ffmpeg` (via `-headers` or `-user_agent`, `-referer`, etc.) to make the server treat `ffmpeg` like the browser.

It will also show:
- The **full URL** to the m3u8, including any signed/query tokens (`?token=...&Policy=...&Expires=...`), which are critical.

**⚠️ Caveats / gotchas**

1. **Not all headers matter.**  
    A lot of browser-only stuff is usually irrelevant for ffmpeg:
    
    - `sec-ch-ua`, `sec-fetch-*`, `accept-language`, `accept-encoding`, etc.  
        You often just need:
    - `User-Agent`
    - `Referer`
    - `Origin` (sometimes)
    - `Cookie` (if there’s a session)
    - Any obvious auth/custom headers.
    
2. **Tokens can expire.**  
    If the URL or headers include signed tokens (`Policy`, `Signature`, `Key-Pair-Id`, `token=...`, `Expires=...`), they might work for a while then start giving you 403s. You may need to re-sniff a fresh one.
    
3. **Some protection is more complex.**  
    If the site uses:
    - JS challenges (Cloudflare-style),
    - rotating tokens,
    - DRM (Widevine/FairPlay, etc.),  
        then simply copying headers may _still_ not be enough.

---

Same rules applies from [[Scrape m3u8 without headers]]. Running the ffmpeg command as long as you get the correct headers, it will download and piece together the video file on your computer
