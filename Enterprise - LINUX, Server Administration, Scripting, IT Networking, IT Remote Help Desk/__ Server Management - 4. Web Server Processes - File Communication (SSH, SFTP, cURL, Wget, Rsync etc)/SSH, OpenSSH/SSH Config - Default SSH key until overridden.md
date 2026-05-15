## Global settings for all hosts

You can also set default rules for every SSH connection by using the wildcard `*`. This is not an alias. It just tells SSH to apply those settings to all hosts unless a more specific rule overrides them.

At `~/.ssh/config`:
```ssh
Host *
    AddKeysToAgent yes
    ForwardAgent yes
```

That means whenever you run:

```bash
ssh anything
```

those settings will be applied.