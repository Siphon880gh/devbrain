
For in terminal:
```
git log --pretty=format:"%h %ad" --date=short --stat $(git rev-list --max-parents=0 HEAD)..HEAD
```


For saving to text file:
```
git log --pretty=format:"%h %ad" --date=short --stat $(git rev-list --max-parents=0 HEAD)..HEAD > history.txt
```


![](tjEqxOR.png)

Save as an alias in your .bash_profile or equivalent:
```
alias gitld='git log --pretty=format:"%h %ad" --date=short --stat $(git rev-list --max-parents=0 HEAD)..HEAD > history.txt'
```