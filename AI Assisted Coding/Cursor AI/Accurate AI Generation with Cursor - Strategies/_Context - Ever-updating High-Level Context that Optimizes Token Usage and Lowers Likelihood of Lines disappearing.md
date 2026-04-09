When a repo gets large, the model may change how it reads the code in the name of “efficiency”:
- **It may skim and stop early** once it _feels_ it has enough context to proceed. If key context lives elsewhere, it can add, change, or remove code in the wrong places and break your app.
- **It may overwrite or delete unrelated code,** sometimes wiping 200+ lines from an existing feature while editing something else.
- **It may use more tokens trying to rebuild the missing big picture,** which increases cost and can cause it to start guessing when it runs out of room.

---

As the codebase gets bigger, it gets easier for AI to make mistakes when adding new features. The AI often reads only the parts it thinks matter and misses other important code. That can cause it to delete lines by accident or break other parts of the app.

To prevent this, we will keep a simple “app overview” file that explains how the app works at a high level. The file would reference other files in the codebase. The AI should read this file first instead of guessing what code to look at. We will update this file every time we add or change a feature so it stays accurate.

---

In other words, **we create code maps with line references in `LLM-CODE-REFERENCE*.md`**  
. The goal is to help AI avoid stopping too early when reading the codebase to complete a task.

These map files give a high-level overview of the project while also pointing to specific line references, so AI can navigate the code more reliably without needing to rediscover everything from scratch each time.

The tradeoff is that the maps need occasional updates. A good time to refresh them is when a feature or major step is completed, especially around the same time AI recommends making a commit.

---

I have a more walkthrough example at
https://github.com/Siphon880gh/Vibe-Coding__Text-to-Image-AI-App__Prompt-Engineering-Mitigating-Context-Truncation-and-Gemini-Bias/
It includes SYSTEM OVERRIDES in the prompt to help mitigate Gemini biases that degrade code quality. Those system overrides can be removed from the prompt if not using Gemini / Google AI Studio

---

## Context Handling Rules for AI Prompts (Simple Version)

### 1) What `LLM_CODE_REFERENCE.md` is for

**`LLM_CODE_REFERENCE.md` is your codebase map.**  
It explains what the app does, how it’s organized, and where key parts live.

This helps the AI:

- avoid deleting unrelated code
- make fewer wrong assumptions
- use fewer tokens (lower cost)

---

### 2) When `LLM_CODE_REFERENCE.md` gets too big

If `LLM_CODE_REFERENCE.md` becomes too long, create feature files:
- **`LLM_CODE_REFERENCE-<feature>.md`** = details for one feature only
- `LLM_CODE_REFERENCE.md` should **point to** those files instead of repeating everything

This keeps the “map” short and easy to use.

---

### 3) Prompt 2 (Use this for every code change)

**Prompt 2 should be used with every prompt that changes your code.**

What Prompt 2 does:
1. **Tell the AI what change you want**
2. **Tell it to read `LLM_CODE_REFERENCE.md` and any related `LLM_CODE_REFERENCE-*.md` first**
3. **After the change is done**, tell it to update the context files to match the new code

Why this matters:
- lowers the risk of “oops, it deleted another feature”
- reduces token waste (less money)
- keeps your context files accurate

---

### 4) If you forget Prompt 2

If your LLM_CODE_REFERENCE.md might have been shifted because you didn't make it a discipline to update the LLM_CODE_REFERENCE.md everytime you prompt, or you made significant changes to the code manually:

You should **re-sync the context** by running Prompt 1 again. That prompt is built to look for LLM_CODE_REFERENCE.md, and if it doesn't exist, then initiate it; but if it does exist, then update it to new changes in the code it can detect.

---

## Prompt 1 vs Prompt 2 (How to use them)

### Prompt 1 — Initialize or re-sync the context

Prompt 1 creates `LLM_CODE_REFERENCE.md` (and `LLM_CODE_REFERENCE-*.md` files if needed).  
It can also **update** existing context files to match the current code.

Use Prompt 1:

- **at the start** (first time setup)
- **once in a while** to re-sync
- **especially if you forgot to use Prompt 2** for a change
    

### Prompt 2 — Evergreen driver for safe changes

Use Prompt 2:
- **every time you ask AI to change code**
- so the AI reads the map first, then updates the map after
    

---

## Location references (keep them simple)

When writing context files, don’t use exact line numbers. They change too fast.

Instead use:

- “near the top”
- “about 25% down”
- “around lines 100–150”
- “inside function `X`” / “below class `Y`”    

These stay useful even after edits.

---

## Prompts

After we've covered how they work, here are the brief explanations when to use the prompts and the prompts ready for copying:

