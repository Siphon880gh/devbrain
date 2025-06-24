Kill a port:
```
lsof -ti:3000 | xargs kill -9
```

Mnemonic: lsof = list open files (files that are running at ports, shows even their filepaths). -t terse list makes it only show PID making it useful for scripting. -i is internet capable ports.

xargs = exended arguments, taking input from standard input and converting it into arguments for another command. mnemonic: extending the arguments.