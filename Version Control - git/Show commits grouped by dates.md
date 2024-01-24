

```
git log --pretty=format:"%h %ad" --date=short --stat $(git rev-list --max-parents=0 HEAD)..HEAD
```


For saving to text file:
```
git log --pretty=format:"%h %ad" --date=short --stat $(git rev-list --max-parents=0 HEAD)..HEAD > history.txt
```


![](https://i.imgur.com/tjEqxOR.png)
