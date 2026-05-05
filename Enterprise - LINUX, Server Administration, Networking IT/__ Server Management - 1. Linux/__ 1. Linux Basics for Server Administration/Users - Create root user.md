To log in or even change password as `root`, first check whether your server allows it. Open `/etc/ssh/sshd_config` and look for the `PermitRootLogin` setting. On some hosting providers, password-based root login is disabled by default (which means SSH login is only through pairing SSH key file on your local machine to the webhost's uploaded SSH key file).

Once you make sure PermitRootLogin is yes, set or reset the root password with:

```bash
sudo passwd root
```

If a root password already exists, you may be asked for the current password first. After that, you will be prompted to enter the new password and confirm it.

To test password login from your local machine, use:

```bash
ssh root@5.55.555.555
```

If you already have SSH keys configured, SSH may log you in with the key and never ask for the password. In that case, temporarily force password authentication with:

```bash
ssh -o PreferredAuthentications=password -o PubkeyAuthentication=no root@5.55.555.555
```

That only affects that one SSH command and does not permanently change your SSH setup.