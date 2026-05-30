## What is it

You want to have find-skills SKILL installed. So you can on the fly ask to find skills to install in the prompt:
![[Pasted image 20260326225924.png]]

Then it recommends what to install and can install it for you, modifying the skills directory for you:
![[Pasted image 20260326230628.png]]

---

## How to install the find-skill SKILL.md

You might have heard of `find-skills` during your `npx skills` uses if it recommended it to you:
![[Pasted image 20260326225736.png]]

**If** installing manually, this is the command
```
 npx skills add vercel-labs/skills
```
^ Yes, you add `vercel-labs/skills` because unfortunately Vercel namespaced it as "skills" instead of "find-skills".

That adds the skill to natural language so you can prompt, eg. "Find skill that helps with CRO", and it can install the skill for you too (modifying the skills directory for you)

---

If you want to interactively find skills using CLI, that experience can be setup at [[NPX Skills - Find skill command]]