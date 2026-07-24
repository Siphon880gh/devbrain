Free (or freemium) tools for animated or interactive timelines:

---

## TimelineJS (Knight Lab)

→ Hub: [[TimelineJS (Knight Lab)]]

Open-source JS timeline. Spreadsheet or JSON input. Rich media embeds.

| Topic | Note |
|---|---|
| Setup | [[TimelineJS - Getting Started]] |
| Hour/minute schedules | [[TimelineJS - Time Marks]] |
| Developer embed | [[TimelineJS - JavaScript & JSON]] |
| Click → modal | [[TimelineJS - Custom Modals]] |
| Shift example | [[TimelineJS - Nursing Shift Recipe]] |

---

## Runtime timeline options

### 2. vis-timeline (vis.js)

**Pros:** Strong for **dense** event strips, ranges, groups, zoom; good if past hx is many short entries on one axis.

**Cons:** Heavier integration; visual language less “chart narrative”; more custom styling for things like clinical panels.

**When to pick:** Pack authors need minute-level density or overlapping intervals on one axis.

---

### 3. Custom HTML list (no library)

**Pros:** Smallest footprint; full Tailwind control; matches panels-first MVP.

**Cons:** No built-in zoom/nav; reinvent sorting, grouping, and “focus event” UX.

**When to pick:** Past hx is a short bullet list per patient (≤10 entries) and E2.M1 scope stays thin.

---

### 4. iframe embed (TimelineJS authoring tool only)

Knight Lab’s spreadsheet-driven embed is fine for **marketing/docs**, not for **runtime patient packs** (external Google Sheet dependency, iframe sizing in panels).

**Do not use** for in-game census panels unless the user explicitly wants iframe embeds.

---

**Also considered (not for runtime panels):**

- **Chronoline.js** — older horizontal timeline; less maintained today
- **Timeglider** — commercial/education-focused interactive timelines
- **StorylineJS / similar embed widgets** — often iframe + external data (same drawbacks as TimelineJS spreadsheet embeds)

---

## MyLens AI Timeline Creator

- Free tier; paste log text, PDF, or links
- AI extracts dates and builds the timeline
- Best for hands-off automation from raw logs

---

## Template Tools (drag-and-drop)

**Genially**, **Visme**, **Adobe Express**, **Canva**, **Piktochart** — animated templates, manual entry, free tiers

---

## Other

- **Tiki-Toki** — multimedia/3D; one timeline on free plan
- **ChronoZoom** — open-source, historical scale; heavy setup

---

## Which Tool?

| Use case | Tool |
|---|---|
| AI parse from logs | MyLens AI |
| Spreadsheet → interactive | TimelineJS |
| Design templates | Genially, Visme, Canva |
