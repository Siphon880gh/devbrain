Depends on if there's a download button on the video player

There's a Download button - so it's not protected:

![[Pasted image 20251123192028.png]]
Clicking the download button likely will download a mp4 or video file


---

vs

---

There's no download button so likely it's protected
![[Pasted image 20251123191736.png]]


The likely protection mechanism is having a m3u8 playlist file that gets pieced together as the video plays on the webpage. Fortunately with ffmpeg command, it can both download and then piece them together into a video.

But it also depends on how protected the m3u8 playlist is. Usually there's an expiration token. If the token it already part of the m3u8 url, then it's likely okay to just ffmpeg the m3u8 directly (as long as it hasn't expired between the time you get the URL and the time you download with ffmpeg command). 

if the m3u8 playlist 4XX errors or authorization/forbidden errors when using ffmpeg even with tokens in the URL, then it requires headers that are sent when viewed on the actual page, which you can emulate in ffmpeg command but it requires some detective work to figure out.

---

How you scrape the video will depend on:
- Is it a direct download or a m3u8 download
- Is the m3u8 download protected with headers
- are you downloading one file or multiple files (all the lessons on the right):
  When downloading multiple files, you're likely trying to download all the lessons on the right:
  
![[Pasted image 20251123215728.png]]

