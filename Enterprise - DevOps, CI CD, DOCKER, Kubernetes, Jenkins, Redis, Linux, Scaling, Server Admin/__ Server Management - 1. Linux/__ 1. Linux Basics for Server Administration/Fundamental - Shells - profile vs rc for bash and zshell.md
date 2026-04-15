For Bash: `.bash_profile` runs when you log in, while `.bashrc` runs each time you open a new terminal window. A good rule is to put environment settings like `PATH` in `.bash_profile`, and put aliases, functions, and prompt settings in `.bashrc`. It is also common to have `.bash_profile` load `.bashrc`.

For Z shell (`zsh`), the similar files are `.zprofile` and `.zshrc`. `.zprofile` is used for login shells, while `.zshrc` is used for normal interactive terminal sessions. In most cases, everyday shell settings like aliases, functions, completions, and prompt changes go in `.zshrc`. If needed, environment-level settings can go in `.zprofile`.

To check which shell you are using, run:

```bash
echo $SHELL
```