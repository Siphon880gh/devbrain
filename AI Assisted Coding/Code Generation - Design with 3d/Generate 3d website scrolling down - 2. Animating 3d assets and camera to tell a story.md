**Goal:** Tell a story with 3d camera movements and 3d scroll controlled 3d assets. It is not as tamed and corporate presentable as [[Generate 3d website scrolling down - 2. Existing sections that engage user with scroll revealed animations and 3d scroll controlled elements, seamless with easing]]

---

Paste this into an AI coding tool. Replace the bracketed fields. Attach the reference URLs, screenshots, and scroll recordings. Send it. The model should return a running site, not a static lookalike.

If filling in the prompt is too much, precede the prompt with:
```
SUPER INSTRUCTIONS:
Help fill in examples (`eg. `) and placeholders, for example `[URL]`. If any MCP needed but not installed, inform user it's needed and ask if they want to be guided through installing the MCP
```

The prompt:
```text
ROLE
Act as a senior frontend developer, UX designer, and
motion designer for premium interactive marketing sites.

OBJECTIVE
Build a site for a premium home goods brand. It should
introduce the brand, show the products, and lead to
purchase through a scroll-driven product story.

BUSINESS
Industry: eg. premium home goods
Products: eg. handcrafted home accessories
Audience: eg. design-conscious homeowners
Primary action: eg. explore and buy
Secondary: eg. brand recognition
Personality: eg. minimal, calm, precise

Use confirmed facts when available. Label placeholders.
Do not invent testimonials, certifications, statistics,
manufacturing claims, or guarantees.

REFERENCES
Visual / type: [URL]
Layout: [URL]
Scroll motion: [URL or recording]
Nav / hover: [URL]
Screenshots: [files]
Recordings: [files]
Take visual direction, layout, motion, and interaction
quality from these. Do not copy unrelated branding or
copy. If a reference is inaccessible, say so.

DESIGN
Editorial and restrained: generous whitespace, strong
type hierarchy, limited color, composed product
photography, quiet section transitions. No template
chrome and no decoration that does not help the story
or the purchase path.

STRUCTURE
One homepage in five connected chapters.
1. Intro: fullscreen open with identity, headline,
   supporting line, primary CTA, and a coordinated entrance.
2. Story: philosophy and craft, editorial layout,
   scroll-controlled reveals.
3. Featured product: product as the main visual;
   scroll drives product movement with changing copy.
4. Collection: interactive product presentation that
   helps exploration instead of blocking it.
5. Close: clear path to the collection or checkout,
   then a footer.

MOTION
Coordinated scroll-controlled narrative with GSAP and
ScrollTrigger. Each chapter has enter, active, and exit
states. Transitions stay continuous. Reverse scroll
works. Motion holds up across viewport sizes.

INTERACTION
Animated nav, hover states, product presentation,
chapter progress, and animated CTAs. All of it remains
usable with a keyboard and without motion.

STACK
React, Vite, GSAP, ScrollTrigger. Reusable components.
Keep content, layout, and animation logic separate
where that stays practical. Add 3D only if it clearly
improves the product story and real assets exist.

CONSTRAINTS
Responsive on desktop, tablet, and mobile. Simplify
heavy motion on small screens without dropping the
story or the primary action. Semantic HTML, contrast,
accessible names, and reduced-motion support so core
content works with animation off. Optimize media.
Do not thrash layout on scroll.

DELIVERABLES
Working site, reusable components, animation system,
responsive layouts, setup notes.
Also write TODO-Facts-and-Presumed.md covering
confirmed facts, reference-inspired decisions,
assumptions, placeholders, missing assets, and
items that need human review.

DONE WHEN
All five chapters exist. Scroll-controlled motion
works forward and back. Desktop and mobile both
work. Core content is available without complex
motion. Interactive elements function. No unsupported
business claims. The project runs.
A static lookalike of the references is not done.
```

## Worked example: SCULPTING FUTURES

The same structure also works for a more cinematic, 3D-led experience. This version makes the subject, symbolism, chapter purpose, motion, fallback behavior, and completion checks explicit.

