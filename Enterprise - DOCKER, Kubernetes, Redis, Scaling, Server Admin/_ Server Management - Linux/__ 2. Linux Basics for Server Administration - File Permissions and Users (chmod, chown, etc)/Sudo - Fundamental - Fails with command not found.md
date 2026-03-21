For example:
```
sudo python
```
Failed with command not found on some systems

You want to tell sudo to use your \$PATH which could have the cli
```
sudo env "PATH=$PATH" python 
```

  
You can also override sudo with a wrapper of that longer command. OR create alias psudo instead. 

More at [https://stackoverflow.com/questions/44726377/sudo-python-command-not-found](https://stackoverflow.com/questions/44726377/sudo-python-command-not-found)