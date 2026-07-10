Because you may be doing massive updates across the commit history, or an update that affects a lot of commits downstream, there's a chance of a major mess up

So it's recommended you **copy the whole folder with .git inside** before changing git history. If your repo messes up during the filter-repo or filter-branch, you can easily refer to this duplicated folder.