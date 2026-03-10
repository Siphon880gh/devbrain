QA item: Mobile responsive — check the design in both a narrowed desktop window and on a real phone. Many times, the layout looks right in a smaller browser window but not on an actual mobile device.

---

Desktop browsers usually still behave like desktop browsers. Even when you shrink the window, the browser may keep desktop rendering behavior, desktop scrollbars, hover support, desktop fonts, and desktop input assumptions.

Phones have a different viewport model. Mobile browsers use device width, pixel ratio, safe areas, browser chrome, zoom behavior, and dynamic address bars, which can change how widths, heights, and spacing actually render.

Touch changes the UI. On desktop, users hover and click with a precise pointer. On phones, there is no hover in the same way, tap targets need more space, and some menus, tooltips, and interactions behave differently.

Mobile browsers apply special rules. Inputs, fixed elements, 100vh heights, keyboard opening, autofill, and sticky headers often behave differently on iPhone and Android than in a desktop browser.

Text and images can scale differently. Font rendering, line wrapping, image sizing, and even default form styles can look different on real devices.

Performance matters more on phones. Animations, lazy loading, large images, and scripts may feel fine on desktop but break layout timing or usability on mobile.

So a resized-down desktop window is useful for a quick check, but it is only an approximation. Real phone testing catches the actual mobile browser behavior.

Make sure to test on both a resized-down desktop window and a phone. Sometimes the user may actually use a resized-down desktop window (for example, split screen).