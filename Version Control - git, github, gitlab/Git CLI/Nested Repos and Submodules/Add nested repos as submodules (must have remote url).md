
Problem: I have nested repos. How to add them as submodules at command line?

If you have nested repositories within your main repository and you want to add them as submodules, you'll need to go through a specific process. This involves removing the current directory from the main repository's tracking (if already tracked), and then adding it back as a submodule. Here's a step-by-step guide on how to do this using the command line:  
  
### Step 1: Prepare the Nested Repository  
Ensure that the nested repository (which you want to convert into a submodule) is a proper Git repository with a remote repository set up. This involves making sure it has a `.git` directory and a remote URL associated with it. You can check the remote URL by navigating into the nested repository directory and running:  
  
```bash  
git remote -v  
```  
  
### Step 2: Remove the Nested Repository from Main Repository Tracking  
Navigate back to the root of the main repository. If the nested repository's files are currently being tracked by the main repository, you need to remove them from tracking (without deleting the files themselves). Use the following command, replacing `path/to/submodule` with the actual path to the nested repository:  
  
```bash  
git rm --cached path/to/submodule  
git commit -m "Remove nested repository from tracking"  
```  
  
Note: `git rm --cached` only removes the files from Git's tracking, not from the filesystem.  
  
### Step 3: Add the Nested Repository as a Submodule  
Now, add the nested repository as a submodule. You'll need the remote URL you checked earlier. Run the following command, again replacing `path/to/submodule` with the path and `[https://example.com/repo.git](https://example.com/repo.git)` with the actual remote URL:  
  
```bash  
git submodule add [https://example.com/repo.git](https://example.com/repo.git) path/to/submodule  
git commit -m "Add nested repository as a submodule"  
```  
  
### Step 4: Verify and Initialize the Submodule  
After adding the submodule, it's a good idea to initialize and update it to make sure everything is set up correctly:  
  
```bash  
git submodule update --init --recursive  
```  
  
This command initializes your submodule and updates it to the commit specified in the main repository.  
  
### Step 5: Push Changes  
Push the changes to your main repository:  
  
```bash  
git push  
```  
  
### Optional: Add Submodule to `.gitignore`  
If you had any `.gitignore` entries related to the nested repository, you might want to review and adjust them since the directory now contains a submodule.  
  
### Final Check  
Run `git status` and `git submodule status` to ensure everything is in order and that the submodule is being tracked correctly.  
  
By following these steps, you convert a nested Git repository into a submodule of your main repository, which helps manage dependencies and maintain clear boundaries between projects.  

  

You will noticed a generated .gitmodules at the root, for example after adding submodules ./submodule1, ./submodule2 nested repos:

[submodule "path/to/submodule1"]  
    path = path/to/submodule1  
    url = https://example.com/repo1.git  
    branch = main  
  
[submodule "path/to/submodule2"]  
    path = path/to/submodule2  
    url = https://example.com/repo2.git  
    branch = main