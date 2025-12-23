Aka: Ever-updating high-level context that optimizes token usage and lowers likelihood of lines disappearing

When you use AI prompts to change code, **two things can go wrong**—especially in a big codebase:

1. **Unrelated code gets erased.**  
    It’s common for **200+ lines from another feature** to get wiped when you’re changing something else.
    
2. **Token use gets high (cost goes up).**  
    If the AI doesn’t have a clear “map” of the project, it needs more tokens to figure things out. That can cost more money, and it can also make the AI guess when it runs out of room.
    

The fix is a simple **context management system**. It gives the AI a reliable map of your codebase, so it doesn’t guess or bulldoze parts it doesn’t understand.

---

## Context Handling Rules for AI Prompts (Simple Version)

### 1) What `context.md` is for

**`context.md` is your codebase map.**  
It explains what the app does, how it’s organized, and where key parts live.

This helps the AI:

- avoid deleting unrelated code
- make fewer wrong assumptions
- use fewer tokens (lower cost)

---

### 2) When `context.md` gets too big

If `context.md` becomes too long, create feature files:

- **`context-<feature>.md`** = details for one feature only
- `context.md` should **point to** those files instead of repeating everything

This keeps the “map” short and easy to use.

---

### 3) Prompt 2 (Use this for every code change)

**Prompt 2 should be used with every prompt that changes your code.**

What Prompt 2 does:
1. **Tell the AI what change you want**
2. **Tell it to read `context.md` and any related `context-*.md` first**
3. **After the change is done**, tell it to update the context files to match the new code

Why this matters:
- lowers the risk of “oops, it deleted another feature”
- reduces token waste (less money)
- keeps your context files accurate

---

### 4) If you forget Prompt 2

It happens. If you accidentally make changes without Prompt 2, then later you should **re-sync the context** by running Prompt 1 again.

---

## Prompt 1 vs Prompt 2 (How to use them)

### Prompt 1 — Initialize or re-sync the context

Prompt 1 creates `context.md` (and `context-*.md` files if needed).  
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

Prompt 1 initializes context management via a [context.md](https://context.md "https://context.md") file. Therefore, prompts to change the website can ask AI to refer to the [context.md](https://context.md "https://context.md") file that is a high level explanation of the code with line numbers. This makes it less likely that 200 lines of code for another feature get wiped often when you’re making an unrelated code change via the prompt. Token window doesn’t run out and AI doesn’t make assumptions as much about what’s a feature or not.

Prompt 1 should be ran every so often to sync your code changes to the context files if you've been sliding from using the evergreen prompt for every feature request. However, running prompt 1 to sync the code also gives it an opportunity to make the context file more efficient (shortening explanation or splitting into context*.md files), so run Prompt 1 at:
- After 1 major feature change where a lot of files or lines got modified/created
- After 3-5 minor changes

  
Prompt 1:
```
We’ve just updated the code. Please update or generate the `context.md` documentation so **AI tools** can reliably understand the project and generate code safely.  
  
**Goal:**    
Maintain `context.md` and `context-*.md` so any AI assistant always has a fast, accurate way to re-learn the project and answer prompts effectively—without risking accidental code loss.  
  
---  
  
## 1. Base `context.md` (High-Level Overview)  
  
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
  
👉 Add a short reminder note at the top of **each** `context.md` and `context-*.md` file stating that **approximate references are intentional**.  
  
---  
  
## 2. Feature-Specific Context Files (`context-*.md`)  
  
If `context.md` becomes too long:  
1. First, condense it.  
2. If still too long, split details into feature-specific files:  
   - `context-auth.md`  
   - `context-ui.md`  
   - `context-api.md`  
   - etc.  
  
Each `context-*.md` file should:  
- Follow the same outline as `context.md`  
- Cover **only its own module**  
- Use approximate code-location references (same rule as above)  
  
`context.md` (no suffix) must always remain the **high-level overview**, possibly paired with feature context*.md files for detail. We look into the codebase afterwards if the context files are insufficient. This keeps executions token efficient.  
  
---  
  
## 3. Recent Changes Awareness  
  
You may read the git log to understand what was recently implemented based on commit message names.    
  
  
---  
  
## 4. Optimization for Context Windows  
  
- Keep documentation **concise** to save tokens  
- You may include the **total line count** of referenced files (helps decide whether to load entire files later)  
- When context space is limited:  
  - Prioritize `context.md`  
- Anchor responses explicitly with:  
  > “Refer to context.md for high-level context; details are in feature context files.”  
  
If you only edited `context.md` (and not any `context-*.md` files), once finished:  
- Assess whether `context.md` has become too long or detailed  
- If so, determine whether it should be split into feature-specific `context-*.md` files
```


Then to make sure AI actually uses the [context.md](https://context.md "https://context.md") for every prompt which makes it less likely your other code just disappears from code changes:

Prompt 2 -
```
Refer to context.md and any applicable context-*.md for high level understanding of the codebase if needed.  
  
Let's implement:  
"""  
{your_prompt_for_feature_or_change}  
"""  
  
Only after the implementation is complete, you should update context.md and/or the relevant context-*.md files to reflect the new state of the codebase.
```


---

IF, IF it's a full stack app with both frontend and backend in the same codebase, and you've been managing two separate context.md (one for backend and one for frontend), then use this prompt (after adjusting the frontend and backend paths in the prompt):
```
Recall that we have two apps here. The API backend is the root. And the frontend is in app/. Each root directory and app/ subdirectory have a context.md and its associated context-*.md that helps the AI assistant to understand the codebase at a high level without having to analyze the entire codebase.  
  
{your_prompt_for_feature_or_change}  
  
Only after the implementation is complete, you should update the appropriate context.md and/or th context-*.md files to reflect the new state of the codebase.
```

---

To be extra safe
  

Every once in a while (especially if you had used cheaper Auto and now at Max):
```
The files context.md and context-*.md provide AI-oriented summaries of the codebase. Please audit them against the source to confirm their accuracy and fix any discrepancies at the context files.
```


---

If you slide from using the evergreen prompt for every feature, your context.md and context*.md files are out of sync. You can resync it by running prompt 1 which is polymorphic for initializing vs updating existing context files. 

If it's too out of sync, you may want to specify the number of commits after analyzing "git logs" (adjust the number of git commits to look back in the prompt):
```
We've changed code. Refer to previous 4 commits to figure out what we need to update context.md with. Remember that context.md is used for AI to gain high level understanding of the codebase
```


---

Curious - when does it split into context*.md files

When context.md file becomes too long, and shortening the explanations become impractical, prompt 1 will split the context.md into content*.md named after their features, while the main context.md file will be the base for all the other content*.md files. You'll see Cursor report something like this:
![[Pasted image 20251223033847.png]]

How often should we run Prompt 1 for context token-efficient refactoring purposes? 
- After 1 major feature change where a lot of files or lines got modified/created
- After 3-5 minor changes
