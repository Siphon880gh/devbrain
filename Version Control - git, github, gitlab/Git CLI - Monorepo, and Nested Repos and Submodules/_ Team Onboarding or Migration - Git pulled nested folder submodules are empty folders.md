Requirements: Your team member clones the main repo that contains git submodules. So you have already initiated submodules. What they will see are empty folders for the submodules. That's because there's still a step they need to perform besides just cloning the main repo.

![[Pasted image 20260327204555.png]]
Your team member needs to recursively pull in the code for each empty submodule folder with:
```
git submodule update --init --recursive
```

It can improve their developer experience if you have a package.json with a npm script for this:
```
  "scripts": {
    "submodules:init": "git submodule sync --recursive && git submodule update --init --recursive"
  }
```
Then they could just have ran `npm run submodules:init`

Then your README.md’s Team onboarding section should explain to run this command submodules:init, so that the submodule folders will populate with content.