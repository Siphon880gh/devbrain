
While, do, done:
```
while true; do echo ".."; sleep 1; clear; done;
```

If you have multiple echo's, there's no second do:
```
while true; do echo ".."; echo "..."; sleep 1; clear; done;
```

If you don't want the screen to keep resetting, but whether you want the output to accumulate on the terminal, you can skip the "clear":
```
while true; do echo ".."; echo "..."; sleep 1; done;
```