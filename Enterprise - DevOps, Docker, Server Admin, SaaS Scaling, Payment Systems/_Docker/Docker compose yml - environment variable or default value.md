
Docker compose yml:
```
ports:  
- "${PORT:-3500}:${PORT:-3000}"
```

The `${...}` syntax is having Docker refer to a .env file for those keys/values, and if the .env file or those keys/value don't exist in it, Docker falls back to the default value (preceded by -)

So the above could render into:
```
ports:
- "3500:3000"
```