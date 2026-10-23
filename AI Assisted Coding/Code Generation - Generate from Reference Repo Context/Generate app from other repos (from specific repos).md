Let's just say you're creating an app and you already dropped one or more repos into `context/apps/` that you want your app to be based on (or to copy features from). 

Those trees still have their own .git folders. That’s fine — leave them until origins are written into clone.sh. Then strip .git so the trees are plain folders you can gitignore. That keeps this repo small, avoids nested-git conflicts, and keeps GitHub focused on your code.

Prompt this:
```
The context-sourcing apps are already under context/apps/. Work in this order:

1. Look into every folder in context/apps/. Figure out each origin while .git still exists — prefer `git remote get-url origin`, then package.json / README if needed. Record folder name, upstream URL, and what this project should use it for. If any origin is missing, stop and ask. Do not strip .git yet.

2. Create context/clone.sh from that catalog so a fresh pull (empty apps/) can recreate the sources. The script should create context/apps/ if missing, shallow-clone each repo into context/apps/<folder>/ when that folder is missing, remove that clone's .git after a successful clone, skip folders that already exist, and be safe to re-run.

3. THEN — only after clone.sh exists and lists every app — remove every nested .git folder inside context/apps/ so they are plain folders. Leaving .git there conflicts with this repo's git. The remotes live in those .git folders, so do not delete them before clone.sh is written.

4. Gitignore /context/apps/ so a pull of this repo never brings those trees. Keep context/clone.sh and context/README.md tracked.

5. Add context/README.md that explains what context/apps/ is for this app (reference clones the agent reads; not served), why apps/ is gitignored, why clone.sh exists, that .git is stripped after clone, a catalog table (folder, upstream URL, what to use it for), and the command: bash context/clone.sh
```

Then you can prompt later:
- Adjust goal
```
Use the context/apps/ repos to [build / adapt / copy the features I want] in our app
```
