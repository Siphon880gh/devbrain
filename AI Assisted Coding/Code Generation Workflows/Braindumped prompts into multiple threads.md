Braindumped a bunch of prompts into separate threads?

![[Pasted image 20260923020205.png]]

Run this prompt in another thread to implement them all:
```
Review the other draft chat threads for the current project and figure out a logical implementation order. Place prerequisites before the tasks that depend on them.

Afterwards, please close those chat threads and archive them if they don't go away. Then start implementing them.

Then start implementing them. Perform autoverification to check an implementation works. Only stop if need human verification. Make a git commit after each successful implementation and autoverification.

Use these typical sources in Cursor desktop:
- Workspace composer.composerData: Check selectedComposerIds and lastFocusedComposerIds to identify selected or recently focused threads.
- Global cursorDiskKV: Read composerData:<id> entries where isDraft: true. The draft prompt may be stored in text or subtitle.
- Prioritize currently selected or focused draft tabs belonging to this project.

Exclude:
- The active conversation ID—the runner executing this prompt.
- Empty stubs, including empty-state-draft.
- Incomplete one-word drafts.
- Drafts whose workspaceIdentifier points to another folder.
```