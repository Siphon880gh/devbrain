![[Pasted image 20261022024603.png]]

![[Pasted image 20261022024622.png]]

Prompt:
```
Add a fixed chapter nav on the right side of the page, built automatically from the page's existing slides or section headings.

Requirements:
- Find each slide/section (e.g. <section> elements or elements with a data-chapter attribute) and use its heading or data-label as the label. Prefix each with a small number like "01".
- Show a vertical list of dots with labels on the right edge, vertically centered. The active item gets a filled dot and a highlighted label.
- Scroll-spy: as the visitor scrolls, the active item moves to the slide they're on. If the page uses GSAP ScrollTrigger with pinned/scrubbed slides, drive the active state from the same ScrollTrigger progress (onUpdate / onToggle) so it stays in sync with the animation, not just IntersectionObserver.
- Jump links: clicking an item scrolls to that slide. With GSAP, use ScrollToPlugin (or compute the trigger's start position) and ease the scroll with the same easing the slide animations use, e.g. cubic-bezier(0.22, 1, 0.36, 1) / power3.out, so the jump plays the 3D transitions smoothly instead of teleporting.
- The active indicator animates between items (a sliding marker or dot fill transition) with the same easing.
- Accessible: a <nav aria-label="Chapters"> with real links/buttons, aria-current="step" on the active item, visible focus rings, keyboard operable.
- prefers-reduced-motion: no smooth scroll or indicator animation, jump instantly.
- Hide or collapse to dots only on small screens so it doesn't cover content.
- Readable contrast in both light and dark themes.
- Don't change the existing slide animations, pin, or timing.
```