You can add permanent aliases, variables, and functions that you have access to whenever you run terminal.

Find the path where your .bash_profile should be stored on your particular operating system. If the file does not exist, create the file.

Add aliases, variables, functions, etc to it. Please note your path may differ:
```
open ~/.bash_profile
```

Aliases example:
```
alias gitc='git add -A; git commit -m '
```

Variables example:
```
export BASH_SILENCE_DEPRECATION_WARNING=1
```

Functions example:
```
function newapp() { curl https://raw.githubusercontent.com/Siphon880gh/rapid-tools-suite/master/boilerplates/Newapp.php --output "./$1"; wait; code "./$1"; };
```

You'll have to close and reopen the terminal to apply the new settings. Or, you can just apply immediately with:
```
source ~/.bash_profile
```