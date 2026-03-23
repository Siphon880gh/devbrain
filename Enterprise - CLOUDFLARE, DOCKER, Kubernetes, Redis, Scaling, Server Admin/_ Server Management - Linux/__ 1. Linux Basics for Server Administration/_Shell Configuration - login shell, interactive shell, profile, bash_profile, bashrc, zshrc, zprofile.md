
### Interactive vs. Non-Interactive Shells

- **Interactive Shell**: A shell session where the user can interact with the shell, entering commands directly.
- **Non-Interactive Shell**: A shell that is not expecting user interaction, often used for executing scripts.


When working with Unix-like operating systems, you will encounter various shell configuration files that control your shell environment. The most common shells are Bash and Zsh, and each shell has specific files it reads for configuration. Here’s a breakdown of what these files are and their purposes:

---
## Shell configuration files,aka Shell startup files

### .profile
- **Usage**: This is a shell-independent startup file.
- **Purpose**: It is read by the Bourne shell (`sh`) and similar shells during login.
- **Execution**: Executed during login shell sessions (when you log in to the system or open a terminal login session).
- **Typical Uses**: Setting environment variables, running login scripts.

### .bash_profile
- **Usage**: Specific to the Bash shell.
- **Purpose**: It is read and executed by Bash during login shell sessions.
- **Execution**: Only executed by Bash at login, meaning when you log in to your system or start a terminal session that is a login shell (e.g., `ssh` session).
- **Typical Uses**: Setting environment variables, running startup scripts, configuring user-specific settings that should be applied only once during login.

### .bashrc
- **Usage**: Specific to the Bash shell.
- **Purpose**: It is read and executed by Bash during non-login interactive shell sessions.
- **Execution**: Every time you open a new interactive shell session that is not a login shell (e.g., opening a new terminal window or tab).
- **Typical Uses**: Aliases, shell functions, prompt customization, and other settings that need to be applied to every interactive shell session.

### .zshrc
- **Usage**: Specific to the Zsh shell.
- **Purpose**: It is read and executed by Zsh during all interactive shell sessions.
- **Execution**: Every time you open a new interactive Zsh session, regardless of whether it is a login shell or not.
- **Typical Uses**: Aliases, shell functions, prompt customization, and other settings that need to be applied to every interactive shell session.

### .zprofile
- **Usage**: Specific to the Zsh shell.
- **Purpose**: It is read and executed by Zsh during login shell sessions.
- **Execution**: Only executed by Zsh at login, meaning when you log in to your system or start a terminal session that is a login shell.
- **Typical Uses**: Setting environment variables, running startup scripts, configuring user-specific settings that should be applied only once during login.

### Summary Table

| File        | Shell         | Purpose                                         | Execution                         |
|-------------|---------------|-------------------------------------------------|-----------------------------------|
| `.profile`  | Any           | General login shell configuration               | Login shell sessions              |
| `.bash_profile` | Bash       | Bash-specific login shell configuration         | Login shell sessions (Bash)       |
| `.bashrc`   | Bash          | Bash-specific non-login interactive configuration | Non-login interactive sessions (Bash) |
| `.zshrc`    | Zsh           | Zsh-specific interactive shell configuration     | All interactive sessions (Zsh)    |
| `.zprofile` | Zsh           | Zsh-specific login shell configuration           | Login shell sessions (Zsh)        |

### Key Points

1. **Login vs. Non-login Shells**:
   - Login shells read `.profile`, `.bash_profile`, or `.zprofile`.
   - Non-login interactive shells read `.bashrc` or `.zshrc`.

2. **Bash**:
   - `.bash_profile` is executed during login shells.
   - `.bashrc` is executed during non-login interactive shells.

3. **Zsh**:
   - `.zprofile` is executed during login shells.
   - `.zshrc` is executed during all interactive shells.

4. **Hierarchy**:
   - If `.bash_profile` exists, `.profile` might not be read by Bash, depending on the system configuration.
   - Zsh reads `.zshrc` for both login and non-login interactive shells, ensuring consistent environment settings.

By understanding these distinctions, you can configure your shell environment more effectively, ensuring that your settings are applied in the correct context.

## Figure out which shell you are

Whether it's a logged in shell (aka whether it is a log shell):
```
shopt login_shell
```

Which shell you're using (z shell or bash)
```
echo $SHELL
```

Interactive ir non-interactive
If you or user can type into it, then it's interactive

