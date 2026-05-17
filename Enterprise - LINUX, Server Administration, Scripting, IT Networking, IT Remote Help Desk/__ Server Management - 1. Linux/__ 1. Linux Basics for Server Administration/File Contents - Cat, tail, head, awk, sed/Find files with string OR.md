
Find files for string1 or string2
```
grep -RIn --binary-files=without-match \
  --exclude-dir=.git \
  --exclude-dir=node_modules \
  --exclude-dir=.node_modules \
  -E "string\1|string2" .
```