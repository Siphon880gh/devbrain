
List commits with commit hash short form, date, and commit message
```
6bf6d511 2021-05-04 | Created About page
184e6390 2021-05-04 | Added loading spindle
2f9d8941 2021-05-04 | Added social media icons
```

Save as an alias in your .bash_profile or equivalent:
```
alias gitl='git log --oneline --reverse --pretty=format:"%h %ad | %s" -15 --date=short -15'
```

