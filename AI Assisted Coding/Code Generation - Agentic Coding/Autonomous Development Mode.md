If you have a large budget of tokens and want the AI to create code 24/7 in your harness (eg. Cursor):

Create loop prompt in md file (You can have AI generate it) against milestones and epics (per [[Plan with epics and milestones first]]). Make sure the loop prompt is optimized to go through epics and milestones, and that it will perform auto verifications, and only stop if failed at implementing after multiple attempts or auto verifications failed requiring human verification

Then activate the loop and "drain it" which means go all the way to the end of the epics and milestones. Example prompt:
```
/prompt Run LOOP.md exactly. Drain the loop to the end.
```