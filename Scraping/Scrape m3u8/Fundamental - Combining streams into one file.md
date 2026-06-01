Refer to [[Common pitfall - Scraped only the video or music track]] to understand that there may be multiple m3u8 files. Some platforms require you to combine the files back into one file:

Note in this example, two m3u8 files are downloaded. They resulted in files that can only play as mp4 or m4a. If the audio file were played as a mp4, it still plays audio but with no picture.

Combine them with ffmpeg command:
```
ffmpeg -i "video.mp4" -i "audio.m4a" -c:v copy -c:a copy -shortest "skool-video-final.mp4"
```