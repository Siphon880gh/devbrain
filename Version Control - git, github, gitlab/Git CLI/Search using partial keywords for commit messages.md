
Let's say team search and it'll list all commits with the word "organ" whether or not it's partial:
```
git log --grep="organ"      
```

Result looks like:
![[Pasted image 20250508191320.png]]

Then typically you may checkout that commit:
```
git checkout 97eb05e
```

And when done checking out, you can return to your main branch with:
```
git stash
git checkout main
```