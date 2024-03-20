
git pull: Does git fetch followed by git merge
git fetch: Downloads a copy of the code from remote to local, but do not update the local files
git merge: Update the local files at the current local branch from the downloaded copy of code that was from fetch. Does not erase fetch data because the fetch data is part of the files that git keeps copies of (though will be space efficient about having exact copies between parts of git). As proof, you can run `git merge origin/main` which merges the fetch data from that remote origin branch. Or you can simply run git merge 

You can run git fetch and git merge individually. That’s useful say you want to have a copy of the current remote code to copy because you’re afraid the other team member will override it between the time you have now till when you’re ready to merge the code (when you’re done doing the current code changes)