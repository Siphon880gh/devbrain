**Addy Osmani’s `accessibility` skill**: It has much stronger developer adoption than the alternatives—about 2.7k GitHub stars and 249 forks—and covers WCAG 2.2, ARIA, semantic HTML, color contrast, keyboard navigation, focus management, forms, screen readers, and Lighthouse/axe testing. It is unofficial, but measurement-focused rather than merely a checklist. [View the skill](https://github.com/addyosmani/web-quality-skills/tree/main/skills/accessibility)

There is no convincing Reddit consensus around one accessibility skill; most Reddit results were creators promoting their own. This one has the strongest broader developer adoption.

Install it from your project directory:

```bash
npx skills@latest add addyosmani/web-quality-skills \
  --skill accessibility \
  --agent cursor
```

For every Cursor project, add `--global`:

```bash
npx skills@latest add addyosmani/web-quality-skills \
  --skill accessibility \
  --agent cursor \
  --global
```

Cursor should then show it under **Customize → Skills**, and you can invoke it with `/accessibility`. Cursor officially supports skills in `.cursor/skills/` and automatically discovers them. [Cursor Agent Skills documentation](https://cursor.com/docs/skills)

Use this audit prompt:

```text
/accessibility

Audit this application against WCAG 2.2 Level AA.

Run the application and test representative user flows on mobile and
desktop. Use Lighthouse and axe when available, inspect the rendered
accessibility tree, and manually test keyboard navigation and focus.

Check:
- semantic HTML and heading/landmark structure
- accessible names, ARIA roles, states, and relationships
- incorrect, redundant, or missing ARIA
- keyboard access, focus order, focus visibility, and focus traps
- text and non-text color contrast in every theme and interaction state
- forms, labels, validation, errors, and live announcements
- images, icons, SVGs, tables, dialogs, menus, and dynamic content
- zoom/reflow, reduced motion, target sizing, and responsive layouts

Prefer native HTML over custom ARIA implementations.

For every finding, report:
1. Severity
2. WCAG success criterion
3. Evidence and affected user group
4. Page, component, file, or selector
5. Recommended correction
6. Whether it was detected automatically or requires manual verification

Do not claim that automated results prove ADA compliance. After making
approved fixes, rerun the same tests and report remaining issues.
```

One important distinction: no AI skill or automated scanner can certify ADA compliance; W3C explicitly says knowledgeable human evaluation is still required. For US state and local government sites, the DOJ’s formal Title II technical standard is WCAG 2.1 AA. [W3C evaluation guidance](https://www.w3.org/WAI/test-evaluate/), [DOJ ADA web rule](https://www.ada.gov/resources/2024-03-08-web-rule/)

For more specialized audit modules later, Mike Gifford’s [Accessibility Skills collection](https://github.com/mgifford/accessibility-skills) has separate skills for axe rules, contrast, keyboard testing, forms, and manual assistive-technology testing.