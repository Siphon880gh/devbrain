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