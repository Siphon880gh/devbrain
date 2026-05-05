Kill older nodejs and processes stuck during development - Essential

Windows Machine:

Need to kill a Node.js server, and you don't have any other Node processes running, you can tell your machine to kill all processes named node.exe. That would look like this:

```
taskkill /f /im node.exe
```



MacOS machine:

The process is almost identical. You could either kill all Node processes running on the machine:
```
killall node
```