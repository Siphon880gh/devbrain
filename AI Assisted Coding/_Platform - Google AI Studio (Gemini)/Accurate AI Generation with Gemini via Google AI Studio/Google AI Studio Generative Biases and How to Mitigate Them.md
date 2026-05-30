As of January 2025, apps built and run inside Google AI Studio can use generative tokens at no cost, including both code generation that creates the app, and text-to-image generation through the app you created.

That said, there are still a few gotchas when relying on Google AI Studio for code generation:

Sometimes Google AI Studio is biased towards eager to complete (doesn't ask permission), completing other features it thinks your app needs, simplifying the UI (at the expensive of breaking or removing full features). It's recommended you supervise the thinking explanation and stop generation as soon as it steers away from your prompt's purpose. It would cancel any code modifications/generations and restore your code before the prompt was run (if it had started editing code). 

If the code generation has completed already, to restore to the previous code, see if there's a checkpoint created in the chat - and if not, you will have to restore your code manually by uploading a zip file of the last commit (Google AI Studio can sync with GitHub, so you can download the codebase as a ZIP - and ideally, you’ve been keeping GitHub updated after every prompt-based code change), and then you'd have to drag files back into place. Most times you cannot reverse the changes by prompting it to reverse the changes, because Google AI Studio cannot read its own thoughts from the previous turn, although you the user can read the thoughts.

---

It doesn't hurt to include SYSTEM OVERRIDES in your prompt to instruct Google AI Studio to NOT do the above. In addition, you add the same instructions in the project's System Instructions.

However, Google AI Studio also on random generations would ignore your SYSTEM OVERRIDES and SYSTEM INSTRUCTIONS. This causes the code generation to lose a lot of lines of code or break your app by being eager to complete. Therefore, you must monitor the thoughts it explains even if you have SYSTEM OVERRIDES and SYSTEM INSTRUCTIONS, then stop before code starts editing (it will revert to before the prompt) or gets completely done editing.

---

I have a more walkthrough example at
https://github.com/Siphon880gh/Vibe-Coding__Text-to-Image-AI-App__Prompt-Engineering-Mitigating-Context-Truncation-and-Gemini-Bias/

---
In addition to platform techniques (like monitoring the AI’s reasoning) and prompting techniques (like system-level instructions), you can also use **coding techniques** to reduce bias in what the AI changes.

One bias that sometimes appears is the AI **simplifying the UI**. On an even rarer occurance, it will simplify the UI without calling it out in the AI thoughts.

- **Solution:** Don’t show every control by default. Use UI modes (e.g., _Advanced Mode_, _Edit Mode_) that conditionally reveal extra buttons and settings. Or use modals or collapsible/expandable panels to group buttons so that they're visible only when the user needs them.
- **Solution:** Use **progressive disclosure** so the default view stays clean, and complexity appears only when it’s needed.
    
- **Why this matters:** Even if you’re reviewing the AI’s reasoning, it may simplify the UI while implementing a feature without clearly calling it out. Designing the UI to be intentionally “simple by default” helps prevent unwanted simplification.

---

You can also use personal workflow habits to reduce the impact of tool changes. One common scenario is Google AI Studio removing or changing a feature you relied on. If that happens—and restore options don’t bring it back—you don’t want to be stuck rebuilding from memory.

To protect yourself, keep a small “prompt library” for the major features you don’t want erased. Save the key prompts that define your app’s core behavior (and any important constraints). If a feature disappears, you can quickly re-prompt from your saved library and rebuild that specific part of the app with minimal downtime.

Title ideas you can use in a README or notes:

- Just in case - Feature re-add prompts (Google AI Studio X feature removal bias)
  
- Prompt Library (Just-in-Case)
    
- AI Studio Recovery Prompts
    
- Feature Rebuild Prompts
    
- Restore Plan: Saved Prompts
    
- Prompt Backup Strategy
    
- Resilience Notes: Rebuild from Prompts

You can preface it with Google AI Studio might preferably remove certain features without permissions. These prompts serve to re-add features just in case that event happens and recovery efforts failed.

---

As of January 2026, Google AI Studio can still show occasional “random” bias/quirk behavior during generation that can derail an otherwise stable codebase. The safest personal workflow habit is to save often—either by syncing to GitHub or downloading a ZIP backup from Google AI Studio. If synced to Github, you can easily re-sync after every code generation (Click the Github icon each time).

If the AI breaks your app and there isn’t a usable “Restore checkpoint” for that turn (they only appear sometimes), you can still recover from your ZIP:

Upload the ZIP through the upload (+) option so it expands into files in Code View. Then move the restored files into the correct locations (or replace the broken versions), click Save, and Preview. If everything loads correctly, your restore is complete.