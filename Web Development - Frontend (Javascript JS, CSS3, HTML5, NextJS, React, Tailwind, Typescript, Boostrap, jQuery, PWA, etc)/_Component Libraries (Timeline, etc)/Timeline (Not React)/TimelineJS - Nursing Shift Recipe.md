# TimelineJS — Nursing Shift Recipe

← [[TimelineJS (Knight Lab)]] · [[TimelineJS - Time Marks]]

Shift timeline: **19:00 → 07:30 next day** (med pass, rounds, charting, handoff).

---

## Google Sheet

Use the [template](https://drive.google.com/previewtemplate?id=1pHBvXN7nmGkiG8uQSUB82eNlnL8xHu6kydzH_-eguHQ&mode=public). Example rows:

| Year | Month | Day | Time | End Year | End Month | End Day | End Time | Headline | Group |
|---|---|---|---|---|---|---|---|---|---|
| 2025 | 6 | 21 | 19:00 | | | | | Med Pass | Meds |
| 2025 | 6 | 21 | 23:00 | | | | | Charting & Rounds | Charting |
| 2025 | 6 | 21 | 19:00 | 2025 | 6 | 22 | 7:30 AM | Shift Span | Shift |

Tips:

- **Group** (col R): Meds, Vitals, Charting, Breaks
- **Display Date** (col I): friendly labels like `07:30 AM`
- **initial_zoom** `6`–`8` in authoring tool for ~12-hour window
- No blank rows → publish → [authoring tool](https://timeline.knightlab.com/#make)

See [[TimelineJS - Getting Started]] for full column reference.

---

## JSON

Calendar date is a placeholder; **time** drives layout.

```json
{
  "title": {
    "text": { "headline": "Nursing Shift", "text": "19:00 – 07:30" }
  },
  "events": [
    {
      "start_date": { "year": 2025, "month": 6, "day": 21, "hour": 19, "minute": 0 },
      "text": { "headline": "Start Shift", "text": "Report, vitals, med pass." },
      "group": "Shift"
    },
    {
      "start_date": { "year": 2025, "month": 6, "day": 21, "hour": 23, "minute": 0 },
      "text": { "headline": "Charting & Rounds", "text": "Night documentation." },
      "group": "Charting"
    },
    {
      "start_date": { "year": 2025, "month": 6, "day": 21, "hour": 19, "minute": 0 },
      "end_date": { "year": 2025, "month": 6, "day": 22, "hour": 7, "minute": 30 },
      "text": { "headline": "Shift Span", "text": "Full shift window." },
      "group": "Shift"
    }
  ]
}
```

```javascript
new TL.Timeline('timeline-embed', shiftData, {
  initial_zoom: 7,
  timenav_height: 200
});
```

Embed details: [[TimelineJS - JavaScript & JSON]]

---

## Extras

| Need | How |
|---|---|
| Color-code tasks | Background col S or JSON `background` |
| Protocol PDFs / maps | Media col L |
| Private data | JSON + self-hosted JS |
| Task checklists in popup | [[TimelineJS - Custom Modals]] |

---

## Sheets vs JSON

| | Sheets | JSON |
|---|---|---|
| Who edits | Anyone with sheet access | Developer |
| Midnight span | End cols E–H | `end_date` next day |
| Privacy | Public when published | Server-controlled |
| Modals | Harder | Custom fields + JS |
