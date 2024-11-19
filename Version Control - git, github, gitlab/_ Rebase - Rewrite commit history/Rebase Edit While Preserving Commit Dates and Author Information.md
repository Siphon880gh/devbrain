
TLDR:
```
git rebase ... --committer-date-is-author-date
```

---


Before git rebase:
![](https://i.imgur.com/52rKPsh.png)


After git rebase, it rewrote all your previous commits to modified NOW:
![](https://i.imgur.com/M5SDaaR.png)

You don't want that. To preserve the original author and committer dates are preserved, you can:
1. Use the `--committer-date-is-author-date` flag with `git rebase`. This makes the committer date match the author date:
	```
	git rebase ... --committer-date-is-author-date
	```
^ The `...` are your other options such as interactive mode `-i` and your interested commits like `HEAD~20`.

**How about Author name and contact?**
Git preserves these by default during a git rebase, even when you amend commits that were made by other team members.