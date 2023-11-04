
```
def a():

return 1

  

# assert a()==1, "a() should return 1"

assert globals()["a"]()==1, "global a() should return 1"

# print(globals()["a"]())
```



To be more practical:
```
def a():

return 1

  

# assert a()==1, "a() should return 1"

# assert globals()["a"]()==1, "global a() should return 1"

functionA = globals()["a"]

  

assert functionA()==1, "global a() should return 1"

# print(globals()["a"]())
```

And cleaner:
```
userChosen = "a"

def a():
    return 1

userChosenFunction = globals()[userChosen]
assert userChosenFunction()==1, "global userChosenFunction() should return 1"


```