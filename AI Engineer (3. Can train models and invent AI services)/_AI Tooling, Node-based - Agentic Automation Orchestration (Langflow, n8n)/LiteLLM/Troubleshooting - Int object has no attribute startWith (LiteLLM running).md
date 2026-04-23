AttributeError: 'int' object has no attribute 'startswith'
ERROR:    Application startup failed. Exiting.

Likely problem
```
general_settings:  
  master_key: 1234   # ❌ this is an int
```

Fix:
```
general_settings:  
  master_key: "1234"
```