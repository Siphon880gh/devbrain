
## Set your python version

`pyenv shell <version>`  — select just for current shell session  
`pyenv local <version>`  — automatically select whenever you are in the current directory (or its subdirectories)  
`pyenv global <version>`  — select globally for your user account

If all these are failing:
Ensure these lines are in your shell configuration file (like `~/.bashrc`, `~/.zshrc`, or `~/.bash_profile`, then reloading their configuration after saving by running `source ~/.bashrc` etc.):
```
export PATH="$HOME/.pyenv/bin:$PATH"
eval "$(pyenv init --path)"
eval "$(pyenv init -)"
```

This setup places `pyenv`'s shims directory early in your `PATH`, allowing it to intercept Python commands like `python` and `python3`.

## 7. Validate your installation of python

```
python --version
```
