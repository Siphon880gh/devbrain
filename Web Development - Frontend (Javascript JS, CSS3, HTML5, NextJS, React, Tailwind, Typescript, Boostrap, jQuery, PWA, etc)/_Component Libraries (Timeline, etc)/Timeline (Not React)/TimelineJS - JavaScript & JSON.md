# TimelineJS — JavaScript & JSON

← [[TimelineJS (Knight Lab)]]

Use when you need privacy, custom styling, modals, or bundler integration.

---

## CDN Embed

```html
<link rel="stylesheet" href="https://cdn.knightlab.com/libs/timeline3/latest/css/timeline.css">
<div id="timeline-embed" style="width:100%;height:600px"></div>
<script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
<script>
  var timeline = new TL.Timeline('timeline-embed', DATA_SOURCE, {
    initial_zoom: 2,
    hash_bookmark: true
  });
</script>
```

`DATA_SOURCE` = Google Sheet pub URL, JSON file URL, or inline JSON object.

Cross-origin JSON needs CORS on the host server.

---

## JSON Shape

```json
{
  "title": { "text": { "headline": "Optional title slide" } },
  "events": [ /* required */ ],
  "eras": [ /* optional axis labels */ ],
  "scale": "human"
}
```

Per event: `start_date`, `end_date`, `text`, `media`, `group`, `display_date`, `background`, `unique_id`.

- BCE: negative `year`
- Cosmological scale: `"scale": "cosmological"` for extreme ancient dates

Ref: https://timeline.knightlab.com/docs/json-format.html

---

## npm

```javascript
import { Timeline } from '@knight-lab/timelinejs';
import '@knight-lab/timelinejs/dist/css/timeline.css';
```

API events: `change`, `loaded`, `nav_next`, `nav_previous`, `zoom_in`, `zoom_out`.

Methods: `goTo()`, `goToId()`, `getDataById()`, `add()`, `remove()`.

Ref: https://github.com/NUKnightLab/TimelineJS3/blob/master/API.md

---

## Key Options

| Option | Notes |
|---|---|
| `initial_zoom` | 0–10; higher = tighter time window |
| `timenav_position` | `top` or `bottom` |
| `start_at_slide` / `start_at_end` | Opening position |
| `hash_bookmark` | URL hash per slide |
| `font` | Built-in name or custom CSS URL |
| `theme` | `contrast` for accessibility |
| `language` | 50+ locale codes |
| `soundcite` | Enable SoundciteJS clips in text |

Full list: https://timeline.knightlab.com/docs/options.html

---

## Styling

- Built-in font pairs via `font` option
- Per-slide background: sheet col S or JSON `background`
- Override CSS: https://timeline.knightlab.com/docs/overriding-styles.html
- Key classes: `.tl-timeline`, `.tl-slide`, `.tl-timenav`, `.tl-timemarker`

---

## Platform Notes

- Tested primarily in Chrome; no IE9 and below
- WordPress.com: embed blocked; self-hosted WP has a [plugin](https://wordpress.org/plugins/knight-lab-timelinejs/)
- Private data: JSON + server access control, not public Google Sheet
