
List commits with commit hash short form, date, and commit message
```
6bf6d511 2021-05-04 | Created About page
184e6390 2021-05-04 | Added loading spindle
2f9d8941 2021-05-04 | Added social media icons
```

You may want to store as alias:
```
alias gitl='echo "git log, single-line, last 15"; git log --oneline --reverse --pretty=format:"%h %ad | %s" -15 --date=short -15'
```



