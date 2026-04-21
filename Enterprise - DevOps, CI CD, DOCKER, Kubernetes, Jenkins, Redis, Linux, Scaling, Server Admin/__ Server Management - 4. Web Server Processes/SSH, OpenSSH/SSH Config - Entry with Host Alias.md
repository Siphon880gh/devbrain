## When an alias is actually needed

An alias is only needed when the name in `Host` is not the real destination.

For example:

```ssh
Host myserver
    HostName 555.555.5.55
    User admin
```

Here, `myserver` is just a nickname. SSH uses `HostName` to know the real server address.

Without `HostName`, SSH will literally try to connect to a machine named `myserver`.

By contrast, if your entry is already:

```ssh
Host 1.2.3.4
```

then you usually do not need `HostName`, because the `Host` value is already the actual destination.

---

## Github Deploy Keys Need Host Alias

When you have multiple repos with different SSH key, they can't all be connected to github.com, therefore you assign each repo to a different host in the SSH origin string  (instead of the SSH origin string simply connecting to the real host `github.com`). Furthermore, the normal SSH key you use for all your other repos that are paired to your personal Github account must be differentiated from the deploy SSH key associated with that one repo, therefore you are still using host aliases.

Refer to [[SSH Deploy Key Setup - Why Host Aliases Matter]]