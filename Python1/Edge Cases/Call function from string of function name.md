
```
def a():
    return 1

# assert a()==1, "a() should return 1"
assert globals()["a"]()==1, "global a() should return 1"
# print(globals()["a"]())
```


In Python I have a string of a function name. How to call function from that string value?

Use case: function names saved in database, then when retrieved from database, need to be called on the page