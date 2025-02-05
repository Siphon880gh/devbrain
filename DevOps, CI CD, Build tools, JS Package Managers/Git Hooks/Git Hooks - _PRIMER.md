Can run scripts such as changing the name of the commit message, at certain events such as when committing a message

**How:**
At your local repo, open `.git/hooks`. You'll see sample files:
```
applypatch-msg.sample
pre-applypatch.sample
pre-rebase.sample
update.sample
commit-msg.sample
pre-commit.sample
pre-receive.sample
fsmonitor-watchman.sample
pre-merge-commit.sample
prepare-commit-msg.sample
post-update.sample
pre-push.sample
push-to-checkout.sample
```

You can read about a sample by opening it in a code editor or text editor. To make one of the hooks active, you could rename it so that it doesn't end with the extension .sample. For instance, to make commit-msg hook active, rename `commit-msg.sample` -> `commit-msg` OR create a file `commit-msg`.

For an example commit-msg, hook refer to: