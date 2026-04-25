
## Why

PageSpeed Insights may show that your webpage’s performance score is low, which can negatively impact your Google search ranking. One of the common issues it highlights is a high **Largest Contentful Paint (LCP)**.
![[Pasted image 20250827032014.png]]

And when you expand the LCP report, you might find that the main cause is a video embedded on the page.

---

### ✅ 1. **HTTP Pseudo-Streaming (Byte Ranges)**

- Enables video playback before full download.
- Browser requests chunks via `Range: bytes=...`.
- Requires `.mp4` format and server support (e.g., Nginx).

---

### ⚡ 2. **FastStart (Web-Optimized MP4)**

- MP4 files must contain a **`moov` atom** (metadata) near the **beginning** of the file.
	- Namesake: The “atom” name comes from each MP4 piece being a fundamental, self-contained unit of data. The moov atom (short for movie) uses a four-character code, following the same convention as others like mdat (media data) and trak (track). It stores essential metadata—timescale, duration, display info, and track details—essentially acting as the file’s table of contents.
    
- If `moov` is at the **end**, the browser must **download the entire file** before playback begins.
    
- 🔧 **Why it happens**: Many encoders (e.g. FFmpeg, HandBrake, Adobe) write video first, then metadata, putting `moov` at the end by default.
    
- ✅ **Fix with FFmpeg**:
    
```bash
ffmpeg -i z.mp4 -c:v libx264 -crf 20 -preset slow -pix_fmt yuv420p -c:a aac -b:a 128k -movflags +faststart zz_fastmov.mp4
```
    
- 🧪 Check with `mp4dump`:
    
    ```bash
    brew install bento4
    mp4dump file.mp4 | head -n 20
    ```
    
^ Look for `[moov]` before `[mdat]`. If that is the case, then your video is fast start optimized.
^ Here's an example of the moov atom where it should be for faststart optimization:
```
[ftyp] size=8+24
...
[moov] size=8+1995
[mdat] size=8+...
```

The `ftyp` (File Type Box) is the very first atom in a properly structured MP4. It defines the file’s specification or profile—known as its “brand.”

Not faststart optimized:
```
[ftyp] size=8+24
...
[mdat] size=8+...
[moov] size=8+1995
```

---

### ⏱️ 3. **preload="metadata" for `<video>`**

- Loads only video metadata (e.g., duration) during page load.
    
- Reduces initial bandwidth while still enabling preview.
    

```html
<video preload="metadata" controls poster="preview.jpg">
  <source src="video.mp4" type="video/mp4">
</video>
```

---

### 🌐 4. **Adaptive Bitrate Streaming (Optional)**

- Encodes multiple video qualities.
- Browser/player switches based on network speed.
- Requires HLS/DASH setup + compatible video player.

---

## 🧾 Summary Table

|Feature|Benefit|Tools|
|---|---|---|
|FastStart (`+faststart`)|Instant playback; metadata at front|FFmpeg, HandBrake|
|CRF Encoding|Smaller file size, good quality|`-crf 20`, `libx264`|
|Byte-Range Support|Seamless seeking & partial loading|Nginx, Apache|
|Metadata Preload|Faster page load, minimal bandwidth|`preload="metadata"`|
|ABS (HLS/DASH)|Smoother experience across devices|ffmpeg + hls.js/dash.js|
