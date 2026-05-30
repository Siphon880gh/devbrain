# ScrollTrigger Tutorial: Build a Scroll-Based Landing Page Section

GSAP’s **ScrollTrigger** plugin connects animations to scroll position. In a normal animation, time controls the movement. With ScrollTrigger, the user’s scroll can start, scrub, pin, reverse, or control animation progress.

> [!note] Prerequisites
> Basic GSAP (`gsap.to`, `gsap.from`). For a gentler first project, complete [[Beginner GSAP Tutorial - Build a Mini Animation Demo App]] first.

---

## What we are building

A landing-page section where:

- The section **pins** (sticks) while the user scrolls
- Cards animate in one by one
- A progress bar fills as the section scrolls
- Text slides and fades into place
- Animation progress is **controlled by scroll**

```txt
[Normal hero section]

Scroll down...

┌──────────────────────────────────────┐
│  How It Works                         │
│  Step 1: Plan                         │
│  Step 2: Animate                      │
│  Step 3: Launch                       │
│                                      │
│  Cards reveal as you scroll           │
└──────────────────────────────────────┘

[Next page section]
```

Common on:

- Feature walkthroughs
- Product demos
- Process sections
- Portfolio case studies
- SaaS landing pages
- Before/after storytelling

---

## Basic setup

Create `index.html`. This tutorial uses **CDN scripts** so you can open the file in a browser without a build step.

> [!note] npm alternative
> For production apps, install with `npm install gsap` and import `ScrollTrigger` from `gsap/ScrollTrigger`, then call `gsap.registerPlugin(ScrollTrigger)`.

---

## Full demo code

