# TimelineJS — Getting Started

← [[TimelineJS (Knight Lab)]]

No-code path: Google Sheet → publish → embed.

---

## 5 Steps

1. Copy the [spreadsheet template](https://drive.google.com/previewtemplate?id=1pHBvXN7nmGkiG8uQSUB82eNlnL8xHu6kydzH_-eguHQ&mode=public).
2. Fill rows. **Do not change headers or delete columns.**
3. **File → Share → Publish to the web** → copy URL from that dialog.
4. Paste URL into [authoring tool step 3](https://timeline.knightlab.com/#make).
5. Copy share link or iframe embed to your site.

Sheet edits apply live after first publish. **Never delete the source sheet.**

---

## Spreadsheet Columns

Headers in row 1 must stay unchanged.

| Col | Field | Use |
|---|---|---|
| A–D | Year, Month, Day, Time | Start |
| E–H | End Year … End Time | Optional span in time nav |
| I | Display Date | Label override |
| J–K | Headline, Text | Slide copy (HTML OK) |
| L–N | Media, Credit, Caption | URL + attribution |
| O | Media Thumbnail | Time-nav marker image |
| P | Alt Text | Image accessibility |
| Q | Type | `title`, `era`, or blank |
| R | Group | Cluster events into rows |
| S | Background | CSS color or image URL |

**Special rows**

- `title` in Type → intro slide, no date, always first
- `era` in Type → labeled span on time axis (needs start + end dates)
- Same Group value → events share a nav row

**Dates:** BCE = negative year (`-500`). For hour/minute detail see [[TimelineJS - Time Marks]].

---

## Pitfalls

- Blank row after last event → later rows never load (hidden rows count)
- Random text in Type column → broken layout
- Sheet must be public when published — use JSON for private data ([[TimelineJS - JavaScript & JSON]])

---

## iframe Embed

```html
<iframe src="https://cdn.knightlab.com/libs/timeline3/latest/embed/index.html?source=YOUR_SHEET_URL&font=Default&lang=en&initial_zoom=2&height=650" width="100%" height="650" frameborder="0"></iframe>
```

Useful params: `font`, `lang`, `initial_zoom`, `timenav_position`, `theme=contrast`, `start_at_end`.

`hash_bookmark` works on direct links, not iframes.

---

## Media (Quick Reference)

Paste a URL in column L. TimelineJS auto-detects type.

| Type | Examples |
|---|---|
| Image | `.jpg`, `.png`, `.gif` |
| Video | YouTube, Vimeo, TikTok, `.mp4` |
| Audio | SoundCloud, Spotify, `.mp3` |
| Social | Twitter/X, Bluesky, Flickr |
| Maps | Google Maps URL |
| Docs | Wikipedia, DocumentCloud |
| Fallback | `<iframe>` or `<blockquote>` in Media cell |

Instagram embeds not supported. Media images are not clickable — put links in caption/text.

Full list: https://timeline.knightlab.com/docs/media-types.html
