
What is. How to remove.

---

Yes, in Tailwind CSS, "Preflight" is the term used for their CSS normalizer. Preflight is an **opinionated set of base styles** that Tailwind includes to normalize differences between browsers and provide a consistent baseline. It builds on top of modern-normalize and adds additional resets and default styles to elements to smooth out cross-browser inconsistencies and make it easier to work within the constraints of your design system​[](https://tailwindcss.com/docs/preflight)​.

Preflight's actions include:

- Removing default margins from elements like headings, paragraphs, and others​[](https://tailwindcss.com/docs/preflight)​.
- Making all heading elements unstyled by default, inheriting font size and weight​[](https://tailwindcss.com/docs/preflight)​.
- Unstyling ordered and unordered lists, removing bullets/numbers, and margins and padding​[](https://tailwindcss.com/docs/preflight)​.

These actions help create a more consistent starting point for styling your web project with Tailwind CSS.