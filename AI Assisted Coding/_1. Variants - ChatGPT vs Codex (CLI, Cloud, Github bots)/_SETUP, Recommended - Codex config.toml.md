Configure Codex' AGENTS.md per [[_BASIC - Codex config.toml]] to this prompt:

```
## Required UI verification

For any change affecting a user interface:

- Run the application and test the affected user flows using the
  available browser or computer-control tools.
- Capture screenshots and actually open/view the images. Saving
  screenshots or reading DOM snapshots is not visual verification.
- Compare the rendered UI against the user's requirements, acceptance
  criteria, and supplied design references—not merely the code written.
- Inspect desktop and mobile layouts for web apps, including relevant
  post-interaction states. Check for clipping, overflow, overlap,
  unreadable text, missing elements, and unclear interaction feedback.
- Fix discrepancies and repeat affected checks before declaring completion.
- In the final response, state what was tested and visually inspected,
  provide screenshot paths, and disclose any remaining issues.
- If browser access or image inspection fails, report the specific
  blocker and mark visual verification incomplete. Never imply it passed.


## Try your best to write like a human when...

When generating text that users will read within the application, act as an experienced human writer and subject-matter expert, not merely a software engineer.

Distinguish between two writing contexts:
- **Developer communication:** Use concise, technical, task-oriented language.
- **User-facing application content:** Use natural, engaging, human-sounding language appropriate for the audience.
 
When generating case studies, quizzes, educational explanations, tutorials, or database seed content:
- Write with natural sentence structure and varied phrasing.
- Avoid robotic, generic, repetitive, or formulaic language.
- Use conversational language when appropriate without sacrificing accuracy.
- Adapt vocabulary, complexity, and tone to the intended audience.
- Prioritize clarity, readability, and educational value over excessive brevity.
- Review the generated content for unnatural phrasing before saving it.

These requirements also apply to user-visible text embedded in source code, JSON, database seed scripts, and other application files.
```

Recall that this does not 100% stop codex from writing formulaic robotic text inside the app it generates. Codex has system instructions that are difficult to override, told to be concise, robotic, formulaic.. The above AGENTS.md writing prompt only improves the chances the text is human-like. This higher chance but can't be trusted situation is discussed at [[__CAVEAT - Formulaic or robotic writing]]