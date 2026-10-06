**Goal:** Existing sections that engage user with scroll revealed animations, 3d scroll controlled motions, seamless with easing. Is it not as "WOW" and overwhelming as [[Generate 3d website scrolling down - 2. Animating 3d assets and camera to tell a story]]

**Prompt: Scroll-driven 3D chapter experience from an existing long page**

Build a static, scroll-controlled “depth theater” from the **existing sections** of this long-scrolling page. Do not invent a new brand or fake content — reuse real copy, CTAs, images, links, and section order already on the page.

### Goal

Turn the page’s major sections into a **desktop GSAP + ScrollTrigger** experience where **scroll progress scrubs** chapter transitions (not click-to-animate, not autoplay). Mobile and `prefers-reduced-motion` must fall back to a normal stacked long page with the same content.

### Chapter model

1. Identify the page’s natural top-level sections (hero/intro, value paths or offerings, flagship/featured work, portfolio/work grid, hire/contact/CTA, etc.).
2. Map each to a **named chapter** with a stable `id` and a short rail label (e.g. Intro · Paths · Flagship · Work · Hire).
3. Keep chapter count small (about 4–6). Merge tiny sections; don’t split one idea across many pins.

### Desktop motion (≥768px, motion allowed)

- Pin a full-viewport **stage**; scrub a single timeline to scroll (`scrub` ~0.3–0.5).
- Chapters enter/exit in **perspective**: `rotateX`, `z`, slight `y`, `autoAlpha` — incoming from below/back, outgoing up/away.
- Optional secondary depth on key cards (`rotationY`, small `translateZ`) only where it sells the content.
- Scroll **backward** must reverse cleanly to earlier chapters.
- Side **chapter rail** jumps to scrub positions; update `aria-current` and hash without breaking the scrub.
- End scroll distance ≈ `viewport height × (chapters − 1)` (or equivalent), with a short hold on the last chapter.
- Decorative backgrounds (waves, grids, glows) must **never compete with text** — keep them low opacity / masked away from copy.

### Fallbacks

- `<768px` or `prefers-reduced-motion: reduce`: no pin, no 3D poses; chapters in document order; clear all transform leftovers.
- If GSAP/ScrollTrigger fail to load: same stacked layout.

### Tech constraints

- **Static hosting** (e.g. GitHub Pages): HTML/CSS/JS only — no PHP, no server runtime.
- Prefer CDN or vendored GSAP + ScrollTrigger.
- Match existing site tokens (colors, type, header height for pin `start`).
- Soft sell: no invented metrics, pricing, or ROI claims.
- Accessibility: keyboard rail, readable contrast, reduced-motion path.

### Integration options (pick one, state it in the PR)

- **A.** Standalone route `/scroll/` + quiet link from home, **or**
- **B.** Config flag (e.g. `config.json` `{ "homeScroll": true }`) so `/` redirects to the scroll story; `?classic=1` keeps the original home.

### Deliverables

1. Working demo URL/path and how to run locally.
2. Files changed + brief note on chapter mapping (which DOM sections → which chapters).
3. PR against the repo’s default branch (same repo — no new repo).
4. Checklist: desktop scrub forward/back, rail jumps, mobile stack, reduced-motion, text readable over décor.

### Non-goals

Separate marketing microsite, React/Vite unless the host already is, PHP, autoplaying timelines, or burying the real portfolio behind the theater.