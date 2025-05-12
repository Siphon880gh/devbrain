Here’s a quick breakdown of which shell files are used in **login** vs **non-login** shells:

### 🧭 Shell Config File Reference

|File|Used When?|Shell Type|
|---|---|---|
|`.bash_profile`|On **login shells** (e.g., SSH)|**Login** shell|
|`.bash_login`|(Alternative to `.bash_profile`)|**Login** shell|
|`.profile`|If `.bash_profile` not found|**Login** shell|
|`.bashrc`|On **non-login shells** (e.g., new terminal tab)|**Non-login** shell|
|`/etc/profile`|System-wide login shell config|**Login** shell|

---

### 🔁 What's the Difference?

- **Login Shell**: Invoked when you log in (e.g., via SSH or first terminal login).
- **Non-login Shell**: Invoked for each new terminal window/tab or subprocess in a GUI session.

In most desktop Linux environments, opening a new terminal **doesn't** start a login shell — so `.bashrc` runs, **not** `.bash_profile`.

> That’s why some developers "source" `.bashrc` inside `.bash_profile` to ensure consistent behavior:

```bash
# Inside ~/.bash_profile
if [ -f ~/.bashrc ]; then
  . ~/.bashrc
fi
```