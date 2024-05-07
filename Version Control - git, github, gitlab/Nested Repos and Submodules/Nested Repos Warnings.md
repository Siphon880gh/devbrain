
When you have a main repository that contains folders of other repositories (nested repositories), Git does not automatically track the changes in these nested repositories as part of the main repository's changes. These nested repositories are treated as separate entities, each with their own separate Git history and repository management. When you run git status and sometimes when running git add -A, you’ll see a warning like this:

![](https://i.imgur.com/2bM9RxK.png)

```
On branch main                                                                           .           
Changes not staged for commit:                                                              
  (use "git add <file>..." to update what will be committed)  
  (use "git restore <file>..." to discard changes in working directory)  
  (commit or discard the untracked or modified content in submodules)  
        modified:   nested1 (modified content)  
        modified:   nested2 (modified content, untracked content)  
        modified:   nested3 (untracked content)  
        modified:   nested4 (new commits)  
  
no changes added to commit (use "git add" and/or "git commit -a")
```


It tells you there are or modified or untracked nested folders, but what it really is telling you is that git won’t stage these nested repos for your main repo. You can test this by running git add -A  and then git status  again and see that you’ll get the same warning.

The details of modified content, untracked content, both modified and untracked content doesnt matter. Another possible is “(new commits”) which is now shown in screenshot above. It just gives you extra information about the nested repos and not about the main repo itself and what it can stage and commit. For example, modified content means that nested repo has files that have changed content and you could stage/commit if you cd into that nested repo and commit there. Untracked content means you have added new files that haven’t been staged inside a nested repo. New commits mean that the nested repo is up to date however it’s still mentioned at main repo because it wants to emphasize this folder is not staged for commit (and won’t stage it either).

Adding the nested repos as submodules of your main repo DOES NOT get rid of this warning, but it does allow you to run other commands to visually get an overview of who are the nested repos, etc, so it’s best practice to add nested repos as submodules. Refer to tutorials on how.
