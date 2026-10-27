## Switch from root to a non-root user while setting up login environment (bash_profile)

When switching from `root` to another user, use a login shell:

```bash
su - nonroot_user
```

The `-` is shorthand for `--login`. It makes the new shell behave as if
`nonroot_user` had logged in directly.

### Why `su nonroot_user` is not enough

```bash
su nonroot_user
```

This switches the effective user and starts that user's configured shell, but it
does **not** create a login shell. In particular, it **does not set up the full**
**login environment**, such as the target user's home directory and login startup
files.

If the target user's shell is Bash, Bash therefore **does not automatically read**:

```text
/home/nonroot_user/.bash_profile
```

Use `su - nonroot_user` when commands depend on the target user's `HOME`,
`PATH`, version-manager setup, or other configuration loaded from
`.bash_profile` (or its shell-specific equivalent). In this setup,
`/home/nonroot_user/.bash_profile` can then run its existing line that sources
`/root/.bash_profile`.

## Why a single dash means “login”

The single dash is an old Unix convention. Login shells were historically
identified by a dash at the start of the shell's process name, for example
`-bash`. `su - user` keeps that convention as a compact way to say “start a
login shell for this user.”

The same command can be written more explicitly:

```bash
su --login nonroot_user
```

## Quick check

After switching, confirm that the user and home directory are correct:

```bash
whoami
printf '%s\n' "$HOME"
```

For a Bash shell, this also reports whether it is a login shell:

```bash
shopt -q login_shell && echo "login shell" || echo "non-login shell"
```
