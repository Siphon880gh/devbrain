
Exact error is:
Missing config. Run 'openclaw setup' or set gateway.mode=local (or pass --allow-unconfigured).

---

If openclaw indeed was never setup then that’s what you would do (run `openclaw setup` )

However, the message forgot that another solution is to run:
```
openclaw gateway start
```

Which is the more likely solution if Openclaw has already been setup

Terminal might look like:
![[Pasted image 20260509084317.png]]