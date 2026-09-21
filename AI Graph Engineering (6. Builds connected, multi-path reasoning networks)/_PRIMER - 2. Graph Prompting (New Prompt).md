**Requirements:** Have Epics and Milestones in Markdown files, with a JSON state file that records progress as Milestones are generated and completed. This would have been done after you followed [[Plan with epics and milestones first]]

What's new with New Prompt:
As of August 2026, you don’t need to explain how to structure graph or loop prompts. The AI can handle that. You can simply use the following prompts to have the AI generate the graph and loop prompts based on what you want (in this case to have a graph/loop prompt that drains all epic and milestone generations):

---

1. **Setup prompt:**
   Create graph prompts and reusable loop prompts in `loops/` to guide implementation of every Epic and Milestone. After each task, verify the result automatically and use failures to guide the next attempt. Continue until all work is complete. Pause only when human verification is required or implementation of a feature has failed five times. Update the JSON state file as work progresses.

2. **Execution prompt:**
   Run the workflow defined in `loops/` until every Epic and Milestone is complete or a pause condition is reached. Resume from the JSON state file so completed work is not repeated.