Prompt 1 initializes context management via a [LLM_CODE_REFERENCE.md](https://LLM_CODE_REFERENCE.md "https://LLM_CODE_REFERENCE.md") file. Therefore, prompts to change the website can ask AI to refer to the [LLM_CODE_REFERENCE.md](https://LLM_CODE_REFERENCE.md "https://LLM_CODE_REFERENCE.md") file that is a high level explanation of the code with line numbers. This makes it less likely that 200 lines of code for another feature get wiped often when you’re making an unrelated code change via the prompt. Token window doesn’t run out and AI doesn’t make assumptions as much about what’s a feature or not.

Prompt 1 should be ran every so often to sync your code changes to the context files if you've been sliding from using the evergreen prompt for every feature request. However, running prompt 1 to sync the code also gives it an opportunity to make the context file more efficient (shortening explanation or splitting into context*.md files), so run Prompt 1 at:
- After 1 major feature change where a lot of files or lines got modified/created
- After 3-5 minor changes

  
Prompt 1:
```
We’ve just updated the code. Please update or generate the `LLM_CODE_REFERENCE.md` documentation so **AI tools** can reliably understand the project and generate code safely.  
  
**Goal:**    
Maintain `LLM_CODE_REFERENCE.md` and `LLM_CODE_REFERENCE-*.md` so any AI assistant always has a fast, accurate way to re-learn the project and answer prompts effectively—without risking accidental code loss in the context.  
  
---  
  
## 1. Base `LLM_CODE_REFERENCE.md` (High-Level Overview)  

If `LLM_CODE_REFERENCE.md` is missing, create it as a high-level knowledge base for the AI. Begin the file with a brief note explaining its purpose—helping AI tools understand the codebase—and list any companion `LLM_CODE_REFERENCE-*.md` files it references. For example:
"""
AI-oriented codebase map for safe modification, feature tracing, and implementation planning.
"""

Provide a **high-level description** of:  
- What the app does  
- Tech stack  
- Architecture
- File Tree – highlight relevant files and their roles
- High-level code flow  
  
Include:  
- A short **relevant file tree**  
- Selective **inline code snippets** with file references  
  
### ⚠️ Line Reference Rule (Important)  
  
Do **NOT** reference exact line numbers when describing code.  
  
**Reason:**    
Exact line numbers are fragile and inefficient because:  
- Code changes frequently  
- Line numbers shift with every edit  
- This creates unnecessary AI rework and increases race-condition risk  
- Maintaining exact references wastes compute and token budget  
  
**Instead, use approximate location cues**, such as:  
- “Near the top of the file”  
- “Roughly 25% into the file”  
- “Around lines 100–150”  
- “In the middle of the file”  
- “Below function `X`”  
- “Near the end of the file”  
  
This level of precision is sufficient for **high-level understanding** and makes it easy to navigate the code later without brittle references.  
  
👉 Add a short reminder note at the top of **each** `LLM_CODE_REFERENCE.md` and `LLM_CODE_REFERENCE-*.md` file stating that **approximate references are intentional**.  
  
---  
  
## 2. Feature-Specific Context Files (`LLM_CODE_REFERENCE-*.md`)  
  
If `LLM_CODE_REFERENCE.md` becomes too long:  
1. First, condense it.  
2. If still too long, split details into feature-specific files:  
   - `LLM_CODE_REFERENCE-auth.md`  
   - `LLM_CODE_REFERENCE-ui.md`  
   - `LLM_CODE_REFERENCE-api.md`  
   - etc.  
  
Each `LLM_CODE_REFERENCE-*.md` file should:  
- Follow the same outline as `LLM_CODE_REFERENCE.md`  
- Cover **only its own module**  
- Use approximate code-location references (same rule as above)  
  
`LLM_CODE_REFERENCE.md` (no suffix) must always remain the **high-level overview**, possibly paired with feature context*.md files for detail. We look into the codebase afterwards if the context files are insufficient. This keeps executions token efficient.  
  
---  
  
## 3. Recent Changes Awareness  
  
You may read the git log to understand what was recently implemented based on commit message names.    
  
  
---  
  
## 4. Optimization for Context Windows  
  
- Keep documentation **concise** to save tokens  
- You may include the **total line count** of referenced files (helps decide whether to load entire files later)  
- When context space is limited:  
  - Prioritize `LLM_CODE_REFERENCE.md`  
- Anchor responses explicitly with:  
  > “Refer to LLM_CODE_REFERENCE.md for high-level context; details are in feature context files.”  
  
If you only edited `LLM_CODE_REFERENCE.md` (and not any `LLM_CODE_REFERENCE-*.md` files), once finished:  
- Assess whether `LLM_CODE_REFERENCE.md` has become too long or detailed  
- If so, determine whether it should be split into feature-specific `LLM_CODE_REFERENCE-*.md` files
```


Then to make sure AI actually uses the [LLM_CODE_REFERENCE.md](https://LLM_CODE_REFERENCE.md "https://LLM_CODE_REFERENCE.md") for every prompt which makes it less likely your other code just disappears from code changes because of under-reading the codebase:

Prompt 2 -
```
Refer to LLM_CODE_REFERENCE.md and any applicable LLM_CODE_REFERENCE-*.md for high level understanding of the codebase if needed.  
  
Let's implement:  
"""  
{your_prompt_for_feature_or_change}  
"""  
  
Only after the implementation is complete, you should update LLM_CODE_REFERENCE.md and/or the relevant LLM_CODE_REFERENCE-*.md files to reflect the new state of the codebase.
```
^ Can replace with: "Let's implement:", "Let's fix:", "Let's adjust:"

---

IF, IF it's a FULL STACK app with both frontend and backend in the same codebase, and you've been managing two separate LLM_CODE_REFERENCE.md (one for backend and one for frontend), then use this prompt (after adjusting the frontend and backend paths in the prompt):
```
Recall that we have two apps here. The API backend is the root. And the frontend is in app/. Each root directory and app/ subdirectory have a LLM_CODE_REFERENCE.md and its associated LLM_CODE_REFERENCE-*.md that helps the AI assistant to understand the codebase at a high level without having to analyze the entire codebase.  
  
{your_prompt_for_feature_or_change}  
  
Only after the implementation is complete, you should update the appropriate LLM_CODE_REFERENCE.md and/or the LLM_CODE_REFERENCE-*.md files to reflect the new state of the codebase.
```


---

IF, IF it's a GOOGLE AI STUDIO (GEMINI), it has a chance of removing a lot of your code in an effort to minimize token usage, especially after many uses or the codebase has grown large, and it's not a setting you can control. This prompt lowers the chance that occurs:
```
Refer to LLM_CODE_REFERENCE.md and any applicable LLM_CODE_REFERENCE-*.md for high level understanding of the codebase.

"""
Add only:
{_FEATURE_}

SYSTEM OVERRIDE:  
Make **only** the changes I explicitly request. Do **not** add features, refactor, optimize, or “finish the app” unless I ask.

SYSTEM OVERRIDE:  
Keep changes **minimal and surgical**: modify only the **relevant files/sections** and only the **lines strictly necessary** to complete the request. Preserve all existing behavior.

SYSTEM OVERRIDE:  
Treat **LLM_CODE_REFERENCE.md** and any **LLM_CODE_REFERENCE-*.md** as **authoritative descriptions of the existing codebase**.
"""

Only after the implementation is complete, you should update LLM_CODE_REFERENCE.md and/or the relevant LLM_CODE_REFERENCE-.md files to reflect the new state of the codebase.
```
^ Can swap with: Add only / Fix only / Improve only

Google AI Studio on random generations will have a bias doing exactly what your SYSTEM OVERRIDES said NOT to do, and out of those random generations, it might choose to ignore your SYSTEM OVERRIDES regardless if they're in the prompt or in Google AI Studio's preferences. This causes the code generation to lose a lot of lines of code or break your app. Sometimes Google AI Studio is biased towards eager to complete (doesn't ask permission), completing other features it thinks your app needs, simplifying the UI (at the expensive of breaking or removing full features). It's recommended you supervise the thinking explanation and stop generation as soon as it steers away from your prompt's purpose. It would cancel any code modifications/generations and restore your code before the prompt was run (if it had started editing code). If the code generation has completed already, to restore to the previous code, see if there's a checkpoint created in the chat - and if not, you will have to restore your code manually by uploading a zip file of the last commit (Google AI Studio can sync with GitHub, so you can download the codebase as a ZIP - and ideally, you’ve been keeping GitHub updated after every prompt-based code change), and then you'd have to drag files back into place. Most times you cannot reverse the changes by prompting it to reverse the changes, because Google AI Studio cannot read its own thoughts from the previous turn, although you can read the thoughts.

---

To be extra safe
  

Every once in a while (especially if you had used cheaper Auto and now at Max):
```
The files LLM_CODE_REFERENCE.md and LLM_CODE_REFERENCE-*.md provide AI-oriented summaries of the codebase. Please audit them against the source to confirm their accuracy and fix any discrepancies at the context files.
```


---

If you slide from using the evergreen prompt for every feature, your LLM_CODE_REFERENCE.md and context*.md files are out of sync. You can resync it by running prompt 1 which is polymorphic for initializing vs updating existing context files. 

If it's too out of sync, you may want to specify the number of commits after analyzing "git logs" (adjust the number of git commits to look back in the prompt):
```
We've changed code. Refer to previous 4 commits to figure out what we need to update LLM_CODE_REFERENCE.md with. Remember that LLM_CODE_REFERENCE.md is used for AI to gain high level understanding of the codebase
```


---

Curious - when does it split into context*.md files

When LLM_CODE_REFERENCE.md file becomes too long, and shortening the explanations become impractical, prompt 1 will split the LLM_CODE_REFERENCE.md into content*.md named after their features, while the main LLM_CODE_REFERENCE.md file will be the base for all the other content*.md files. You'll see Cursor report something like this:
![[Pasted image 20251223033847.png]]

How often should we run Prompt 1 for context token-efficient refactoring purposes? 
- After 1 major feature change where a lot of files or lines got modified/created
- After 3-5 minor changes
