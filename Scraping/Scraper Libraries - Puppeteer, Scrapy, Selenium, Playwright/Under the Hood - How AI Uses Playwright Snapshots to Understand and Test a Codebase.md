Related: [[_PRIMER - Scraper Libraries - Puppeteer, Scrapy, Selenium, Playwright]] · [[Headed Chrome passing information to AI for scraping method]] · [[Start the app and test the flow on desktop and mobile]]

You can ask an AI to analyze a codebase, identify how an application works, and then inspect it in a browser. Reading the code reveals the intended behavior. Browser inspection shows what the application actually presents to users.

During that process, an AI using Playwright MCP may generate a file such as:

`.playwright-mcp/page-2026-10-27T09-44-38-875Z.yml`

This is a saved page snapshot: a structured, text-based record of the webpage the browser inspected.

## What you could tell the AI

A useful instruction connects code analysis with browser verification:

> Analyze this codebase and explain its architecture, main features, routes, and user flows. Identify how to run the application, then launch it if the environment permits.
>
> Use Playwright to inspect the main pages and exercise the important user flows. Save page snapshots and explain what each snapshot shows in plain language.
>
> Compare the browser observations with the code. Report broken links, missing content, accessibility concerns, and differences between intended and observed behavior. Distinguish what you verified from what you inferred, and identify anything you could not test. Do not change the code without approval.

This gives the AI a concrete task: understand the implementation, inspect the running application, and connect its findings to evidence.

## From code analysis to browser data

The AI first examines the project’s files. Depending on the application, these might include page components, routing configuration, styles, backend endpoints, tests, and startup scripts.

That analysis helps it work out which pages exist, what features they implement, and which user actions are worth testing.

If it can run and access the application, it can then use Playwright MCP—a browser-automation interface—to open pages, inspect their content, click controls, fill forms, and observe the results.

A saved snapshot captures the page structure at a particular point in that process. **It is generated from the browser’s view of the application, rather than directly from the source code.**

## Example: The generated Playwright snapshot

Here is the supplied snapshot from the Weng Industries landing page. Although it resembles a code snippet, it is browser inspection data, not application source code.

- main [ref=f4e2]:
  - generic [ref=f4e3]:
    - link "Weng Industries home" [ref=f4e4] [cursor=pointer]:
      - /url: https://wengindustries.com/
      - text: WENG INDUSTRIES
    - heading [level=1] [ref=f4e5]:
      - text: Tools for the
      - emphasis [ref=f4e6]: attention-diverse
      - text: mind.
    - paragraph [ref=f4e7]: Small, focused apps that help turn a pile of thoughts or a wall of information into a clear next step.
  - navigation "Browse tools" [ref=f4e8]:
    - link "Organize" [ref=f4e10] [cursor=pointer]:
      - /url: "#organize"
      - text: Organize ↘
    - link "Understand" [ref=f4e11] [cursor=pointer]:
      - /url: "#understand"
      - text: Understand ↘
  - region [ref=f4e12]:
    - generic [ref=f4e13]:
      - paragraph [ref=f4e14]: 01 / ORGANIZE
      - heading "Give scattered thoughts a home." [level=2] [ref=f4e15]
    - link "Open Scattered Notes" [ref=f4e16] [cursor=pointer]:
      - /url: scattered-notes/
      - generic [ref=f4e17]:
        - generic [ref=f4e18]: NOTE ORGANIZER
        - heading "Scattered Notes" [level=3] [ref=f4e19]: ScatteredNotes
        - paragraph [ref=f4e20]: Bring loose notes, half-thoughts, and saved links into one clear review space.
        - generic [ref=f4e21]: Open tool ↗
      - figure [ref=f4e22]:
        - img "Scattered Notes app showing organized task cards" [ref=f4e23]
  - region [ref=f4e24]:
    - generic [ref=f4e25]:
      - paragraph [ref=f4e26]: 02 / UNDERSTAND
      - heading "Find your way through the heavy stuff." [level=2] [ref=f4e27]
    - link "Open Heavy Docs" [ref=f4e28] [cursor=pointer]:
      - /url: heavy-docs/
      - generic [ref=f4e29]:
        - generic [ref=f4e30]: DOCUMENT GUIDE
        - heading "Heavy Docs" [level=3] [ref=f4e31]: HeavyDocs
        - paragraph [ref=f4e32]: Turn dense documents into an honest reading map, key points, and a useful review flow.
        - generic [ref=f4e33]: Open tool ↗
      - figure [ref=f4e34]:
        - img "Heavy Docs app showing document guides and key points" [ref=f4e35]
  - generic [ref=f4e36]:
    - generic [ref=f4e37]: Made by Weng
    - link "wengindustries.com" [ref=f4e38] [cursor=pointer]:
      - /url: https://wengindustries.com/
      - text: wengindustries.com ↗

## How to read the snapshot

The indentation shows which elements belong inside others. The `main` entry contains the page’s primary content; `navigation` contains the browsing links; and each `region` groups a tool section.

Heading levels express the content hierarchy: level 1 is the page title, level 2 identifies a section, and level 3 names a tool. A `generic` entry represents a container without a more specific semantic role.

Each `link` includes an accessible name and a `/url` destination. For example, `#organize` targets a section on the same page, while `scattered-notes/` is a relative link to another location on the site. The `img` entries contain accessible image descriptions rather than the images themselves.

References such as `ref=f4e16` identify elements for browser automation. The AI could use the reference associated with “Open Scattered Notes” to target that link in a subsequent interaction. The `[cursor=pointer]` annotation indicates a pointer cursor, not proof that the interaction works.

The snapshot is neither a screenshot nor the full HTML source. It is a compact representation that makes the page easier for the AI to inspect and interact with.

## A readable explanation of the example

Instead of leaving the user to interpret the raw snapshot, the AI could report:

> **Page inspected: Weng Industries tools landing page**
>
> The page introduces two apps for organizing thoughts and understanding dense information.
>
> **Scattered Notes** is described as a note organizer for loose notes, unfinished thoughts, and saved links. Its tool card points to `scattered-notes/`.
>
> **Heavy Docs** is described as a document guide that provides a reading map, key points, and a review flow. Its tool card points to `heavy-docs/`.
>
> The “Organize” and “Understand” navigation links target sections on the same page. The brand and footer links point to the Weng Industries homepage.
>
> **Evidence captured:** Landing-page text, heading hierarchy, link destinations, and image descriptions.
>
> **Not established by this snapshot:** Whether either app opens successfully, whether its features work, or whether a complete user flow passes.

That explanation preserves the useful evidence without making the user decode technical labels.

## How snapshots support codebase analysis

Snapshots help the AI compare implementation with observed behavior. A route may exist in the code but be missing from navigation. A button may appear on the page but fail when clicked. A heading may look prominent visually while lacking the expected semantic structure.

Finding those issues requires connecting the code, the browser snapshot, and the results of actual interactions. A single snapshot records one page state; additional actions and observations establish whether a flow works.

**The presence of a `.playwright-mcp` snapshot means a browser observation was saved. It does not, by itself, mean the AI completed a code review or successfully tested the application.** A useful final report explains what was inspected, what was exercised, what happened, and what remains unverified.
