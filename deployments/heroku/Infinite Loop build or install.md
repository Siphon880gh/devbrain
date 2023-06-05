Make sure your build script at root package.json is not causing build to rerun

A corrupted git can also cause a looping build at the Heroku deployment cli. You would delete the .git, run `git init`, make your commits, and re-add origin and heroku, then push up to Heroku