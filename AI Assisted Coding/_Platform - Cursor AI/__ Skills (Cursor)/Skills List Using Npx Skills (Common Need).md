List project's:
```
 npx skills ls
```

**List global:**
```
 npx skills ls -g
```

Note it lists skills in the universal `~/.agents/skills`, NOT in platform specific paths like `~/.cursor/skills`

---

There's no command to read the description of a specific skill or to list all the skills alongside their descriptions, unfortunately, as of 3/26/26.

But inside Cursor AI Chat, there's an IntelliSense style tooltip that appear when typing a command - pulling from the SKILL.md's description field:
![[Pasted image 20260326231028.png]]
Hover your mouse over to expand the description to full readout (not shown here).
This only works for skills that have an invokable command (the SKILL.md allows for it)

So your workflow to understand what skills you have is running
```
npx skills ls -g
```

![[Pasted image 20260326232149.png]]

Then typing the forward slash command in Cursor to see a description.