Paste into `index.html`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GSAP ScrollTrigger Landing Section</title>

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #0f172a;
      color: #ffffff;
      line-height: 1.6;
    }

    .hero,
    .after-section {
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 4rem 2rem;
      text-align: center;
    }

    .hero h1,
    .after-section h2 {
      font-size: clamp(2.5rem, 7vw, 6rem);
      line-height: 1;
      margin-bottom: 1rem;
    }

    .hero p,
    .after-section p {
      max-width: 650px;
      color: #cbd5e1;
      font-size: 1.1rem;
    }

    .scroll-section {
      min-height: 100vh;
      padding: 4rem 2rem;
      background: #111827;
      overflow: hidden;
    }

    .scroll-inner {
      max-width: 1200px;
      margin: 0 auto;
      min-height: 80vh;
      display: grid;
      grid-template-columns: 0.9fr 1.1fr;
      gap: 3rem;
      align-items: center;
    }

    .section-label {
      color: #38bdf8;
      text-transform: uppercase;
      letter-spacing: 0.15em;
      font-size: 0.8rem;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .scroll-copy h2 {
      font-size: clamp(2rem, 5vw, 4.5rem);
      line-height: 1;
      margin: 0 0 1rem;
    }

    .scroll-copy p {
      color: #cbd5e1;
      max-width: 500px;
      font-size: 1.05rem;
    }

    .progress-wrap {
      margin-top: 2rem;
      width: 100%;
      max-width: 420px;
      height: 8px;
      background: #334155;
      border-radius: 999px;
      overflow: hidden;
    }

    .progress-bar {
      width: 0%;
      height: 100%;
      background: #38bdf8;
      border-radius: 999px;
    }

    .cards {
      position: relative;
      height: 460px;
    }

    .card {
      position: absolute;
      inset: 0;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 2rem;
      border-radius: 28px;
      background: linear-gradient(135deg, #1e293b, #020617);
      border: 1px solid rgba(255, 255, 255, 0.12);
      box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
      transform: translateY(80px);
      opacity: 0;
    }

    .card-number {
      font-size: 5rem;
      font-weight: bold;
      color: rgba(56, 189, 248, 0.25);
      line-height: 1;
      margin-bottom: auto;
    }

    .card h3 {
      font-size: 2rem;
      margin: 0 0 0.75rem;
    }

    .card p {
      color: #cbd5e1;
      margin: 0;
    }

    @media (max-width: 850px) {
      .scroll-inner {
        grid-template-columns: 1fr;
      }

      .cards {
        height: 380px;
      }
    }

    @media (prefers-reduced-motion: reduce) {
      .card {
        position: relative;
        opacity: 1;
        transform: none;
        margin-bottom: 1rem;
      }

      .cards {
        height: auto;
      }
    }
  </style>
</head>

<body>
  <section class="hero">
    <div>
      <h1>Scroll-Based Landing Page</h1>
      <p>
        Scroll down to see a pinned landing-page section controlled by GSAP ScrollTrigger.
      </p>
    </div>
  </section>

  <section class="scroll-section">
    <div class="scroll-inner">
      <div class="scroll-copy">
        <div class="section-label">ScrollTrigger Demo</div>
        <h2>Build a better product story.</h2>
        <p>
          As the visitor scrolls, each step appears in sequence. This is useful for explaining
          your product, process, or offer without overwhelming the page.
        </p>

        <div class="progress-wrap">
          <div class="progress-bar"></div>
        </div>
      </div>

      <div class="cards">
        <article class="card">
          <div class="card-number">01</div>
          <h3>Plan the Message</h3>
          <p>
            Start with the key idea you want visitors to understand before they take action.
          </p>
        </article>

        <article class="card">
          <div class="card-number">02</div>
          <h3>Animate the Journey</h3>
          <p>
            Use scroll to reveal information gradually and guide the viewer through the section.
          </p>
        </article>

        <article class="card">
          <div class="card-number">03</div>
          <h3>Drive the Action</h3>
          <p>
            End with a clear CTA, a product benefit, or the next section of your landing page.
          </p>
        </article>
      </div>
    </div>
  </section>

  <section class="after-section">
    <div>
      <h2>Next Section</h2>
      <p>
        The pinned scroll animation is complete. Now the page continues normally.
      </p>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3/dist/ScrollTrigger.min.js"></script>

  <script>
    gsap.registerPlugin(ScrollTrigger);

    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    if (!prefersReducedMotion) {
      const cards = gsap.utils.toArray(".card");

      gsap.set(cards[0], {
        opacity: 1,
        y: 0,
        scale: 1
      });

      gsap.set(cards.slice(1), {
        opacity: 0,
        y: 80,
        scale: 0.95
      });

      const timeline = gsap.timeline({
        scrollTrigger: {
          trigger: ".scroll-section",
          start: "top top",
          end: "+=2500",
          scrub: 1,
          pin: true,
          // markers: true
        }
      });

      timeline.to(".scroll-copy", {
        y: -20,
        opacity: 1,
        duration: 0.5
      });

      timeline.to(".progress-bar", {
        width: "33%",
        duration: 1
      }, 0);

      timeline.to(cards[0], {
        scale: 0.94,
        opacity: 0.35,
        y: -40,
        duration: 1
      });

      timeline.to(cards[1], {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 1
      }, "<");

      timeline.to(".progress-bar", {
        width: "66%",
        duration: 1
      }, "<");

      timeline.to(cards[1], {
        scale: 0.94,
        opacity: 0.35,
        y: -40,
        duration: 1
      });

      timeline.to(cards[2], {
        opacity: 1,
        y: 0,
        scale: 1,
        duration: 1
      }, "<");

      timeline.to(".progress-bar", {
        width: "100%",
        duration: 1
      }, "<");

      timeline.to(".scroll-copy h2", {
        color: "#38bdf8",
        duration: 0.5
      });
    }
  </script>
</body>
</html>
```

---

## The key ScrollTrigger code

```javascript
const timeline = gsap.timeline({
  scrollTrigger: {
    trigger: ".scroll-section",
    start: "top top",
    end: "+=2500",
    scrub: 1,
    pin: true,
    // markers: true
  }
});
```

| Option | What it does |
| --- | --- |
| `trigger` | Which section controls the animation |
| `start: "top top"` | Starts when the top of `.scroll-section` hits the top of the viewport |
| `end: "+=2500"` | Animation lasts for 2500px of scroll |
| `scrub: 1` | Links animation to scroll with slight smoothing |
| `pin: true` | Section stays fixed while the animation plays |
| `markers: true` | Debug lines for start/end (turn off in production) |

**Without scrub:** scrolling only *starts* the animation.

**With scrub:** scrolling *controls* the animation progress.

---

## Why use a timeline

Instead of separate tweens, one timeline choreographs the section:

```javascript
timeline.to(cards[0], {
  scale: 0.94,
  opacity: 0.35,
  y: -40,
  duration: 1
});

timeline.to(cards[1], {
  opacity: 1,
  y: 0,
  scale: 1,
  duration: 1
}, "<");
```

The `"<"` position means: start at the **same time** as the previous tween. Card 1 fades back while card 2 enters.

---

## ScrollTrigger mental model

```txt
User scrolls down
        ↓
ScrollTrigger measures scroll progress
        ↓
GSAP timeline advances
        ↓
Cards animate in sequence
```

---

## Common ScrollTrigger options

### Basic trigger

```javascript
gsap.to(".box", {
  x: 300,
  scrollTrigger: ".box"
});
```

Starts when `.box` enters the viewport.

### More control

```javascript
gsap.to(".box", {
  x: 300,
  scrollTrigger: {
    trigger: ".box",
    start: "top 80%",
    end: "top 30%",
    scrub: true
  }
});
```

Start when the top of `.box` reaches 80% down the viewport; end at 30%; tie progress to scroll.

### Pinning a section

```javascript
gsap.to(".box", {
  scale: 1.2,
  scrollTrigger: {
    trigger: ".box",
    start: "top top",
    end: "+=1000",
    scrub: true,
    pin: true
  }
});
```

Keeps the section in place while the user scrolls through the animation.

---

## Debugging: use markers

While building, enable markers:

```javascript
scrollTrigger: {
  trigger: ".scroll-section",
  start: "top top",
  end: "+=2500",
  scrub: 1,
  pin: true,
  markers: true
}
```

You will see `start`, `end`, `scroller-start`, and `scroller-end` in the browser. Turn `markers` off before shipping.

---

## Beginner mistakes to avoid

### 1. Forgetting to register ScrollTrigger

```javascript
gsap.registerPlugin(ScrollTrigger);
```

Without this, ScrollTrigger may not run.

### 2. Not enough scroll space

If the page is too short, the pinned animation has no room to play. That is why this demo uses `end: "+=2500"`.

### 3. Too many effects at once

Start with one reveal:

```javascript
gsap.to(".card", {
  y: 0,
  opacity: 1,
  scrollTrigger: ".card"
});
```

Then add scrub, pin, timeline, progress bar, and multiple cards step by step.

---

## Adapt for a real landing page

| Use case | Steps |
| --- | --- |
| SaaS features | Connect tools → Automate workflow → Track results |
| Real estate video service | Upload photos → Generate AI video → Publish promo |
| Agency services | Audit → Strategy → Execution → Reporting |
| Course landing | Module 1 → Module 2 → Module 3 |

---

## Starter pattern

```javascript
gsap.registerPlugin(ScrollTrigger);

const timeline = gsap.timeline({
  scrollTrigger: {
    trigger: ".section",
    start: "top top",
    end: "+=2000",
    scrub: 1,
    pin: true
  }
});

timeline.to(".thing", {
  opacity: 1,
  y: 0
});
```

That pattern alone can power many modern landing-page scroll effects.

---

## Related articles

- [[Beginner GSAP Tutorial - Build a Mini Animation Demo App]]
- [[GSAP Primer - What It Can Do for Your Website]]
- [[Scroll To with GSAP]]
