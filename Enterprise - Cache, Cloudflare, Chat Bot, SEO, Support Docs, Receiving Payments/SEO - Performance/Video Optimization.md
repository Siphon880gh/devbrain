
When adding videos to a website, two challenges usually come up:

1. **File size is too large** → slows down page load and hurts SEO scores.
2. **Video won’t play instantly** → the browser waits until it has enough data before starting playback.

Here’s how to fix both.

---

## 1. Use CRF to Control Quality vs. File Size

When encoding video with **FFmpeg**, the most important setting is **CRF (Constant Rate Factor)**. It balances size and quality.

- **Lower CRF (e.g., 18–20)** → higher quality, bigger files.
    
- **Higher CRF (e.g., 23–28)** → smaller files, but more compression.
    

👉 For the web, a **CRF of 20–23** is usually the sweet spot: small enough to load quickly, but still sharp enough for most screens.

---

## 2. Enable Fast Playback With `faststart`

MP4 files contain a **moov atom**, which holds the “table of contents” for the video.

- If the moov atom is **at the end** (common with some encoders), the browser **must download the whole file before playing**.
    
- If the moov atom is **moved to the beginning**, playback can start right away while the rest downloads in the background.
    

FFmpeg makes this easy with the flag:

```bash
-movflags +faststart
```

This alone can dramatically improve how fast videos feel on your site.

---

## 3. Recommended FFmpeg Command for Web Videos

Here’s a one-liner you can use to generate a web-optimized MP4:

```bash
ffmpeg -i input.mov \
  -c:v libx264 -crf 20 -preset slow -pix_fmt yuv420p \
  -c:a aac -b:a 128k \
  -movflags +faststart \
  output_fastmov.mp4
```

**Explanation:**

- `-c:v libx264` → Uses H.264, the most widely supported video codec.
- `-crf 20` → High quality, smaller than lossless (use 23 for smaller files, 18 for max quality).
- `-preset slow` → Better compression (can use `faster` if speed matters).
- `-pix_fmt yuv420p` → Ensures compatibility with all browsers/devices.
- `-c:a aac -b:a 128k` → Standard web audio settings.
- `-movflags +faststart` → Moves the moov atom to the front.

---

## 4. Other Quick Wins

- **Use preload="metadata"** on `<video>` tags to avoid unnecessary loading.
- **Compress poster images** (and lazy-load them) to save bandwidth.
- **Consider WebM (VP9/AV1)** for additional savings, with MP4 as fallback for Safari.

---

## 5. Bottom Line

For web delivery, the two key things are:  
✅ Use **CRF around 20–23** to keep size manageable.  
✅ Always **add `-movflags +faststart`** so the video can play immediately.

This balance keeps your pages light, fast, and SEO-friendly—while ensuring visitors don’t wait around for your videos to load.