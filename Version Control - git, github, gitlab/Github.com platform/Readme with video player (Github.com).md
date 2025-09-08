Get the URL of the video. If it's your own video in your branch, grab the URL by visiting the file from browsing the code at Github.com. 

If the video preview fails because it's too large, you'll see a "View raw" link. You can right click "View raw" -> "Copy Link Address".
![[Pasted image 20250907211633.png]]

Link is in the format of `https://github.com/USERNAME/REPO/raw/refs/heads/....mov` (mov, mp4, etc depending on your file extension)

Alternately, you could drag the video from your computer into their Readme editor at Github.com. It'd upload to their servers, and the link format would be in the format of `https://user-images-githubusercontent.com/....mov`  (mov, mp4, etc depending on your file extension)

---

If you're editing it into your Readme:
```
<div style="text-align:center; margin-bottom:24px;">
	<video width="600px" src="https://user-images-githubusercontent.com/....mov"></video>
</div>
```

![[Pasted image 20250907195930.png]]