## GSAP Primer: What It Can Do for Your Website

**GSAP** (GreenSock Animation Platform) is a JavaScript animation library for smooth, controlled, professional web animations.

In plain terms: GSAP lets you animate almost anything JavaScript can touch—HTML elements, CSS properties, SVGs, canvas objects, numbers, and scroll-based effects.

> [!note] GSAP vs CSS
> CSS is great for small UI transitions. GSAP is stronger when timing, sequencing, scroll behavior, or complex motion matters. See [[Remotion vs Framer Motion, CSS, and GSAP - When to Use Each]] for how GSAP compares to Remotion and other tools.

---

## What GSAP can do for a website

GSAP is useful when you want animations that feel more polished than basic CSS transitions.

```javascript
gsap.to(".box", {
  x: 300,
  opacity: 1,
  duration: 1,
  ease: "power2.out"
});
```

That example moves an element horizontally, fades it in, and controls timing and easing.

### Common capabilities

| Feature | What it means |
| --- | --- |
| Element animation | Move, fade, scale, rotate, skew, resize |
| Timeline animation | Chain multiple animations in sequence |
| Scroll animation | Trigger animations when users scroll |
| Scroll pinning | Keep a section fixed while the page scrolls |
| Scroll scrubbing | Tie animation progress directly to scroll position |
| SVG animation | Icons, logos, paths, shapes, morphs |
| Text animation | Reveal words, lines, or characters |
| Drag interactions | Draggable, swipeable, interactive elements |
| Page transitions | Animate content between routes or pages |
| Microinteractions | Buttons, cards, menus, hovers, modals, loaders |

The main reason developers choose GSAP is **control**. CSS handles simple transitions well; GSAP handles choreography, scroll, and complex motion.

---

## Is GSAP free?

Yes. GSAP is **100% free**, including tools that were formerly paid Club GSAP plugins (for example SplitText and MorphSVG in GSAP 3.13+). The full toolset is available through the main npm package. GSAP Pro tools like Scramble Text, Split Text, and Draggable became free after Webflow acquired GSAP in 2025. You do not need to be a Webflow customer.

> [!note] License caveat
> Free does not mean unrestricted open-source use. GSAP has a [standard license](https://gsap.com/community/standard-license/) with restrictions—especially around prohibited uses and competing products. For normal websites, client sites, landing pages, SaaS, marketing sites, and portfolios, commercial use is generally covered. If you are building a visual animation builder, no-code site builder, or product that competes with Webflow/GSAP tooling, read the license carefully.

---

## What stacks is GSAP compatible with?

GSAP is **framework agnostic**—it is JavaScript that runs in the browser regardless of how the page was built.

| Stack | Compatible |
| --- | --- |
| Vanilla HTML/CSS/JS | Yes |
| React / Next.js | Yes |
| Vue / Nuxt | Yes |
| Angular | Yes |
| Svelte / SvelteKit | Yes |
| Astro | Yes |
| WordPress | Yes |
| Webflow | Yes |
| Shopify themes | Yes (custom JS) |
| PHP / Laravel / Blade | Yes |
| Static sites | Yes |

React projects can use the `useGSAP()` hook; the same core ideas (`gsap.to`, timelines, ScrollTrigger) apply everywhere.

---

## Common website uses

### 1. Hero section animations

```javascript
gsap.from(".hero-title", {
  y: 40,
  opacity: 0,
  duration: 1
});
```

Good for landing pages, portfolios, SaaS homepages, agency sites, and product launches.

### 2. Scroll-triggered animations

ScrollTrigger starts animations when elements enter the viewport. It can scrub, pin, snap, and control scroll-linked motion.

```javascript
gsap.to(".feature-card", {
  scrollTrigger: ".feature-card",
  y: 0,
  opacity: 1,
  duration: 0.8
});
```

See [[ScrollTrigger Tutorial - Build a Scroll-Based Landing Page Section]] and [[Beginner GSAP Tutorial - Build a Mini Animation Demo App]].

### 3. Sticky storytelling sections

Pin a section while the user scrolls through animation steps.

| Website type | Example |
| --- | --- |
| SaaS | Product features step by step |
| Real estate | Property highlights |
| Agency | Process stages |
| Course site | Learning path |
| Startup pitch | Visual story on one screen |

### 4. Text reveals

**SplitText** splits text into characters, words, or lines for staggered reveals—headlines, intros, quotes, luxury-style sites.

### 5. SVG logo and icon animations

Animate paths, stroke drawing, morphing, and motion paths—logo draw-on-load, feature icons, map routes, product diagrams.

### 6. Interactive UI animation

| UI element | Animation idea |
| --- | --- |
| Buttons | Hover, press, glow, scale |
| Cards | Flip, expand, drag, reorder |
| Menus | Slide, fade, stagger nav items |
| Modals | Open/close with controlled easing |
| Forms | Error shake, success checkmark |
| Loaders | Progress bars, spinners, skeletons |

### 7. Carousels and draggable elements

Custom sliders, swipe galleries, and product showcases when generic slider libraries feel too rigid.

---

## When to use GSAP instead of CSS

**Use CSS** when the animation is simple:

```css
.button {
  transition: transform 0.2s ease;
}

.button:hover {
  transform: scale(1.05);
}
```

**Use GSAP** when you need:

| Need | Why GSAP helps |
| --- | --- |
| Multiple steps | Timelines sequence animations |
| Scroll control | ScrollTrigger is built for this |
| Advanced easing | More natural movement |
| SVG animation | More control than CSS alone |
| Text splitting | Animate words/letters/lines |
| Reusable animation logic | Centralized JS control |
| Complex page interactions | Better state-based control |

**Rule of thumb:** CSS for small UI transitions; GSAP for choreographed motion, scroll effects, SVG animation, and high-control experiences.

---

## Where GSAP fits in a modern website

GSAP is an **enhancement layer** on top of your normal stack:

```txt
HTML / React / Vue / WordPress / Webflow
        +
CSS / Tailwind / SCSS
        +
GSAP for animation behavior
```

GSAP does not replace your framework. It sits on top of the UI and adds animation control.

---

## Beginner mental model

GSAP usually follows this pattern:

```javascript
gsap.to(target, settings)
```

Meaning: animate **this thing** **to these values**.

```javascript
gsap.to(".card", {
  y: -20,
  opacity: 1,
  duration: 0.6,
  ease: "power2.out"
});
```

Animate **from** a starting state:

```javascript
gsap.from(".card", {
  y: 40,
  opacity: 0,
  duration: 0.6
});
```

Build **timelines** for sequences:

```javascript
const tl = gsap.timeline();

tl.from(".logo", { opacity: 0, y: -20, duration: 0.5 })
  .from(".headline", { opacity: 0, y: 30, duration: 0.7 })
  .from(".cta", { opacity: 0, scale: 0.9, duration: 0.4 });
```

You are not only adding motion—you are **directing a sequence**.

---

## Related articles

- [[Beginner GSAP Tutorial - Build a Mini Animation Demo App]] — hands-on Vite demo
- [[ScrollTrigger Tutorial - Build a Scroll-Based Landing Page Section]] — pinned scroll storytelling
- [[Scroll To with GSAP]] — controlled smooth scroll to anchors

---

## Takeaway

GSAP is a JavaScript animation library for polished website motion: fades, scroll effects, SVG animation, text reveals, drag interactions, page transitions, and complex timelines. It works with vanilla JS, React, Vue, Angular, Webflow, WordPress, and most modern stacks. It is free for typical commercial sites; review the license if you ship competing animation tooling.
