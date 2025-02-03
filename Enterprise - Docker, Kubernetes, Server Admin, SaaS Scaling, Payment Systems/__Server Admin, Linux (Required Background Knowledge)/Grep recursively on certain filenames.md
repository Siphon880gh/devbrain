
Here's the grep command you can use:
```
grep -iRn "start:prod" --include="package.json"
```

Explanation:
-i: Makes the search case-insensitive.
-R: Recursively searches through directories.
-n: Displays the line numbers where the match occurs.
"start:prod": The string to search for.
--include="package.json": Restricts the search to files named package.json.
This will report the filename and line number of every match in package.json files.