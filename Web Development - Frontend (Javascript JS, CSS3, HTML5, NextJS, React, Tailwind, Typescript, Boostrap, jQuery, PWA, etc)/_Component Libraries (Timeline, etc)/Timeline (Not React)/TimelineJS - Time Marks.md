# TimelineJS — Time Marks

← [[TimelineJS (Knight Lab)]]

TimelineJS supports **hour, minute, second, and millisecond** precision — enough for a timeline of one day or a shift crossing midnight.

---

## Google Sheet (columns D & H)

| Format | Example |
|---|---|
| Hour | `19` |
| Hour:minute | `14:30` |
| Hour:minute:second | `23:15:00` |
| 12-hour | `7:30 AM`, `7:30 PM` |
| Compact | `1430` |

- Start: columns **A–D**
- End (optional span): **E–H**
- Custom label: column **I** (`07:30 AM`) — display only, positioning still uses A–H

Same-day events sort by time automatically.

For short spans, set **`initial_zoom`** to `5`–`8` in the [authoring tool](https://timeline.knightlab.com/#make) or JS options.

---

## JSON

```json
"start_date": {
  "year": 2025, "month": 6, "day": 21,
  "hour": 14, "minute": 30, "second": 0
}
```

Optional on any date object: `millisecond`, `display_date`, `format`.

---

## Example Use Cases

| Use case | See |
|---|---|
| Nursing shift 19:00 → 07:30 | [[TimelineJS - Nursing Shift Recipe]] |
| Hourly schedule for one day | Same patterns; one calendar date in A–C |
