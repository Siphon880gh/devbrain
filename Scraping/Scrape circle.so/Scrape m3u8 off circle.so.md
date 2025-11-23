**Q:** When looking at a course website using circle.so, sniffing the network tab in chrome devtools, I see  playlist.m3u8 and playlist_1.m3u8. But it looks like the playlist.m3u8 is sufficient. Why two?

**A:** You’re seeing a **master playlist** and a **variant (media) playlist**.

- **playlist.m3u8** → almost certainly the **master**. It lists one or more renditions with tags like `#EXT-X-STREAM-INF` (different bitrates/resolutions) and optionally `#EXT-X-MEDIA` (alt audio/subtitles). A player only needs this one; it will pick the best rendition and switch as bandwidth changes (ABR).
    
- **playlist_1.m3u8** → a **media playlist** for a single rendition (e.g., 720p @ 3 Mbps). It contains the actual segments via `#EXTINF` lines. If you open this directly, the video plays but **you lose adaptive switching** (it’s locked to that one track).
### Optional - How to confirm in DevTools

Open each in a tab or the Preview pane:

- **Master** will have `#EXTM3U` and **`#EXT-X-STREAM-INF`** (and maybe `#EXT-X-MEDIA`).
    
- **Media** will have `#EXTM3U`, **`#EXT-X-TARGETDURATION`**, `#EXT-X-MEDIA-SEQUENCE`, multiple **`#EXTINF`** segment entries, and no `#EXT-X-STREAM-INF`.
### Why both show up

The player fetches the master first, then fetches one (or more) media playlists (often named with suffixes like `_0`, `_1`, `_2`) to pull segments. So **the master is “sufficient”** for playback logic, while the numbered one is the **specific track** the player chose at that moment.

---

### Final Point: Which to scrape

Simply scrape off the master player (No `_#` suffix). Refer to [[Scrape m3u8 without headers]]