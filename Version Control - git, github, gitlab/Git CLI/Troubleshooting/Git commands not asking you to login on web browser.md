Your Git-to-GitHub commands not working. You know they will likely work if you're properly authenticated. But:
## Git commands not asking you to log in through the browser?

There are two common situations:

**1. GitHub is supposed to open a browser login page, but nothing opens.**  
You see a message saying it is waiting for you to log in through the browser, but no browser window appears.

**2. You already logged in the wrong way, and now Git commands that connect to GitHub fail without asking you to log in again.**

In both cases, you may need to manually trigger GitHub authentication from the terminal.

This starts the GitHub CLI login flow in your terminal. However just because you have `git` installed, does not necessarily mean you have the cli tool to force a manual login.

### First, make sure `gh` is installed

Check whether GitHub CLI is installed:

```bash
whereis gh
```

Do not assume that having `git` installed also means you have `gh` installed. They are separate tools. Git handles version control, while `gh` helps manage GitHub authentication and related GitHub actions.

If `gh` is not installed, you can install it with Homebrew:

```bash
brew install gh
```

### Use `gh` to log in manually

Run:

```bash
gh auth login
```


CLI prompts will appear. One question will ask whether you want to authenticate Git with your GitHub credentials. Answer **Yes**.

That should open the GitHub login page in your web browser so you can finish signing in.

If your device is new, you may be asked to enter the device code at the OAuth flow pages. When googling where the device code is, people and AI will mislead you into thinking it's on your email or Gmail app. The device code has been outputted at the terminal immediately after you ran `gh auth login` and before the web browser opens the page. Look back to the terminal.

### If Git still does not use your GitHub login

Next, run:

```bash
gh auth setup-git
```

This configures Git to use GitHub CLI as its credential helper. In other words, normal Git commands such as `git push`, `git pull`, and `git clone` can use the authentication already stored by `gh`, instead of asking for a separate password or personal access token.

### Result

Once this is set up, your Git-to-GitHub commands should work normally again.