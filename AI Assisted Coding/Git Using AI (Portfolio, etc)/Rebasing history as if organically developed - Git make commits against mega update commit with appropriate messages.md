Git can make multiple git commits at a current point in the codebase, even if you feel it's too late because you just grouped all the updates into one commit (A mega-update). It will rebase, then selectively add files and relevant lines of code for different git commits

Prompt:
- Adjust commit name.
- Adjust the date range:
	- "I'd like the git commit dates to be between 1/1/26 to 2/1/26" - OR -
	- "I'd like the git commit dates to be on the same date 1/1/26."
```
I accidentally commited all my implementations into one large commit named Mega update. Plan on how to break that commit apart into several commits as if we developed the code organically over time.

Make sure to tell space out the git commit time. I'd like the git commit dates to be between 1/1/26 to 2/1/26

Then make those git commits.
```

The mega update commit:
![[Pasted image 20260925232628.png]]

-> Becomes
![[Pasted image 20260925232729.png]]

---

Now when you push up to the remote origin, had you already pushed it up before? If that's the case, it's been diverged. You can override with `--force` like this (do so only if you know what you're doing):
```
git push origin main --force
```
