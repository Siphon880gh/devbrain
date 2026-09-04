Prompt:
```
Run the Impeccable Critique skill on the website and save the complete report as `Design-Critique-by-Impeccable.md`.

Structure the report around these two main sections:

## 1. Individual Page Appearance Critique

Review every significant page individually. For each page, assess:

* Visual hierarchy
* Layout, spacing, and alignment
* Typography and readability
* Color, contrast, and consistency
* Imagery, icons, and visual polish
* Content presentation and calls to action
* Navigation and information architecture
* Accessibility
* Credibility and user trust
* Loading, empty, error, and success states

### Responsive Testing

Test every significant page at mobile, tablet, and desktop sizes, including approximately:

* Mobile: 390 × 844
* Tablet: 768 × 1024
* Desktop: 1440 × 900

Also resize gradually between these widths to uncover breakpoint-specific problems.

Evaluate:

* Layout reflow and use of available space
* Text wrapping, clipping, and readability
* Horizontal overflow
* Navigation and mobile-menu behavior
* Image and media scaling
* Buttons, forms, modals, dropdowns, and overlays
* Touch-target size and spacing
* Fixed, sticky, and floating elements
* Content that disappears or becomes inaccessible
* Awkward breakpoint transitions
* Portrait and landscape behavior where relevant

### AI-Slop and Template-Likeness Detection

Assess whether each page feels intentionally designed or appears generic, synthetic, repetitive, or template-generated.

Look for:

* Generic AI-style marketing language and vague claims
* Overused phrases such as “unlock,” “revolutionize,” “elevate,” “seamless,” or “transform”
* Headlines that sound impressive but communicate little
* Repetitive sentence structures, three-item lists, or excessive em dashes
* Excessive gradients, glowing effects, floating blobs, glassmorphism, pills, and rounded cards
* Predictable hero, logo-strip, feature-grid, testimonial, and CTA layouts
* Excessive use of cards when simpler layouts would communicate better
* Generic icons, stock imagery, or generated imagery that lacks relevance
* Inconsistent illustration, photography, icon, or visual styles
* Artificial-looking testimonials, statistics, logos, or social proof
* Redundant sections that repeat the same message
* Unnecessary animations or decorative effects
* Content that could belong to almost any company or product
* Lack of brand personality, specificity, or human editorial judgment

Do not claim that something was AI-generated without evidence. Evaluate whether it creates the perception of “AI slop,” explain the specific signals, and recommend how to make it feel more deliberate, credible, distinctive, and human.

Identify what works well and what should be improved. Reference the exact page, viewport, component, or interface element whenever possible.

## 2. End-to-End User Experience Critique

Identify the website’s major user types and the primary goals each type is trying to accomplish.

For each major goal:

1. Write a user story in this format:
   “As a [type of user], I want to [goal], so that [benefit].”
2. Trace the complete journey from the user’s likely entry point through successful completion.
3. Test the entire journey on mobile, tablet, and desktop.
4. Evaluate how well the pages, navigation, content, interactions, and system feedback work together.
5. Identify friction, confusion, unnecessary steps, weak calls to action, dead ends, missing states, trust concerns, and accessibility barriers.
6. Note where the experience may cause users to hesitate, abandon the journey, or misunderstand what to do next.
7. Identify device-specific problems that make a goal harder to complete.
8. Recommend specific improvements that make the journey clearer, faster, and more satisfying across all screen sizes.

### AI-Slop Within the User Journey

Evaluate whether any part of the journey feels generic, automated, artificial, or insufficiently considered, including:

* Robotic instructions or feedback messages
* Generic onboarding that does not adapt to the user’s goal
* Repetitive or unnecessary confirmation screens
* Meaningless personalization
* Excessive pop-ups, upsells, or calls to action
* Vague form labels or placeholder-driven interfaces
* Generic empty, loading, success, and error messages
* Features that appear impressive but do not help users complete their goals
* Interactions that add visual novelty without functional value
* Inconsistent tone or terminology between steps
* Missing contextual guidance at important decision points

Explain how these issues affect user confidence, trust, comprehension, task completion, and perceived product quality.

For every issue in both sections, include:

* Location
* Tested viewport or device category
* Description of the issue
* Affected users or user story
* Severity: critical, high, medium, or low
* AI-slop or template-likeness signal, when applicable
* Why it matters
* Specific recommended fix

Conclude each section with prioritized recommendations, separating quick wins from larger design improvements. Prioritize findings according to user impact and implementation effort.

Do not modify the website during the critique unless explicitly instructed.
```