Sed syntax is OS specific. 

Here for Mac. Skips binary files:
```
LC_ALL=C find . -type f -exec sed -i '' 's/STR_OLD/STR_NEW/g' {} +
```
