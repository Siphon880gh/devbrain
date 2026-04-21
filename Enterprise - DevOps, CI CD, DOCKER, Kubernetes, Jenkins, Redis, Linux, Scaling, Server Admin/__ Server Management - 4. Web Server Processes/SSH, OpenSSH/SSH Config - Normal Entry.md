## Normal entry without an alias

At `~/.ssh/config`:
```ssh
Host 555.555.5.55
    User admin
    IdentityFile ~/.ssh/id_rsa_work
```

In this example, you would connect like this:

```bash
ssh 555.555.5.55
```

SSH will automatically apply the `User` and `IdentityFile` settings from that matching entry.

Note the Host does not need to be IP, it can be:

At `~/.ssh/config`:
```ssh
Host domain.com
    User admin
    IdentityFile ~/.ssh/id_rsa_work
```
