
There are two levels of protection

## Protection Level 1: m3u8 with expiration token in the URL
On circle.so, if there's no download button on the video player, it's protected meaning it uses a m3u8 playlist file rather than a mp4 file that the user can download directly.

It's protected by the means of an expiration token that shows up in the URL of the m3u8 that appears in Chrome. The next question is whether the user had enabled it to be even more protected.

## Protection Level 2: m3u8 requiring specific headers

If you download/piece together with ffmpeg, and there are 4XX errors or authorization/forbidden errors, then it's even more protected with headers:
![[Pasted image 20251123190557.png]]

If protected, you have to work hard at figuring out the protective mechanism, referring to [[Scrape m3u8 with headers]].