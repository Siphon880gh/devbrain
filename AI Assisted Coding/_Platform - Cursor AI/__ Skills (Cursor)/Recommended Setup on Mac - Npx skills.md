Npx skills is a CLI wizard installed globally via npm, developed by Vercel. It'll install specific SKILL.md from vercel's https://skills.sh directory or your provided Github name, eg. `organization/repo`.

It downloads to `~/.agents/skills` rather than `~/.cursor/skills`. This is a coding platform agnostic folder path that even Cursor looks into. The AI will have access to the skill when asked to perform the skill in a prompt or directly invoked with a forward slash command (eg. `/design`) if the SKILL.md allows invoking.

---

Example use:

Let's add a collection of design and styling skills from https://github.com/pbakaus/impeccable

You would run:
```
npx skills add pbakaus/impeccable
```
- If you dont have the skills CLI tool installed, it'll ask if you want to install it with a cli prompt accepting y/n, thanks to `npx` streamlining execution and installation.

Answer these cli wizard prompts:
![[Pasted image 20260326225657.png]]

Installs into universal `~/.agents/skills` which many coding platforms have agreed to look into for skills
- Btw, it wont add to the specific ~/.cursor/skills even if you indicated it's for the Cursor (adding to the command a specific agent selector for Cursor: `npx skills add pbakaus/impeccable -a cursor`), because Cursor has agreed to also look into the universal ~/.agents/skills.
![[Pasted image 20260326230404.png]]

As time goes on, more will have agreed to look into the universal agent skills directories. However, you can choose what platform to install into in addition to the universal agent skills directory (eg. OpenClaw as of 3/26/26):
![[Pasted image 20260326230137.png]]

Press up/down/space to select specific skill(s):
![[Pasted image 20260326225644.png]]