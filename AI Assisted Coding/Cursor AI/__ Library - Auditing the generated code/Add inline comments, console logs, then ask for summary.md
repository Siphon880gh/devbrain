Scenario: You had AI generated huge sections of code or even an entire file of code.

You can double check the work better if you ask the AI to add inline comments, add the console logs, then ask for summary.

You can then read through the inline comments, check if the console logs output expected values, and then check against the summary.

Reasoning why this methodology works: The AI has even more context to explain the code more accurately.

---

Manner of prompting: Subsequent. Prompt in the same thread.

Model: ChatGPT 4o

**Prompt 1:**

> Add inline comments explaining what each major section or line of the code is doing.

**Prompt 2:**

> Please add `console.log` statements throughout the code to show the execution flow and highlight key logic steps.

**Prompt 3:**

> Summarize the overall execution flow and logic of this code in plain language.