```text
ROLE
Act as a senior frontend developer, UX designer, 3D artist,
and motion designer for premium interactive learning sites.

OBJECTIVE
Build an immersive website for SCULPTING FUTURES, a
hands-on sculpting experience that teaches focus and helps
people feel more grounded as they work toward meaningful
success. Turn the site into one continuous 3D sculpture
garden over shallow reflective water, explored by scrolling.

BUSINESS
Offer: hands-on teaching through sculpting and focused practice
Audience: people who want to become more grounded, focused,
and capable of making steady progress
Primary action: [CTA LABEL]
Primary destination: [DESTINATION URL]
Secondary action: download the Grounded Hands Starter Guide
Personality: tactile, contemplative, encouraging, quietly
ambitious
Use confirmed facts when available. Label placeholders. Do
not invent testimonials, credentials, outcomes, statistics,
prices, guarantees, or program details.

REFERENCES
Visual / sculpture proportions: [URL or files]
Pillar proportions and placement: [URL or files]
Camera path / scroll motion: [URL or recording]
Typography / captions: [URL]
Mobile behavior: [URL or recording]
Match the supplied references for proportions, density, and
placement without copying unrelated branding, copy, or
artwork. If a reference is inaccessible, say so and record
the resulting assumption.

EXPERIENCE
Create one continuous world rather than separate scenes. A
flowing route passes through a sculpture garden set in pale
fog over shallow reflective water. Scroll moves a low,
human-height camera forward along the route, reveals new
angles, and pauses gently at each sculpture. Keep the next
sculpture mostly concealed by the garden and pillars until
the camera approaches it. The camera must never clip through
the pillars, islands, water, or sculptures.

CHAPTERS
Create four chapters. Give every sculpture a distinctive,
readable silhouette, a short title, and one useful sentence
that connects its symbolism to the offer.

1. Find Your Center
   Sculpture: a charcoal stone bust with restrained bronze
   inlay tracing from the chest toward the brow.
   Caption: Hands-on sculpting gives your attention somewhere
   real to land, helping you build focus from the material up.

2. Release Progress
   Sculpture: an open stone hand releasing a bronze bird.
   Caption: Focused practice turns small, deliberate movements
   into progress you can carry into work, learning, and life.

3. Shape Together
   Sculpture: an original composition of two interlocking
   stone forearms forming a balanced arch around one continuous
   bronze thread, expressing collaboration and shared mastery.
   Caption: Guided practice and a supportive community help
   you refine your craft without losing your own point of view.

4. Make What Comes Next
   Sculpture: a fragmented standing figure that assembles as
   the camera arrives, leaving an open, doorway-like space at
   its center.
   Caption: Bring the pieces together, choose your next form,
   and begin building a more grounded future with us.

WORLD AND ART DIRECTION
Set each sculpture on a low, irregular stone island with
delicate flowers. Surround the route with thick, closely
grouped, fluted ivory pillars with segmented shafts, broken
sloping tops, and broad stepped bases. Use pale fog, soft
daylight, charcoal stone, restrained bronze details, subtle
ripples, and convincing reflections. Keep the atmosphere
calm and tactile, with enough contrast for the sculptures to
remain legible. Do not turn the world into a generic AI
workshop, fantasy ruin, or unrelated technology metaphor.

MOTION AND COPY
Use GSAP and ScrollTrigger to control the camera path,
sculpture reveals, assembly, captions, and chapter state.
Scrolling forward and backward must produce coherent,
reversible motion. Use gentle pauses at each sculpture, not
hard stops. Blend captions in at chapter boundaries and place
them so they do not cover the artwork. Preserve spatial
continuity and the low viewpoint throughout.

NAVIGATION AND CONVERSION
Add minimal navigation, a progress indicator, and direct
controls for all four chapters. Create a useful downloadable
Grounded Hands Starter Guide with a simple materials list, a
15-minute clay focus exercise, and three reflection prompts.
End with a clear invitation that relates grounded practice to
the SCULPTING FUTURES program or community, followed by a
[CTA LABEL] button linked to [DESTINATION URL]. Do not invent
specific program details to fill missing business information.

STACK AND ASSETS
Build locally with Vite, React, Three.js, GSAP, and
ScrollTrigger.
Use reusable components and keep content, scene setup, camera
movement, and UI logic separate where practical. Check which
Higgsfield MCP tools are available before asset work, then use
the appropriate tools to create a consistent set of original
sculptures. Reuse materials, lighting rules, scale, and asset
conventions so every chapter belongs to the same world. If
Higgsfield is unavailable, document that limitation and use
clearly labeled temporary geometry rather than silently
substituting inconsistent final art.

PERFORMANCE AND ACCESSIBILITY
Optimize models, textures, reflections, render resolution,
and loading. Provide a purposeful loading state. On mobile,
simplify geometry, reflections, effects, and camera movement
without removing the four-chapter story or primary action.
Honor reduced-motion preferences with an accessible static or
lightly animated chapter view. Keep navigation and CTAs usable
with a keyboard and without WebGL-dependent interaction.

DELIVERABLES
Provide the working site, reusable components, optimized
assets, downloadable starter guide, responsive layouts, and
setup notes. Also write TODO-Facts-and-Presumed.md covering
confirmed facts, reference-inspired choices, assumptions,
placeholders, missing assets, and items requiring human review.

VERIFICATION
Verify desktop and mobile layouts, reduced-motion behavior,
forward and backward scrolling, all four direct chapter
controls, the starter-guide download, and every CTA target.
Check for camera clipping, obscured captions, early sculpture
reveals, broken reflections, layout shifts, and console errors.

DONE WHEN
The four chapters read as one continuous sculpture garden.
Each sculpture and caption communicates its intended idea.
The camera path works in both directions without clipping.
Mobile and reduced-motion views preserve the story. The
resource downloads and every CTA works. The project launches
on an unused localhost port and remains running for review.
A static lookalike or four disconnected scenes is not done.
```

## How to use it

Swap the home-goods facts for yours. Keep the shape: who it is for, what they should do, what each chapter does, and how scroll drives it.

Give every reference a job (type, layout, motion, nav). Do not write "combine these sites." A URL is not enough for motion. Attach desktop and mobile screenshots, plus a slow recording of load-in, the full scroll, and hovers.

In MOTION, pick one: **scroll-triggered** (starts when a section arrives) or **scroll-controlled** (tied to scroll position and reverses on the way back). Storytelling homepages usually need the second. "Smooth" and "immersive" are not instructions.

If you already have a site, put screenshots or the archive in `old-version/` and reusable media in `old-version-assets/`. Add this under BUSINESS:

```text
old-version/ is the source for confirmed business facts,
services, offers, and existing messaging.
old-version-assets/ holds reusable media. Use what fits.
Keep the facts. You may reorganize copy for clarity.
Do not invent claims, prices, stats, or testimonials.
Do not reproduce the old styling. Log unknowns in
TODO-Facts-and-Presumed.md.
```

After the first pass, do not ask it to improve the whole site. Name the broken beat, the expected behavior, and what must stay. Attach a screenshot.

```text
Review the scroll-driven system. Find transitions that
feel abrupt or disconnected, especially between chapters.
Fix timing and coordination. Forward and reverse scroll
must both work. Keep the current visual identity and
structure.
```
