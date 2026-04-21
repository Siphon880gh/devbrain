When using SSH for authentication—whether that means logging into a server in the terminal or pushing to Git repos with SSH URLs—a **host alias is optional**. But if you choose to use one, then `Host` is the alias you make up, and `HostName` is the real server name or IP address SSH should actually connect to.

This becomes **necessary** when you have multiple repositories on your local machine that each need a different SSH key, which is common with **deploy keys**. It is also necessary when even **one** repo uses a deploy key while your other repos use normal SSH authentication with your personal GitHub account. That is because the public key used for the deploy-key repo must be different from the public key tied to your personal GitHub account. Deploy keys must also be unique per repository. The same public key cannot be reused across multiple repos or as your personal GitHub account SSH key, and GitHub will reject duplicate public keys.

![[Pasted image 20260421025715.png]]

Since those connections may all really go to `github.com`, they cannot all use the same `Host github.com` entry if you want different SSH keys for different repos. Instead, you create **different host aliases** that all point to the same real destination.

Since these repos with deploy keys can't all be connected to github.com, you assign each repo to a different host alias in the SSH origin string (instead of the SSH origin string simply connecting to the real host `github.com`)

For example, both of these aliases can still connect to GitHub:

File `~/.ssh/config`:
```ssh
Host github-personal
    HostName github.com
    User git
    IdentityFile ~/.ssh/id_ed25519_personal

Host github-clientrepo
    HostName github.com
    User git
    IdentityFile ~/.ssh/id_ed25519_clientrepo
```

Here:
- `Host` is the alias you chose
- `HostName` is the actual destination
- both aliases point to `github.com`
- each alias uses a different SSH key

That is the main reason host aliases are useful in SSH deploy key setups: they let multiple repos on the same machine connect to the same real GitHub server while using different keys without conflicting with each other.

Don't forget to upload the public key to your respective repo:
![[Pasted image 20260421041150.png]]

---

## Compared to normal SSH Config


In a normal `~/.ssh/config` if there is only one SSH pairing needed for the same domain/ip:

You can use the real hostname or IP directly as the `Host`.
```ssh
Host XXX.XXX.X.XX  
	User admin
    IdentityFile ~/.ssh/id_ed25519_personal

Host github.com
    User git
	IdentityFile ~/.ssh/id_rsa_work
```

Here:
- There is no host alias
- `Host` is the actual destination
- Usually how a normal ssh config looks when there's no deploy key or multiple SSH keys needed for github.com