
**Get the files at:**
https://github.com/Siphon880gh/global-npm-scripts/

---

# Global npm scripts at ~/npm

By Weng Fei Fung. These are global npm scripts that you or team members run as long as they're placed at their home directory (~/npm). Speeds up migration and onboarding because your cli doesn't require editing/re-sourcing .bash_profile or .zshrc.

We take advantage of the `npm run SCRIPT --prefix ~/npm` which switches package.json directory temporarily for the command, so it's able to run npm scripts off ~/npm. The scripts will act on the current folder it's called from or in some case requires the passthrough of pwd:
```
npm run SCRIPT --prefix ~/npm `pwd` someArg
```

Running the help command will show example usage so you know which ones require passthrough of `pwd`.

## Installation

Place into ~/npm/ where ~ is the user home directory:
- Mac: /Users/USER1/npm
- Cygwin: /home/USER1/npm
- Windows Git Bash: /c/Users/USER1/npm

For any .sh file, make sure to enable execution: `chmod u+x FILE.sh`

## Usage

These can be shared among your team. They place it into their home directory, such that /Users/USER_HOME/npm/*

So when switching to calling local npm scripts, they call with:
```
npm run help --prefix ~/npm
```

The idea is that everyone has the folder relative to their home directory.

## If other than home directory

Make sure ~/npm/ or whatever path in your npm scripts is accurate on the new machine. Look at the npm scripts at package.json to adjust ~/npm if needed. If the path is changed, then the call will differ as well:
```
npm run help --prefix THEIR_DIRECTORY
```