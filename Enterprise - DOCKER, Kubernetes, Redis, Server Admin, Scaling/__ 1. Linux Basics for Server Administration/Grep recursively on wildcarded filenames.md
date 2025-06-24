
Here's the grep command you can use:
```
grep -iRn "pcregrep" --include="*.php"
```

Explanation:
-i: Makes the search case-insensitive.
-R: Recursively searches through directories.
-n: Displays the line numbers where the match occurs.
"pcregrep": The string to search for.
`--include="*.php"`: Restricts the search to files named that end with .php file extension.
This will report the filename and line number of every match.