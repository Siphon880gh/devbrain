  

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
**The Original Prompt is the source of truth.**  
Optimized prompts are regenerated artifacts—not manually patched.

---

## 2) Instructions

Follow these steps to optimize and document a prompt.  
**The documentation template you’ll use is in the next section (“Template”).**

### Step 1 — Start With the Original Prompt (Unoptimized)

- Write the prompt exactly as you would normally.
    
- Do not pre-edit or polish.
    
- Treat this as your canonical “source of truth.”
    

### Step 2 — Generate an Optimized Prompt (Pretty Prompt or Meta-Prompting)

- Paste the full original prompt into:
    
    - **Pretty Prompt** ([https://www.pretty-prompt.com/](https://www.pretty-prompt.com/)), or
        
    - your own meta-prompting flow.
        
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
    
- Update the **Original Prompt**, regenerate the optimized prompt, then re-run goal extraction.
    

### Step 4 — Validate Alignment

Quickly confirm:

- The goal matches your intent
    
- The optimized prompt fulfills the goal
    
- No important requirements were added or lost
    

If anything is off, loop back to Step 1 (edit Original Prompt first).

### Step 5 — Document Everything Using the Template

Document these three items (using the Template section below):

- Goal (1–3 sentences)
    
- Optimized Prompt
    
- Original Prompt (source of truth)
    

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

## Example
![[Pasted image 20251224045453.png]]

## Example (Expanded)
![[Pasted image 20251224045503.png]]