Use this prompt to add markdown rendering ability in your app (You have md files that you author, and you want your frontend app to render those md files in rich text format):

```
Implement a markdown viewer that opens `.md` files and renders them with the same enhanced markdown behavior as a knowledge-base reader. Match these capabilities end-to-end.

There may be some Obsidian markdown syntax such as `[[Note Title]]` and `![[filename.png]]` and collapsible callouts like `> [!note] Note heading`

### Core engine
- Parse with **markdown-it** (or equivalent) with:
  - `html: true`
  - `linkify: true`
  - `breaks: false`
  - `typographer: false`
- Soft line breaks: before render, turn single newlines into hard breaks by appending two trailing spaces to non-blank lines (so single Enter becomes a visible line break).
- Allow raw HTML in markdown.
- Support emoji shortcodes if available.

### Math / LaTeX
- Render inline math with `$...$` (KaTeX or a markdown-it LaTeX plugin such as MarkdownItLatex).
- Support display math if the library supports it.
- Preserve surrounding whitespace around math.

### Headings & navigation
- Auto-generate heading anchors/slugs (all levels h1–h6).
- Slugify: spaces → hyphens; strip non-alphanumeric except hyphens; if slug starts with a non-letter, prefix with `at`.
- Optional permalink symbol on headings.
- Build a **table of contents** from rendered headings.
- **Hierarchical indentation**: indent content under headings by heading level; a line/paragraph that is only `<<<` resets indentation hierarchy and should not be shown as content.

### Obsidian / vault syntax
- **Wikilinks**: `[[Note Title]]` → clickable internal note links.
- **Embedded pasted images**: `![[filename.png]]` (local image, not `http`) → standard `![](filename.png)`; encode spaces in image URLs as `%20`.
- **Highlight**: `==text==` → `<mark>text</mark>` (yellow background).
- **Strikethrough**: `~~text~~` → `<del>text</del>`.
- **Callouts / collapsible notes**: blocks like:
  """markdown
  > [!note] Heading
  > body line
  > more body
  """
  Render as `<details><summary>Heading</summary>…</details>` with the body markdown-rendered inside.
- **YAML frontmatter**: strip leading `---` … `---` before render; honor `brain_layout: center` by centering the note body if present.

### Code blocks
- Syntax highlight with **Highlight.js** (or equivalent).
- Dark code theme (~`#2d2d2d` background).
- Add a **line-number gutter** on the left of every `pre > code`.
- Add a **copy button** (top-right) with “Copied!” feedback; use Clipboard API with fallback.
- Do **not** show a language label badge.

### Images
- Resolve relative image paths appropriately for the app.
- Preserve absolute `http(s)://` image URLs as-is.
- Click-to-expand fullscreen image modal; ESC closes; don’t break other interactive elements.

### YouTube embeds
Auto-convert YouTube links into privacy-enhanced embeds (`youtube-nocookie.com`), 16:9 responsive iframe, with `referrerpolicy="strict-origin-when-cross-origin"`. Support:
- `youtube.com/watch?v=`
- `youtu.be/`
- `youtube.com/shorts/`
- `youtube.com/live/`
Validate video IDs as `[A-Za-z0-9_-]+` only. Replace the link with the embed.

### Mermaid mindmaps (interactive)
- Detect nested lists that include marker images named **`1x1.png`** (alt text = node label), e.g.:
  """markdown
  # Topic ![Topic](img/1x1.png)
  - Subtopic 1 ![Sub1](img/1x1.png)
    - Detail A ![DetailA](img/1x1.png)
  """
- Parse the nested list into a tree and render with **Mermaid.js** mindmap syntax (v10+).
- Layout modes: spider (radial), tree (top-down / left-right), and optional force “spread” layout (D3 force simulation).
- UI: show mindmap only when markers exist; zoom/pan; cycle layout; fullscreen.
- Also render standard Mermaid fenced code blocks if present: ` """mermaid `.

### Link preview popovers

#### External link previews
- Detect a link immediately followed by a marker image **`1x2.png`**.
- Alt patterns:
  - `startWord..endWord` (or `...`) → fetch page (CORS proxy OK), extract excerpt between words, show in hover/click popover.
  - `linkText##custom preview text` → show custom preview without fetch.
- Cache previews; fail gracefully.

#### Internal note hover preview (`.md` links)

When a user hovers over an **internal** link that opens another Markdown (`.md`) note, display a floating preview popover near the link.

Internal links include:
- Wiki-style links, such as `[[Note Title]]`
- Any equivalent internal note-link format already supported by the app

**Popover behavior**
- Show the popover after a short hover delay of approximately **300ms**.
- Position the popover near the hovered link.
- Keep the popover open while the pointer is over either:
  - The original link
  - The popover
- Add a short dismissal grace period so the user can move the pointer from the link onto the popover without closing it.
- Close the popover after the pointer leaves both the link and the popover.
- Cache fetched note content so repeated hovers do not trigger additional fetches.

**Popover tabs**

*Preview* (selected by default)
- Display the first prose paragraph from the target note.
- Append an ellipsis (`…`) after the paragraph when the note contains additional content.
- When locating the first prose paragraph, skip:
  - Frontmatter
  - Headings
  - Code fences
  - Images
  - List items
- Strip lightweight Markdown formatting before displaying the paragraph.
- If the note is inaccessible or private, display a clear message explaining that the preview is unavailable.

*Contents*
- Display a table of contents generated from the target note's Markdown headings.
- Support heading levels `#` through `######`.
- Indent each item according to its heading level.
- Each item links directly to that heading in the target note.
- Use the same navigation behavior as a normal internal note link, including the heading hash or slug.
- If the note has no headings, display an appropriate empty state.

**Popover states and actions**
- Loading state
- Error state
- Footer action to open the full note

**Compatibility**
- Do not break existing external-link previews.
- Do not alter any other existing link behavior.
- Match the app's existing UI patterns for overlays, popovers, and tooltips.
- Do not create a new note-fetching API; use the app's existing mechanism for loading Markdown notes by title, ID, or path.
- Do not change what happens when the user clicks an internal link — only add hover-preview functionality.

### External links
- Open external http(s) links in a new tab; keep internal note links in-app.

### Rendering pipeline order (important)
1. Strip/parse frontmatter  
2. Soft-break normalization  
3. Obsidian image `![[…]]` → `![](…)`  
4. `==highlight==` and `~~strike~~`  
5. Convert `[!note]` callouts to details HTML  
6. Prep LaTeX delimiters as required by the math plugin  
7. `markdown-it` render  
8. Rewrite relative image srcs  
9. Convert remaining `[[wikilinks]]` in HTML  
10. Fix NBSP (`\xA0`) issues in URLs/HTML  
11. Apply heading indentation + `<<<` resets  
12. Enhance YouTube links → embeds  
13. Highlight code + line numbers + copy  
14. Init mindmaps, link popovers (external + internal note hover previews), image modal, TOC  

### Goals for this prompt
We are creating a markdown open + render + post-enhancements above.

The post-enhancements includes: LaTeX (math equation rendering in markdown), Mermaid mindmaps, Obsidian syntax, callouts, code UX, YouTube, link popovers (external fetch/custom previews and internal note hover previews with Preview/Contents tabs), TOC, and the post-render pipeline.

Deliver: a working markdown open/render path in this other app’s stack, with the features above wired after each note load.

```