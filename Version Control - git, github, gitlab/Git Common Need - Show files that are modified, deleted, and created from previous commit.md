Why: This helpful when your organization refuses to have an online git repo / devops setup because they’re worried about security. Would not even do Github private. And they didn’t invest in automation scripts to upload all files that have been modified or newly created. So you have to remember what file changes were made so you can upload a file one at a time in FTP (often in different subfolders) when finished developing locally. However the folders are local git repos.

Then run the `git diff` command between current head and one commit older, listing the files modified, deleted, or created, but no need showing which lines  

```
pwd; git diff --name-status HEAD~1 HEAD
```

^ By having `pwd` , it’s helpful to show the folder path, especially if you have submodules nested and you’re running this inside those folders too.

Let’s say we have:

- app1/.git
- app1/onboard/.git
- app1/dashboard/.git

Example output is:

**/Users/wengffung/dev/apps/app1**
modified: assets/common.css
modified: assets/index.js
modified: index.php
modified: vlai-preview-narration (modified content)
modified: vlai-upload-images (modified content)

**/Users/wengffung/dev/apps/app1/onboard**
M index.js
M index.php

**/Users/wengffung/dev/apps/app1/dashboard**
M assets/index.js
M assets/chart.css
M index.php

---

If you want the details of what lines are changed, refer to: [[Compare commits - Common Use]]