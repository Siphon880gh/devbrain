If the nested repos are not associated with online git remote urls, you have to add them differently as submodules

```
git rm --cached one two three  
git submodule add `pwd`/one  
git submodule add `pwd`/two  
git submodule add `pwd`/three
git add -A;  
git commit -m "Add nested repository as a submodule"  
```

^ Explained at: https://stackoverflow.com/questions/6100966/nested-git-repositories-without-remotes-a-k-a-git-submodule-without-remotes

You will noticed a generated .gitmodules at the root:
```
[submodule "one"]  
	path = one  
	url = /Users/ME/dev/web/app1/one  
[submodule "two"]  
	path = two  
	url = /Users/ME/dev/web/app1/two  
[submodule "three"]  
	path = three  
	url = /Users/ME/dev/web/app1/three
```