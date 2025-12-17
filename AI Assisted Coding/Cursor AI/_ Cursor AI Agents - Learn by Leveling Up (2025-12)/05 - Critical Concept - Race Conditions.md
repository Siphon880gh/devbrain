You must **account for race conditions** when one part of your Cursor AI prompt **edits a file** and another part **produces an output that depends on that file**—EVEN if they're two separate sentences following one after another.

A common workflow looks like this:

- Insert **inline comments** into a Markdown or HTML document suggesting where a chart, screenshot, or callout could improve clarity.
- Generate a **CSV file** that refers to document lines (often with line numbers) and a summary of changes, so you can reference exact locations later.

Opus 4.5 Agent Mode lacks common sense when given those two tasks. You must be explicit that one task completes before the next begins. Opus 4.5 may randomly find it efficient to perform both tasks simultaneously in some runs; in other runs, it may perform tasks consecutively as the sentences are ordered.

When done simultaneously, every insertion shifts line positions. Instead of regenerating the CSV from the final file, the AI may "patch" the CSV by **estimating** where lines should land—creating a clean-looking output that doesn't actually match the finished document.

A human would naturally do this in order: **finish the edits, then generate the CSV**. But Cursor AI won't always follow that sequencing automatically—even if you write the steps as two sentences. You need to be explicit with **"THEN"**, or split the prompt into **phases** and tell it to start Phase 2 only after Phase 1 is complete. Otherwise, it may mix operations and produce mismatched line references.

The reliable pattern is simple:

1. **Edit phase (mutate):** modify the document only. No CSV. No line mapping.
2. **Derive phase:** read the finalized document and generate the CSV from it exactly.

That separation keeps your workflow deterministic and prevents the AI from guessing mid-edit.

---

## Bad Example: Single Prompt That Causes Race Conditions

```
Edit this document to suggest where charts, screenshots, or callouts should be added by inserting inline comments. 
We also need a CSV file that references the line numbers where those recommendations appear and what the recommendations are.
```

**Why this fails:**

- The prompt mixes **file mutation** (editing the document) with **derivation** (creating a CSV).
- Cursor AI may start generating the CSV before all inline comments are inserted.
- As comments are added, line numbers shift.
- Instead of regenerating the CSV from the final document, the AI may **estimate** line positions or mentally "adjust" them.
- The result is a CSV that looks valid but doesn't accurately reflect the finished file.

This kind of prompt invites the AI to interleave steps, which is exactly how race conditions happen.

---

## Preferred Approach: Two Prompts (Safest)

**Prompt 1 — Edit only**

```
Add inline comments suggesting where charts, screenshots, or callouts could improve clarity.

Rules:
- Modify the document only.
- Do NOT generate a CSV or line numbers.
- Do NOT reference or estimate line positions.
- Finish all edits and stop.
```

**Prompt 2 — Derive only**

```
Read the finalized document and generate a CSV with the columns:
line_number,content

Rules:
- Do NOT modify the document.
- Generate the CSV strictly from the current file contents.
- Do NOT estimate or adjust line numbers.
```

This approach eliminates ambiguity and guarantees the CSV is derived from a stable file.

---

## If You Must Use a Single Prompt

Sometimes you're constrained to one prompt. In that case, you must **hard-gate the phases** so the AI cannot interleave them.

**Single-prompt, phased example:**

```
You will perform this task in two strict phases.

PHASE 1 — DOCUMENT EDIT
- Add inline comments suggesting where charts, screenshots, or callouts could improve clarity.
- Modify the document only.
- Do NOT generate a CSV, line numbers, or summaries.
- When all edits are complete, write exactly:
  "PHASE 1 COMPLETE"

PHASE 2 — CSV GENERATION (START ONLY AFTER PHASE 1 COMPLETE)
- Treat the document as read-only.
- Generate a CSV with columns: line_number,content
- Each physical line in the file must map to one CSV row.
- Do NOT estimate or adjust line numbers.
```

Even in a single prompt, explicitly enforcing phase boundaries dramatically reduces race conditions and keeps Cursor AI from guessing while the file is still changing.

