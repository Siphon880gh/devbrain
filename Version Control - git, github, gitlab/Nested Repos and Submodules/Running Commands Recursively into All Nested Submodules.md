If you have nested submodules (a submodule containing another submodule), you can use the `--recursive` flag to apply the command to all levels of submodules:

git submodule foreach --recursive '<command>'  

For example, to pull changes recursively:

git submodule foreach --recursive 'git pull origin main'  

**Running the Same Command Without `git submodule foreach`**

If you prefer custom scripting, you can also write your own commands to handle this functionality.