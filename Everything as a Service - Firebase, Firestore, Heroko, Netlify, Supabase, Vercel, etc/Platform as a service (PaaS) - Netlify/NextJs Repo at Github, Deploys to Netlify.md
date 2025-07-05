You have a NextJS repo at github.com that you want to launch (Github Page doesn't work)

Connect your Netlify to a Github repo. It will automatically re-deploy on new commits at the main branch.
https://www.netlify.com/


---

**How on Netlify?**

At Projects home, click "Add new project" for the dropdown. Select "Import..."
![[Pasted image 20250705160502.png]]

Select "Github" on the next page:
![[Pasted image 20250705160549.png]]

Follow the next page's instructions to search for and select your Github.com repo.

---

**Make sure Netlify is setup for NextJS**

Click the "Build & deploy" panel sidebar item:
![[Pasted image 20250615090346.png]]

With NextJS:
For build command, have: `npm run build`
For publish directory, have `.next`. Recall that NextJS builds into the .next/ folder.
