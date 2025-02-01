
status: untested, quoted
source:https://stackoverflow.com/questions/73936598/git-push-and-pull-remote-only-work-with-sudo-mode

When managing multiple GIT repositories from multiple servers (and thus using multiple keys) you can ease this by creating a local configuration file which explicit which key is to be used for each servers.

For instance `~/.ssh/config`:

```
host your.server.com
     user git
     hostname you.server.com
     identityfile ~/.ssh/id_rsa
```

Note that it is a general format, you may have to replace the server `you.server.com` and the user name `git` to whatever is expected by your remote server.

EDIT:

According to the further details you provided, here is the `~/.ssh/config` file's content:

```
host github.com
     user git
     hostname github.com
     identityfile ~/.ssh/id_rsa
```

Ensure the `~/.ssh/config` file access is `-rw-rw-r--` to your local user.