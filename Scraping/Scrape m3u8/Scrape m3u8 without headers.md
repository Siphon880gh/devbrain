Requirement: ffmpeg installed on system (usually your computer where you will scrape/download to). If you do not have ffmpeg, installation instructions are at "Web app ready - Ffmpeg, cytypes, imagemagick, pcregrep" over at https://codernotes.wengindustries.com

## Seeing Blob URL and Getting the m3u8 URL

You may have first inspected the `<video>` tag and found it pointing to a **temporary `blob:` URL**, which is **not directly downloadable** — it’s a browser memory reference created at runtime.  However, the underlying media file is actually an **HLS stream** (`.m3u8`), which _can_ be downloaded if you follow these steps:

To access the m3u8 file url, have the Network tab opened while you refreshed the webpage. Then filter search for: m3u8

You can copy the URL from the result:

![[Pasted image 20251123045558.png]]

If there is more than one `playlist.m3u8`, usually:
playlist.m3u8, playlist_1.m3u8, we will go by the master playlist (`playlist.m3u8`)

## Ffmpeg downloads and pieces together the m3u8 file

Open the terminal and (hopefully you have ffpmeg installed), run:
```
ffmpeg -i "https://cdn-media.example.com/c8086da5-f48f-4fbf-8f8e-dfc13402fb79/hls/playlist.m3u8" -c copy OUTPUT.mp4
```

Ffmpeg downloads and pieces together the m3u8 file:
![[Pasted image 20251123044747.png]]

---

## Troubleshooting - Command does not exist / ffmpeg not installed

Expect an "OUTPUT.mp4" to output where the terminal is at. 

> [!note] Command does not exist / ffmpeg not installed?
> If you do not have ffmpeg installed or it complains that the command does not exist, refer to "Web app ready - Ffmpeg, cytypes, imagemagick, pcregrep" over at https://codernotes.wengindustries.com for ffmpeg installation instructions.

---

## Troubleshooting - Authorization

If it complains about authorization or 4XX errors, very likely this file is protected asset. An asset is usually protected in either one of these ways:
- Token in the URL
- Certain expected headers. We don't know if it's expecting just a token header or it also expects user agent or even more headers. That depends on how much protection is implemented.

If it's token in the URL, you would have seen it in the Network tab earlier, and your command would have been:
```
ffmpeg -i "https://cdn-media.circle.so/bcdn_token=_kc_oAN285s1KVbXMP-7lcb-SQsKbqPVza4r5uz9fxQ&token_path=%2Fc8086da5-f48f-4fbf-8f8e-dfc13402fb79%2F&expires=1761652557/c8086da5-f48f-4fbf-8f8e-dfc13402fb79/hls/playlist.m3u8" -c copy salu-2.mp4
```