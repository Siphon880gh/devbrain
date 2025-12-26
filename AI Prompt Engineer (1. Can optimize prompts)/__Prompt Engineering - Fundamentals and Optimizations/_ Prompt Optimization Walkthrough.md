
Required tools/skills: Pretty Prompt (https://www.pretty-prompt.com/) or know how to perform meta prompting

---

## Prompt Optimization Walkthrough and Documentation Template

### Table of Contents

1. Overview
2. Instructions
3. Template
4. Example
5. Example (Expanded)

---

## 1) Overview

This workflow helps you **improve a prompt without losing the original intent**, and **document both the unoptimized and optimized versions** so you can reuse, audit, and iterate reliably.

Core rule:  
**The Original Prompt gets rewritten at an 8th grade level and serves as the source of truth for all optimizers.**  
Optimized prompts are regenerated artifacts—never manually patched.

---

## 2) Instructions

Follow these steps to optimize and document a prompt.  
**The documentation template you’ll use is in the next section (“Template”).**

### Step 1 — Start With the Original Prompt (Unoptimized)

- Write the prompt exactly as you would normally.
- Do not pre-edit or polish.
- Treat this as your canonical “source of truth.”

### Step 2 — Generate an Optimized Prompt (Pretty Prompt or Meta-Prompting)

- 1. Paste the original prompt into ChatGPT, asking it to rewrite it for 8th grade level reading, clarity, and flow. Do not lose any details. Prompt:
```
Rewrite this so it’s easy to read at an 8th-grade level, with clear wording and good flow. Do not remove any details. Do not add new formatting or lists. Keep the same structure as the original text (for example, if it’s all paragraphs, keep it all paragraphs).

Need rewriting:
{Original_Prompt}
```
  
- 2. Paste the full original prompt in 8th grade reading level into:
    
    - **Pretty Prompt** ([https://www.pretty-prompt.com/](https://www.pretty-prompt.com/)) adds a button at ChatGPT. Clicking that button enhances/optimizes your prompt:
      ![[Pasted image 20251224063100.png]]
    - Or your own meta-prompting flow.
        
- Generate an optimized version with clearer structure, constraints, and outputs.
    
### Step 3 — Capture the Goal (1–3 Sentences)

After you have the optimized prompt, copy the **entire optimized prompt** and run:

```text
Explain in 1–3 sentences the goal of this prompt:

[PASTE OPTIMIZED PROMPT HERE]
```

This produces a stable “intent anchor” describing:
- what it accomplishes,
- who it’s for,
- what success looks like.

If the goal is wrong:
- Don’t edit the goal directly.
- Update the **Original Prompt that's been rewritten in 8th grade reader level**, regenerate the optimized prompt, then re-run goal extraction.

### Step 4 — Validate Alignment

Quickly confirm:

- The goal matches your intent
- The optimized prompt fulfills the goal
- No important requirements were added or lost    

If anything is off, loop back to Step 1 (edit the prompt with 8th grade reading rewrite).

### Step 5 — Document Everything Using the Template

Document these three items (using the Template section below):

- Goal (1–3 sentences)
    
- Optimized Prompt
    
- Original Prompt (source of truth - this is the rewritten 8th grade level reading prompt. You may have it collapsible in Upnote/Obsidian for progressive disclosure to the person reading the notes)

### Iteration Rules (Non-Negotiable)

- ✅ Always edit the **Original Prompt** first
    
- ❌ Never patch only the optimized prompt
    
- 🔁 Re-run optimization when scope changes, quality drops, or your tool/model changes
    

---

## 3) Template

### Prompt Name (Optional)

---

### Goal (1–3 sentences)

> [Paste the extracted goal here]

---

### Optimized Prompt (Pretty Prompt / Meta-Prompt)

```text
[Paste the optimized prompt here]
```

---

### Original Prompt (Source of Truth)

```text
[Paste the original, unedited prompt here]
```

**Notes**

- If you discover missing requirements later:
    
    - Update the **Original Prompt**
        
    - Regenerate the optimized prompt
        
    - Re-extract the goal
        
- Don’t hot-fix only the optimized prompt

---

## Related: How to document prompt optimization

Refer to [[Prompt Optimization Documentation]]