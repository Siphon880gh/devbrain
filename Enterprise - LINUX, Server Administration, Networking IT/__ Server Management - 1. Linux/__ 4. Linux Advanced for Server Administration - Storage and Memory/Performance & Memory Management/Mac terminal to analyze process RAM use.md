Realtime reporting of how much RAM your processes are running

Useful when your process has features. You run those features associated with that process, then see if there are memory leaks when you're done running (You expect memory use to fall back down)

---


This example checks for wildcarded launch for process names:

```
top | head -n 12; top | grep launch
```

Look at MEM column:

![](JUkW2JT.png)

---

