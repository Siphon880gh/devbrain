# Beginner GSAP Tutorial: Build a Mini Animation Demo App

In this beginner GSAP tutorial, you will build a small demo website that shows animations GSAP is commonly used for: hero text reveals, button hover effects, staggered cards, animated counters, and scroll-triggered sections. Instead of disconnected snippets, everything lives in one landing-page-style app so you can see how the effects work together.

> [!note] Prerequisites
> Basic HTML/CSS/JavaScript. For conceptual background, read [[GSAP Primer - What It Can Do for Your Website]] first.

---

## What you will build

A vanilla JavaScript + Vite demo app with:

- Hero intro animation
- Staggered cards
- Button hover animation
- Timeline sequence
- Scroll-triggered reveal
- Simple counter animation

GSAP can be installed with npm or loaded via a script tag. This tutorial uses **npm** for a realistic project setup.

---

## 1. Create the app

```bash
npm create vite@latest gsap-demo -- --template vanilla
cd gsap-demo
npm install
npm install gsap
npm run dev
```

Open the local URL Vite prints (usually `http://localhost:5173`).

---

## 2. Project structure

You will mostly edit:

```txt
gsap-demo/
  index.html
  src/
    main.js
    style.css
```

---

## 3. Replace `index.html`

```html
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GSAP Beginner Demo</title>
  </head>
  <body>
    <main>
      <section class="hero">
        <p class="eyebrow">GSAP Demo App</p>
        <h1 class="hero-title">Animate your website with control.</h1>
        <p class="hero-text">
          This beginner demo shows common GSAP effects used in modern landing pages.
        </p>
        <button class="hero-button">Start Exploring</button>
      </section>

      <section class="stats-section">
        <div class="stat">
          <span class="counter" data-target="120">0</span>
          <p>Animations triggered</p>
        </div>
        <div class="stat">
          <span class="counter" data-target="45">0</span>
          <p>UI elements enhanced</p>
        </div>
        <div class="stat">
          <span class="counter" data-target="98">0</span>
          <p>Smoother interactions</p>
        </div>
      </section>

      <section class="cards-section">
        <h2>Common GSAP Effects</h2>

        <div class="cards">
          <article class="card">
            <h3>Fade In</h3>
            <p>Reveal content smoothly instead of showing everything at once.</p>
          </article>

          <article class="card">
            <h3>Slide Up</h3>
            <p>Move text, images, or cards into place with motion.</p>
          </article>

          <article class="card">
            <h3>Stagger</h3>
            <p>Animate similar items one after another for a polished feel.</p>
          </article>

          <article class="card">
            <h3>ScrollTrigger</h3>
            <p>Start animations when elements enter the viewport.</p>
          </article>
        </div>
      </section>

      <section class="scroll-section">
        <div class="scroll-box">
          <h2>Scroll-based animation</h2>
          <p>
            This box animates when you scroll to it. This is one of GSAP’s most common website uses.
          </p>
        </div>
      </section>
    </main>

    <script type="module" src="/src/main.js"></script>
  </body>
</html>
```

---

## 4. Replace `src/style.css`

```css
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
  background: #101014;
  color: white;
}

main {
  overflow-x: hidden;
}

.hero {
  min-height: 100vh;
  display: grid;
  place-content: center;
  padding: 48px 24px;
  text-align: center;
  background:
    radial-gradient(circle at top, rgba(111, 76, 255, 0.35), transparent 35%),
    #101014;
}

.eyebrow {
  color: #a899ff;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

.hero-title {
  max-width: 780px;
  font-size: clamp(3rem, 8vw, 7rem);
  line-height: 0.95;
  margin: 0 auto 24px;
}

.hero-text {
  max-width: 600px;
  margin: 0 auto 32px;
  color: #c9c9d4;
  font-size: 1.2rem;
}

.hero-button {
  justify-self: center;
  border: 0;
  padding: 16px 24px;
  border-radius: 999px;
  background: #7c5cff;
  color: white;
  font-weight: 700;
  cursor: pointer;
}

.stats-section {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  padding: 80px 24px;
  max-width: 1000px;
  margin: 0 auto;
}

.stat {
  background: #181820;
  border: 1px solid #2d2d3a;
  border-radius: 24px;
  padding: 32px;
  text-align: center;
}

.counter {
  display: block;
  font-size: 3rem;
  font-weight: 800;
  color: #a899ff;
}

.cards-section {
  padding: 100px 24px;
  max-width: 1100px;
  margin: 0 auto;
}

.cards-section h2 {
  font-size: clamp(2rem, 5vw, 4rem);
  margin-bottom: 32px;
}

.cards {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.card {
  min-height: 220px;
  padding: 24px;
  border-radius: 24px;
  background: #181820;
  border: 1px solid #2d2d3a;
}

.card h3 {
  margin-top: 0;
  color: #a899ff;
}

.card p {
  color: #c9c9d4;
}

.scroll-section {
  min-height: 100vh;
  display: grid;
  place-items: center;
  padding: 80px 24px;
}

.scroll-box {
  max-width: 700px;
  padding: 48px;
  border-radius: 32px;
  background: linear-gradient(135deg, #7c5cff, #32d3ff);
  color: white;
}

.scroll-box h2 {
  font-size: clamp(2rem, 5vw, 4rem);
  margin-top: 0;
}

@media (max-width: 800px) {
  .stats-section,
  .cards {
    grid-template-columns: 1fr;
  }
}
```

