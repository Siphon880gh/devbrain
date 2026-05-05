

For variables, it's best to do this:
print("/****/ description");
print(yourVariable);

That way you can quickly see where your variable is in a mess of logs in XCode terminal. If still hard, then copy the terminal (Select all) into Visual Code or some editor for you to do CMD+F / CTRL+F search for /****/. If that's too many steps you can crash the terminal at that point of printing the variable with a `fatalError()`:

```
print("/****/ description");
print(yourVariable);
fatalError()
```