Mac has switched from bash to zshell as the default. Most Linux as of 7/2024 contains zshell but defaults to bash.

---

Running .sh script

When you run a `.sh` script, it does not automatically load any shell configuration files like `.bashrc` or `.profile`. The script runs in a subshell with its own environment. If you need to source configuration files or set up the environment within your script, you can explicitly source those files by adding commands like:

```
# Check if .bashrc exists and source it
if [ -f ~/.bashrc ]; then
    source ~/.bashrc
fi


# Check if .profile exists and source it
if [ -f ~/.bash_profile ]; then
    source ~/.profile
fi

# Check if .profile exists and source it
if [ -f ~/.profile ]; then
    source ~/.profile
fi
```

---

## Nuance: Login shell configuration files chain

In Linux, when a user logs into a login shell, the shell goes through a sequence of checks to load specific configuration files. The order of checking and loading these files depends on the shell being used. For the `bash` shell, the typical sequence is as follows:

1. **Check and load `/etc/profile`**:
   - This system-wide file is executed for login shells. It sets up environment variables and configurations that apply to all users.

2. **Check and load `~/.bash_profile`**:
   - If this file exists in the user's home directory, it is executed. This is a user-specific configuration file for login shells.
   
3. **If `~/.bash_profile` does not exist, check and load `~/.bash_login`**:
   - If `~/.bash_profile` is not found, the shell looks for `~/.bash_login`. This file serves a similar purpose, but it's less commonly used.

4. **If neither `~/.bash_profile` nor `~/.bash_login` exist, check and load `~/.profile`**:
   - Finally, if neither `~/.bash_profile` nor `~/.bash_login` is found, the shell loads `~/.profile`. This file is a generic file that can be used by various shells, not just `bash`.

In summary, for `bash` login shells, the sequence is:
- `/etc/profile`
- `~/.bash_profile`
- `~/.bash_login` (if `~/.bash_profile` is not found)
- `~/.profile` (if neither `~/.bash_profile` nor `~/.bash_login` is found)

For non-login shells, `bash` will source `~/.bashrc` instead. 

This behavior ensures that user-specific configurations are applied when logging in and allows for system-wide settings to be enforced.

---

## Nuance: Interactive shell

An interactive shell thats logged in will check bashrc AND bash_profile?
**NO**

No, an interactive shell that is logged in does not typically source both `~/.bashrc` and `~/.bash_profile`. Here's a detailed explanation of the behavior:

### Login Shell
When a user logs into a shell (e.g., via SSH, console login, or a graphical login session that starts a terminal):

1. **Login Shell (Interactive or Non-interactive)**:
   - The shell reads and executes commands from `/etc/profile`, if that file exists.
   - Afterward, it looks for `~/.bash_profile`, `~/.bash_login`, and `~/.profile` (in that order) and reads and executes commands from the first one that exists and is readable.

Keypoint: Regardless if it's interactive shell, if it's logged in, it loads bash_profile like files.

### Interactive Non-Login Shell
When an interactive shell that is not a login shell is started (e.g., when you open a terminal emulator after logging into a graphical environment):

1. **Interactive Non-login Shell**:
   - The shell reads and executes commands from `~/.bashrc`, if that file exists.

### Combining `~/.bash_profile` and `~/.bashrc`
A common practice is to source `~/.bashrc` from within `~/.bash_profile`. This way, you can ensure that settings in `~/.bashrc` are applied to both login and non-login shells. This is typically done by adding the following lines to `~/.bash_profile`:

```sh
if [ -f ~/.bashrc ]; then
    . ~/.bashrc
fi
```

### Summary
- **Login Shell (interactive or non-interactive)**:
  - `/etc/profile`
  - `~/.bash_profile` (or `~/.bash_login` or `~/.profile` as fallbacks)

- **Interactive Non-login Shell**:
  - `~/.bashrc`

To ensure that `~/.bashrc` is loaded for login shells, you can source it from `~/.bash_profile`. This practice is useful to maintain a consistent shell environment for both login and non-login interactive shells.

Consequence:
## Best Practice

A common practice is to source `~/.bashrc` from within `~/.bash_profile`. This way, you can ensure that settings in `~/.bashrc` are applied to both login and non-login shells. This is typically done by adding the following lines to `~/.bash_profile`:

```
if [ -f ~/.bashrc ]; then
    . ~/.bashrc
fi
```

---

## Nuance: System wide shell configuration files

Like on Ubuntu your system wide ones are:
/etc/profile
/etc/bashrc/bashrc