---

## 5. Replace `src/main.js`

```javascript
import "./style.css";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

/**
 * 1. Hero intro animation
 * A timeline lets you sequence multiple animations.
 */
const heroTimeline = gsap.timeline({
  defaults: {
    duration: 0.9,
    ease: "power3.out",
  },
});

heroTimeline
  .from(".eyebrow", {
    y: 20,
    opacity: 0,
  })
  .from(
    ".hero-title",
    {
      y: 40,
      opacity: 0,
    },
    "-=0.5"
  )
  .from(
    ".hero-text",
    {
      y: 30,
      opacity: 0,
    },
    "-=0.5"
  )
  .from(
    ".hero-button",
    {
      scale: 0.85,
      opacity: 0,
    },
    "-=0.4"
  );

/**
 * 2. Button hover animation
 */
const button = document.querySelector(".hero-button");

button.addEventListener("mouseenter", () => {
  gsap.to(button, {
    scale: 1.08,
    duration: 0.25,
    ease: "power2.out",
  });
});

button.addEventListener("mouseleave", () => {
  gsap.to(button, {
    scale: 1,
    duration: 0.25,
    ease: "power2.out",
  });
});

/**
 * 3. Staggered stats cards
 */
gsap.from(".stat", {
  scrollTrigger: {
    trigger: ".stats-section",
    start: "top 75%",
  },
  y: 40,
  opacity: 0,
  duration: 0.8,
  stagger: 0.15,
  ease: "power3.out",
});

/**
 * 4. Counter animation
 */
document.querySelectorAll(".counter").forEach((counter) => {
  const target = Number(counter.dataset.target);

  gsap.to(counter, {
    scrollTrigger: {
      trigger: counter,
      start: "top 80%",
    },
    innerText: target,
    duration: 1.5,
    snap: {
      innerText: 1,
    },
    ease: "power1.out",
  });
});

/**
 * 5. Staggered cards
 */
gsap.from(".card", {
  scrollTrigger: {
    trigger: ".cards-section",
    start: "top 70%",
  },
  y: 60,
  opacity: 0,
  duration: 0.8,
  stagger: 0.18,
  ease: "power3.out",
});

/**
 * 6. Scroll-triggered feature box
 */
gsap.from(".scroll-box", {
  scrollTrigger: {
    trigger: ".scroll-box",
    start: "top 75%",
  },
  scale: 0.85,
  rotate: -3,
  opacity: 0,
  duration: 1,
  ease: "back.out(1.7)",
});
```

ScrollTrigger triggers, scrubs, pins, and controls animations based on scroll. See [[ScrollTrigger Tutorial - Build a Scroll-Based Landing Page Section]] for pinning and scrubbing in depth.

---

## What each pattern teaches

### `gsap.from()`

```javascript
gsap.from(".hero-title", {
  y: 40,
  opacity: 0,
  duration: 1,
});
```

Start lower and invisible, animate to the element’s normal state.

**Good for:** fade-ins, slide-ups, hero text, cards, images, sections.

### `gsap.to()`

```javascript
gsap.to(button, {
  scale: 1.08,
  duration: 0.25,
});
```

Animate from the current state to new values.

**Good for:** hovers, loaders, progress bars, counters, interactive UI.

### `gsap.timeline()`

```javascript
const tl = gsap.timeline();

tl.from(".eyebrow", { opacity: 0 })
  .from(".hero-title", { opacity: 0 })
  .from(".hero-text", { opacity: 0 });
```

Organize several animations in order.

**Good for:** landing intros, product reveals, step-by-step sections.

### `stagger`

```javascript
gsap.from(".card", {
  opacity: 0,
  y: 40,
  stagger: 0.2,
});
```

Animate each matching element slightly after the previous one.

**Good for:** cards, menus, galleries, testimonials, pricing rows.

### ScrollTrigger

```javascript
gsap.from(".card", {
  scrollTrigger: {
    trigger: ".cards-section",
    start: "top 70%",
  },
  opacity: 0,
  y: 60,
});
```

Start when `.cards-section` reaches 70% down the viewport.

**Good for:** scroll reveals, parallax, pinned storytelling. Next: [[ScrollTrigger Tutorial - Build a Scroll-Based Landing Page Section]].

---

## Related articles

- [[GSAP Primer - What It Can Do for Your Website]]
- [[Scroll To with GSAP]]
