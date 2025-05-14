Structured data for events helps your product demo **appear in Google Search with enhanced visibility**, including:

- 📅 Date & time of the event
- 🌐 Virtual/online location
- 🔗 Link to register or join
- 🎯 Event description and audience

---

## ✅ Recommended Schema Type

|Schema.org Type|Purpose|
|---|---|
|`Event`|General event markup|
|`OnlineEventAttendanceMode`|Indicates it’s a virtual event|
|`VirtualLocation`|Used to define a Zoom or online link|
|`Offer`|Used to include free/paid registration|

---

## 🧱 Example: JSON-LD for a Zoom Product Demo

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Event",
  "name": "Live Zoom Demo: How Our Product Solves [Problem]",
  "description": "Join our free 30-minute Zoom demo where we walk through our product features and answer live Q&A.",
  "startDate": "2025-06-12T10:00:00-07:00",
  "endDate": "2025-06-12T10:30:00-07:00",
  "eventAttendanceMode": "https://schema.org/OnlineEventAttendanceMode",
  "eventStatus": "https://schema.org/EventScheduled",
  "location": {
    "@type": "VirtualLocation",
    "url": "https://zoom.us/j/1234567890"
  },
  "organizer": {
    "@type": "Organization",
    "name": "Your Company Name",
    "url": "https://yourcompany.com"
  },
  "image": [
    "https://yourcompany.com/assets/demo-banner.jpg"
  ],
  "offers": {
    "@type": "Offer",
    "url": "https://yourcompany.com/demo-registration",
    "price": "0",
    "priceCurrency": "USD",
    "availability": "https://schema.org/InStock",
    "validFrom": "2025-05-14T09:00:00-07:00"
  }
}
</script>
```

---

## 🧠 Tips for Zoom Demos

- Use a **specific event title** (e.g., "Demo: Automate Payroll in Under 10 Minutes")
    
- The `offers` object is still valid even for free events — just set `price` to `"0"`
    
- If you do **recurring demos**, it’s best to mark up **each occurrence individually** rather than batching them
    

---

## 🔍 Benefits in Google Search

- May show up in the **Events rich result panel**
    
- Can boost CTR by adding clarity around date/time/availability
    
- Helps with **calendar app indexing** (like Google Calendar or Apple’s Spotlight suggestions)
    

---

### 🔁 **Recurring Events in Structured Data**

Schema.org does **not officially support recurrence rules** (like `RRULE` in iCalendar). So for SEO and rich results:

- ✅ **List each occurrence** as its own `Event` object.
- ❌ Do not try to use cron-style or iCal recurrence rules in JSON-LD.
- Use `@graph` to group multiple events on one page if needed.
    
#### Example (Two weekly demos shown explicitly):

```json
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Event",
      "name": "Product Demo - June 12",
      "startDate": "2025-06-12T10:00:00-07:00",
      "location": { "@type": "VirtualLocation", "url": "https://zoom.us/j/123" }
    },
    {
      "@type": "Event",
      "name": "Product Demo - June 19",
      "startDate": "2025-06-19T10:00:00-07:00",
      "location": { "@type": "VirtualLocation", "url": "https://zoom.us/j/456" }
    }
  ]
}
```

> ✅ Best Practice: Automate generation of this JSON-LD if your events are frequent and predictable.
