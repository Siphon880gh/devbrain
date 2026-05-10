See:
```
# URL - Legacy URLs go to new /app now
rewrite ^/(apps|tool|tools)(/.*)?$ /app$2 permanent;
```