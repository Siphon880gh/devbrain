If you have a large budget of tokens and want the AI to create code 24/7 in your harness (eg. Cursor):

Create loop prompt in md file (You can have AI generate it) against milestones and epics (per [[Plan with epics and milestones first]]). Make sure the loop prompt is optimized to go through epics and milestones, and that it will perform auto verifications, and only stop if failed at implementing after multiple attempts or auto verifications failed requiring human verification

Then activate the loop and "drain it" which means go all the way to the end of the epics and milestones. Example prompt:
```
/prompt Run LOOP.md exactly. Drain the loop to the end.
```

If your computer crashed, you can return to the chat thread and prompt:
```
Continue draining the loop
```

---

This loop prompt has been implementing feature after feature for 1 hour 40 minutes so far:
![[Pasted image 20260902080736.png]]

---

Example file structure when you use prompts against milestones and epics:
![[Pasted image 20260902160513.png]]

---

You can still generate other loop prompt md files that are not related to building the entire app. For example, this is for enriching different sections of the app with more content, placed in a separate LOOPS folder rather than placed at the root:
![[Pasted image 20260902160853.png]]