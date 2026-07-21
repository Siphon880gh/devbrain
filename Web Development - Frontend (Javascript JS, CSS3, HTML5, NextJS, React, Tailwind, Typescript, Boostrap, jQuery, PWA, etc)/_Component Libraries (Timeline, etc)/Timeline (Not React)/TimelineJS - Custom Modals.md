# TimelineJS — Custom Modals

← [[TimelineJS (Knight Lab)]] · Requires [[TimelineJS - JavaScript & JSON]]

**No built-in modals.** Slides show content in the main panel. For extra detail in a popup, add your own HTML/CSS/JS.

---

## Pattern

1. Instantiate with `new TL.Timeline(...)` — not iframe-only
2. Listen for slide changes
3. Read slide data
4. Show `<dialog>`, Bootstrap modal, etc.

```javascript
var timeline = new TL.Timeline('timeline-embed', timelineData, options);

timeline.on('change', function (data) {
  var slide = timeline.getDataById(data.unique_id);
  showModalForSlide(slide);
});
```

Also available: `nav_next`, `nav_previous`. There is no native `click` event on markers.

---

## Extra Fields in JSON

Add custom properties; TimelineJS ignores them, your modal code reads them:

```json
{
  "start_date": { "year": 2025, "month": 6, "day": 21, "hour": 19 },
  "text": { "headline": "Med Pass", "text": "Summary on slide." },
  "unique_id": "med-pass-1900",
  "modalContent": "<p>Full MAR details…</p>"
}
```

```javascript
timeline.on('change', function (data) {
  var slide = timeline.getDataById(data.unique_id);
  var html = slide.modalContent || slide.text.text;
  document.querySelector('#shift-modal').innerHTML = html;
  document.querySelector('#shift-modal').showModal();
});
```

---

## Checklist

| Step | Do |
|---|---|
| 1 | JS embed, not iframe |
| 2 | `timeline.on('change', …)` |
| 3 | `getDataById()` or `getData()` |
| 4 | Your modal markup + show/hide |
