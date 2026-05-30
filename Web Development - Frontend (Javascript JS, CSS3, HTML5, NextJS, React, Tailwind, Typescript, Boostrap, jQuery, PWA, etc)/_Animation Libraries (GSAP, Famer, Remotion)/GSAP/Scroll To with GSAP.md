# Scroll To with GSAP

If you need more control over scroll animation—speed, duration, easing curve, delay, callbacks, or the ability to stop, reverse, or otherwise control the motion—**GSAP** is a better choice than basic CSS smooth scrolling or a hand-rolled `requestAnimationFrame()` loop.

A custom `requestAnimationFrame()` scroll can work, but you must manually calculate timing, easing, progress, and edge cases. GSAP handles that for you and exposes a cleaner API.

---

## What you can control with GSAP

- Exact scroll duration
- Custom easing (`power2.out`, `expo.inOut`, `back.out`, and others)
- Delays
- Scroll interruption behavior
- Callbacks: `onStart`, `onUpdate`, `onComplete`
- Advanced sequencing with timelines

---

## Basic example: ScrollToPlugin

Register the plugin, then animate scroll on `window` (or a scroll container):

```javascript
gsap.registerPlugin(ScrollToPlugin);

gsap.to(window, {
  duration: 0.5,
  scrollTo: "#my-element",
  ease: "power2.out"
});
```

This scrolls smoothly to `#my-element` over half a second with a custom easing curve.

> [!note] ScrollToPlugin
> `ScrollToPlugin` is a GSAP plugin (not the core tween engine alone). Import or load it alongside GSAP and call `gsap.registerPlugin(ScrollToPlugin)` before your first scroll tween.

---

## Offset, easing, and callbacks

You can tune how the scroll feels and run logic when it finishes:

```javascript
gsap.to(window, {
  duration: 1.2,
  scrollTo: {
    y: "#my-element",
    offsetY: 80
  },
  ease: "expo.inOut",
  onComplete: function () {
    console.log("Finished scrolling");
  }
});
```

`offsetY` is useful when a fixed header covers the target—you land slightly above the element instead of flush against the top.

This gives you more control than native smooth scrolling: you define how long the scroll takes, how it accelerates and decelerates, and what runs before, during, or after the animation.

---

## When native scrolling is enough

For very simple smooth scrolling, native CSS (`scroll-behavior: smooth`) or a minimal JavaScript helper may be enough.

Reach for GSAP when the scroll needs to:

- Feel polished and on-brand
- Coordinate with other animations on the page
- Behave consistently across a more complex interface
- Support interruption, reversal, or timeline sequencing

For scroll-driven storytelling and pinned sections, you may also combine this with **ScrollTrigger**—a separate GSAP plugin for tying animation to scroll position.
