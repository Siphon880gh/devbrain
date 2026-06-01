After scraping, your downloaded file might be:
- muted video
- black video with audio
- audio/music only

This usually happens when the `.m3u8` uses separate HLS streams for video and audio.

Not every `.m3u8` works this way. Some platforms use a simpler playlist where downloading the `.m3u8` directly gives you a normal video file with audio included.

In HLS, the master playlist may reference multiple child playlists, for example:
- one playlist for video
- one playlist for audio
- sometimes multiple quality levels for each

If you download only the video playlist, you may get video with no sound.  
If you download only the audio playlist, you may get audio with a black screen or audio-only file.

The fix is to either:
1. Use the master `.m3u8` URL so `ffmpeg` can automatically select and combine the streams.
2. Download the video and audio streams separately, then recombine them with `ffmpeg`.

`ffmpeg` can download a remote `.m3u8` URL directly and create the final video file, such as an `.mp4`, on the fly.

Example:

```bash
ffmpeg -headers "$HEADERS" -i "$MASTER_M3U8_URL" -c copy output.mp4
````

Or, if you already downloaded the video-only and audio-only files:

```bash
ffmpeg -i "video.mp4" -i "audio.m4a" -c:v copy -c:a copy -shortest "skool-video-final.mp4"
```